<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\API\Customer\AuthRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $auth_repository;

    public function __construct()
    {
        $this->auth_repository = new AuthRepository();
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), ['phone' => 'required', 'password' => 'required']);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $customer = $this->auth_repository->getCustomerByPhone($request);
            if (!isset($customer)) {
                throw new \Exception('User does not exist, Please enter valid credentials.', 201);
            }

            if ($customer->is_active == 0) {
                throw new \Exception('Your account is deactivated, Please contact support team.', 201);
            }

            if (!Hash::check($request->password, $customer->password)) {
                throw new \Exception('Invalid credentials.', 201);
            }

            $session_response           = generate_session_token_with_expiration();
            $customer->token            = $session_response['token'];
            $customer->token_expired_at = $session_response['expired_at'];
            $customer->device_type      = $request->get('device_type', null);
            $customer->device_token     = $request->get('device_token', null);
            $customer->save();
            if(isset($customer)){
                $organizations = $this->auth_repository->getCustomerAdminOrganizations($customer);
            }

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Login.',
                    'data'    => [
                        'customer'      => $this->prepare_customers_data($customer),
                        'organizations' => $organizations
                    ]
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function register(Request $request)
    {
        try {
            $data      = $request->all();
            $validator = Validator::make($data, [
                'name'     => 'required',
                'phone'    => 'required',
                'email'    => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $check_phone_exist = $this->auth_repository->getCustomerByPhone($request);
            if (isset($check_phone_exist)) {
                throw new \Exception('Phone has already in use, Please try different.', 201);
            }

            $check_email_exist = $this->auth_repository->getCustomerByEmail($request);
            if (isset($check_email_exist)) {
                throw new \Exception('Email has already in use, Please try different.', 201);
            }

            if (!empty($request->hasFile('picture'))) {
                $file_name_with_extension = sha1(time() . rand()) . '.' . $request->file('picture')->getClientOriginalExtension();
                $request->file('picture')->move(public_path('uploads/customers'), $file_name_with_extension);
                $data['picture'] = upload_image_to_bucket($file_name_with_extension, 'uploads/customers');
            }

            $session_response         = generate_session_token_with_expiration();
            $data['token']            = $session_response['token'];
            $data['token_expired_at'] = $session_response['expired_at'];
            $data['device_type']      = $request->get('device_type', null);
            $data['device_token']     = $request->get('device_token', null);
            $data['password']         = bcrypt($data['password']);
            $data['is_active']        = 1;

            $customer_response = $this->auth_repository->store($data);
            $request->request->add(['customer_id' => $customer_response->id]);
            $customer = $this->auth_repository->getCustomerById($request);

            $otp           = mt_rand(100000, 999999);
            $email_address = $customer->email;
            Mail::send('emails.authentications.otp', array('otp' => $otp),
                function ($message) use ($email_address) {
                    $message
                        ->to($email_address)
                        ->subject('Account Verification OTP');
                });

            $sms_message = 'Your OTP is ' . $otp;
            // send_sms($sms_message, $customer_response->phone, $request->get('organization_id'));
            $customer->otp = $otp;
            $customer->save();

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Register.',
                    'data'    => [
                        'customer' => $this->prepare_customers_data($customer)
                    ]
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), ['otp' => 'required']);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $customer = $this->auth_repository->getCustomerById($request);

            if (empty($customer->otp)) {
                throw new \Exception('Please resend the OTP', 201);
            }

            if (!empty($customer->otp) && $customer->otp !== $request->get('otp')) {
                throw new \Exception('Invalid OTP, Please enter valid account verification code', 201);
            }

            $customer->otp = null;
            $customer->save();

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Verified.'
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function resendOTP(Request $request)
    {
        try {
            $customer = $this->auth_repository->getCustomerById($request);

            $otp           = mt_rand(100000, 999999);
            $email_address = $customer->email;
            Mail::send('emails.authentications.otp', array('otp' => $otp),
                function ($message) use ($email_address) {
                    $message
                        ->to($email_address)
                        ->subject('Account Verification OTP');
                });

            // todo: need to add logic to send sms
            $customer->otp = $otp;
            $customer->save();

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'OTP has been resent.'
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->auth_repository->removeSession($request->all());

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Logout.'
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function getProfile(Request $request)
    {
        try {
            $customer = $this->auth_repository->getCustomerById($request);
            if (!isset($customer)) {
                throw new \Exception('User does not exist.', 201);
            }

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Your profile has been retrieved.',
                    'data'    => [
                        'customer' => $this->prepare_customers_data($customer)
                    ]
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $data      = $request->except('customer_id', 'token');
            $validator = Validator::make($data, [
                'name'   => 'required',
                'gender' => 'in:male,female,other'
            ]);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            if (!empty($request->get('picture'))) {
                $base_64_picture  = explode(";base64,", $request->get('picture'));
                $exploded_picture = explode("image/", $base_64_picture[0]);
                $image_type       = $exploded_picture[1];
                $image_base64     = base64_decode($base_64_picture[1]);
                $file             = sha1(time() . rand()) . '.' . $image_type;
                file_put_contents('uploads/customers/' . $file, $image_base64);
                $data['picture'] = upload_image_to_bucket($file, 'uploads/customers');
            }

            unset($data['identifier']);
            $this->auth_repository->update($data, $request->get('customer_id'));
            $customer = $this->auth_repository->getCustomerById($request);

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Your profile has been updated.',
                    'data'    => [
                        'customer' => $this->prepare_customers_data($customer)
                    ]
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $data      = $request->all();
            $validator = Validator::make($data, ['phone' => 'required']);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $customer = $this->auth_repository->getCustomerByPhone($request);
            if (!isset($customer)) {
                throw new \Exception('User does not exist, Please enter valid credentials.', 201);
            }

            if ($customer->is_active == 0) {
                throw new \Exception('Your account is deactivated, Please contact support team.', 201);
            }

            $reset_password_token = mt_rand(100000, 999999);
            $email_address        = $customer->email;
            Mail::send('emails.authentications.reset', array('reset_password_token' => $reset_password_token),
                function ($message) use ($email_address) {
                    $message
                        ->to($email_address)
                        ->subject('Reset Password');
                });

            // $sms_message = 'Your reset password token is ' . $reset_password_token;
            // send_sms($sms_message, $customer->phone, $request->get('organization_id'));

            $customer->reset_password_token = $reset_password_token;
            $customer->save();

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Reset password token has been sent to your registered email.'
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $data      = $request->all();
            $validator = Validator::make($data, [
                'phone'                => 'required',
                'reset_password_token' => 'required',
                'password'             => 'required'
            ]);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $customer = $this->auth_repository->getCustomerByPhone($request);
            if (!isset($customer)) {
                throw new \Exception('User does not exist, Please enter valid credentials.', 201);
            }

            if ($customer->reset_password_token != $data['reset_password_token']) {
                throw new \Exception('Your reset password token is invalid.', 201);
            }

            $customer->password             = bcrypt($data['password']);
            $customer->reset_password_token = null;
            $customer->save();

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Your password has been changed successfully.'
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $data      = $request->all();
            $validator = Validator::make($data, [
                'old_password' => 'required',
                'password'     => 'required'
            ]);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $customer = $this->auth_repository->getCustomerById($request);
            if (!isset($customer)) {
                throw new \Exception('No record found.', 201);
            }

            if (!Hash::check($request->get('old_password'), $customer->password)) {
                throw new \Exception('Please enter the correct existing password.', 201);
            }

            $customer->password = bcrypt($data['password']);
            $customer->save();

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Your password has been changed.'
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function deactivate(Request $request)
    {
        try {
            $customer = $this->auth_repository->getCustomerById($request);

            $customer->is_active = 0;
            $customer->save();

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Your account has been deactivated.'
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    private function prepare_customers_data($customer): array
    {

        return [
            'id'                      => check_empty($customer, 'id', 0),
            'slug'                    => check_empty($customer, 'slug', ''),
            'name'                    => check_empty($customer, 'name', ''),
            'type'                    => check_empty($customer, 'type', ''),
            'phone'                   => check_empty($customer, 'phone', ''),
            'email'                   => check_empty($customer, 'email', ''),
            'picture'                 => !empty($customer) && !empty($customer->picture)
                ? config('constants.s3.asset_url') . $customer->picture
                : '',
            'gender'                  => check_empty($customer, 'gender', ''),
            'birth_date'              => isset($customer) && !empty($customer->birth_date)
                ? Carbon::createFromTimestamp(strtotime($customer->birth_date))->format('d M Y')
                : '',
            'session_token'           => check_empty($customer, 'token', ''),
            'internal_notes'          => check_empty($customer, 'internal_notes', ''),
            'otp'                     => check_empty($customer, 'otp', ''),
            'is_active'               => isset($customer->is_active) && $customer->is_active > 0,
        ];
    }
}
