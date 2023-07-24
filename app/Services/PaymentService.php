<?php

namespace App\Services;

use App\Models\Organization;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService
{
    protected $organization;
    protected $fatoorah_service;

    public function __construct()
    {
        $this->organization     = new Organization();
        $this->fatoorah_service = new FatoorahService();
    }

    public function create_charge_url($id, $cost, $customer, $organization_id = 1, $type = 'booking')
    {
        $organization    = $this->organization->where('id', $organization_id)->first();
        $payment_gateway = isset($organization) && !empty($organization->payment_gateway)
            ? $organization->payment_gateway
            : 'fatoorah';

        $charge_id = $charge_url = '';
        switch ($payment_gateway) {
            case 'fatoorah':
                $fatoorah_response = $this->fatoorah_service
                    ->initiatePayment(
                        $id, $cost, $customer, $organization_id, $type
                    );

                $charge_id  = check_empty($fatoorah_response, 'invoiceId', '');
                $charge_url = check_empty($fatoorah_response, 'invoiceURL', '');
                break;
            case 'u-payments':
                $u_payment_response = $this->create_charge_on_u_payments(
                    $id, $cost, $customer, $organization_id, $type
                );
                
                $charge_url = check_empty((array)$u_payment_response, 'paymentURL', '');
                break;
        }

        return [
            'charge_id'  => $charge_id,
            'charge_url' => $charge_url
        ];
    }

    public function create_charge_on_u_payments($id, $cost, $customer, $organization_id = 1, $type = 'booking', $is_sandbox = true)
    {
        try {
            $fields = array(
                'merchant_id' => '1201',
                'username'    => 'test',
                'password'    => stripslashes('test'),
                'api_key'     => $is_sandbox ? 'jtest123' : password_hash('API_KEY', PASSWORD_BCRYPT),
                'order_id'    => time(),
                'total_price' => $cost,
                'CstFName'    => check_empty($customer, 'name', 'Guest'),
                'CstEmail'    => check_empty($customer, 'email', 'guest@ecommerce.com'),
                'CstMobile'   => check_empty($customer, 'phone', '12345678'),
                'success_url' => config('constants.s3.asset_url') . 'u-payments/callback',
                'error_url'   => config('constants.s3.asset_url') . 'u-payments/callback',
                'test_mode'   => 1,
                'reference'   => $id
            );

            $curl_init = curl_init();
            curl_setopt($curl_init, CURLOPT_URL, 'https://api.upayments.com/test-payment');
            curl_setopt($curl_init, CURLOPT_POST, 1);
            curl_setopt($curl_init, CURLOPT_POSTFIELDS, http_build_query($fields));

            curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl_init);
            curl_close($curl_init);

            $response = json_decode($response, true);
            if (!empty($response) && $response['status'] !== 'success') {
                throw new \Exception('Something went wrong.', 201);
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('u-payments payment error ... ' . $e->getFile() . ', ' . $e->getMessage() . ', ' . $e->getCode());
            return false;
        }
    }
}
