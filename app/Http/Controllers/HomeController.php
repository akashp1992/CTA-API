<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\Organization;
use App\Models\User;
use App\Models\Inventory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Repositories\API\Customer\BookingRepository;
use App\Repositories\HomeRepository;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    protected $homeRepository, $userRepository, $booking_repository;

    public function __construct()
    {
        $this->homeRepository = new HomeRepository();
        $this->userRepository = new UsersRepository();
        $this->booking_repository = new BookingRepository();
    }

    public function index()
    {
        return view('home.index');
    }

    public function profile()
    {
        return view('profile');
    }

    public function changePassword()
    {
        return view('change_password');
    }

    public function updatePassword(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, [
                'old_password' => 'required',
                'password'     => 'required|same:confirm_password',
            ]);
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('change_password')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $user_id = $request->get('id', 0);
            if ($user_id == 0) {
                throw new \Exception('Something went wrong, please try again later.');
            }

            $user = $this->userRepository->getUserById($user_id);
            if (!Hash::check($data['old_password'], $user->password)) {
                throw new \Exception('Please enter the correct old password.');
            }

            $user_data             = $request->only('id', 'password');
            $user_data['password'] = bcrypt($user_data['password']);
            $this->userRepository->updatePassword($user_data);

            $notification = prepare_notification_array('success', 'User added successfully.');
            DB::commit();
            Auth::logout();
            return redirect()->route('home')->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()->route('change_password')->with('notification', $notification);
        }
    }

    public function validateUnique(Request $request)
    {
        try {
            $data      = $request->all();
            $validator = Validator::make($data, [
                'table' => 'required|in:users,companies,suppliers,coupons,inventories,services,service_categories',
                'field' => 'required'
            ]);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $modal = new User();
            switch ($data['table']) {
                case 'users':
                    $modal = new User();
                    break;
                case 'companies':
                    $modal = new Company();
                    break;
                case 'suppliers':
                    $modal = new Supplier();
                    break;
                case 'coupons':
                    $modal = new Coupon();
                    break;
                case 'inventories':
                    $modal = new Inventory();
                    break;
                case 'services':
                    $modal = new Service();
                    break;
                case 'service_categories':
                    $modal = new ServiceCategory();
                    break;
                default:
                    break;
            }

            if (isset($data['id']) && $data['id'] > 0) {
                $count = $modal->where('id', '!=', $data['id'])
                    ->where($data['field'], $data[ $data['field'] ])
                    ->where('organization_id', session()->get('organization_id'))
                    ->get()
                    ->count();
            } else {
                $count = $modal->where($data['field'], $data[ $data['field'] ])
                    ->where('organization_id', session()->get('organization_id'))
                    ->get()
                    ->count();
            }

            if ($count > 0) {
                echo 'false';
                exit;
            }

            echo 'true';
            exit;
        } catch (\Exception $e) {
            echo 'false';
            exit;
        }
    }

    public function removeFile(Request $request)
    {
        try {
            $this->homeRepository->removeFile($request);

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Poof! Your item has been deleted!'
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

    public function updateState(Request $request)
    {
        DB::beginTransaction();
        try {
            $is_active = $this->homeRepository->updateState($request->get('module'), $request->get('id'));

            DB::commit();
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'State has been updated for the selected module.',
                    'data'    => [
                        'is_active' => $is_active
                    ]
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function selectOrganization(Request $request)
    {
        $id           = $request->get('id');
        $organization = Organization::where('id', $id)->first();

        session()->put('organization_id', $id);
        session()->put('organization_name', $organization->name);
        session()->put('organization', $organization);

        return response()
            ->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Selected organization has been set in the session.',
            ]);
    }

    public function error401()
    {
        return view('errors.401');
    }

    public function bookingScan($slug, $type)
    {
        try {
            if ($type == 'booking') {
                $data = $this->booking_repository->getBookingBySlug($slug);
            }

            if (!isset($data)) {
                echo "<pre>";
                print_r('un-authenticate.');
                echo "</pre>";
                exit;
            }

            return view('booking_scan', compact('data'));
        } catch (\Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            echo "</pre>";
            exit;
        }
    }

    public function databaseBackup(){
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        $backup_name        = "mybackup.sql";
        $get_all_table_query = "SHOW TABLES ";
        $result = DB::select(DB::raw($get_all_table_query));

        $prep = "Tables_in_$DbName";
        foreach ($result as $res){
            $tables[] =  $res->$prep;
        }

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = '';
        foreach($tables as $table)
        {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();

            foreach($show_table_result as $show_table_row)
            {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();

            for($count=0; $count<$total_row; $count++)
            {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "'" . implode("','", $table_value_array) . "');\n";
            }
        }
        $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        ob_clean();
        flush();
        readfile($file_name);
        unlink($file_name);
    }
}
