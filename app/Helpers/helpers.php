<?php

use App\Models\Company;
use App\Models\Coupon;
use App\User;
use Carbon\Carbon;

if (!function_exists('prepare_notification_array')) {
    function prepare_notification_array($type = 'warning', $message = 'no message found')
    {
        return [
            'type'    => $type,
            'message' => $message,
        ];
    }
}

if (!function_exists('prepare_json_notification_array')) {
    function prepare_json_notification_array($type = 'warning', $message = 'no message found')
    {
        return [
            'code'    => ($type == 'success') ? 200 : 400,
            'type'    => $type,
            'message' => $message,
        ];
    }
}

if (!function_exists('prepare_header_html')) {
    function prepare_header_html($module = 'users', $type = '', $id = 0)
    {
        $accesses_urls = [];
        $is_root_user  = 0;
        if (auth()->check()) {
            $user_group          = auth()->user()->group;
            $is_root_user        = auth()->user()->is_root_user && auth()->user()->is_root_user > 0 ? 1 : 0;
            $user_group_accesses = isset($user_group) && !empty($user_group) ? $user_group->accesses : [];
            if (isset($user_group_accesses) && !empty($user_group_accesses)) {
                foreach ($user_group_accesses as $access) {
                    $accesses_urls[] = $access->module;
                }
            }
        }

        $header_html = '';
        if (isset($type) && $type == 'listing' && !in_array($module, ['inquiries', 'bookings'])) {
            if ($is_root_user == 1 || in_array($module . '.create', $accesses_urls)) {
                $header_html = '<a href="' . route($module . ".create") . '" class="btn btn-primary font-weight-bolder">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                                            </g>
                                        </svg>
                                    </span>
                                New Record</a>';
            }
        }

        if (isset($type) && $type == 'manage' && !in_array($module, ['inquiries'])) {
            $header_html .= '<a href="' . route($module . ".index") . '" class="btn btn-primary font-weight-bolder">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
                                                <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
                                            </g>
                                        </svg>
                                    </span>
                                    Back</a>';
        }

        if (isset($type) && $type == 'display') {
            if ($is_root_user == 1 || in_array($module . '.edit', $accesses_urls)) {
                $header_html = '<a href="' . route($module . ".index") . '" class="btn btn-outline-secondary font-weight-bolder mr-3">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
                                                <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
                                            </g>
                                        </svg>
                                    </span>
                                    Back
                                </a>';

                if ($module === 'customers') {
                    $header_html .= '<a href="' . route('addresses.create', [$id]) . '" class="btn btn-outline-secondary font-weight-bolder mr-3">
                                    <i class="fa fa-plus-square"></i>
                                    Add Address
                                </a>';
                }
                if (!in_array($module, ['inquiries', 'bookings', 'inventories', 'purchase_inventories'])) {
                    $header_html .= '<a href="' . route($module . ".edit", [$id]) . '" class="btn btn-primary font-weight-bolder">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                            </g>
                                        </svg>
                                    </span>
                                    Edit Record</a>';
                }
            }
        }

        return $header_html;
    }
}

if (!function_exists('check_email_address')) {
    function check_email_address($email_address)
    {
        // $good_characters = '/^[A-Za-z0-9\._-]+@([A-Za-z][A-Za-z0-9-]{1,62})(\.[A-Za-z][A-Za-z0-9-]{1,62})+$/';
        $good_characters = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
        $is_valid        = true;
        if (!preg_match($good_characters, $email_address)) {
            $is_valid = false;
        }
        return $is_valid;
    }
}

if (!function_exists('check_empty')) {
    /**
     * Check if given field is empty or not
     * @param $data
     * @param string $field_name
     * @param null $default_response
     * @return null
     */
    function check_empty($data, $field_name = '', $default_response = null)
    {
        $data = is_object($data) ? $data->toArray() : $data;
        return !empty($data) && !empty($data[ $field_name ]) ? $data[ $field_name ] : $default_response;
    }
}

if (!function_exists('is_token_active')) {
    function is_token_active($timestamp)
    {
        if (Carbon::parse($timestamp)->gte(Carbon::now())) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('generate_session_token_with_expiration')) {
    function generate_session_token_with_expiration()
    {
        $encrypted_string = \Illuminate\Support\Facades\Hash::make(rand() . time() . rand());
        $encrypted_string = str_replace(' ', '-', $encrypted_string);
        $token_string     = preg_replace('/[^A-Za-z0-9\-]/', '', $encrypted_string);

        return [
            'token'      => $token_string,
            'expired_at' => Carbon::now()->addDays(30),
        ];
    }
}

if (!function_exists('generate_slug')) {
    function generate_slug($for = '', $field = 'slug')
    {
        $modal = new User();
        switch ($for) {
            case 'organizations':
                $modal = new \App\Models\Organization();
                break;
            case 'groups':
                $modal = new \App\Models\Group();
                break;
            case 'users':
                $modal = new User();
                break;
            case 'customers':
                $modal = new \App\Models\Customer();
                break;
            case 'expense_categories':
                $modal = new \App\Models\ExpenseCategory();
                break;
            case 'expenses':
                $modal = new \App\Models\Expense();
                break;
            case 'coupons':
                $modal = new \App\Models\Coupon();
                break;
            case 'pages':
                $modal = new \App\Models\Page();
                break;
            case 'note':
                $modal = new \App\Models\Note();
                break;
            case 'bookings':
                $modal = new \App\Models\Booking();
                break;
            case 'day_closings':
                $modal = new \App\Models\DayClosing();
                break;
            default:
                break;
        }

        regenerate:
        $random_string = isset($field) && $field === 'identifier' ? strtoupper(\Illuminate\Support\Str::orderedUuid()) : strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($modal->where($field, $random_string)->count()) {
            goto regenerate;
        }

        return $random_string;
    }
}

if (!function_exists('get_configurations_data')) {
    function get_configurations_data($key = '', $organization_id = 1)
    {
        $organization_id = session()->has('organization_id') ? session()->get('organization_id') : $organization_id;
        $configuration   = new \App\Models\Configuration();

        if ($key !== '') {
            $configurations = $configuration
                ->where('organization_id', $organization_id)
                ->where('key', $key)
                ->pluck('value', 'key')
                ->toArray();
        } else {
            $configurations = $configuration
                ->where('organization_id', $organization_id)
                ->pluck('value', 'key')
                ->toArray();
        }

        $subdomain                           = count(explode('.', request()->getHost())) == 3 ? explode('.', request()->getHost())[0] : 'console';
        $configurations['organization_name'] = \App\Models\Organization::where('identifier', $subdomain)->value('name');

        return $configurations;
    }
}

if (!function_exists('get_open_class')) {
    function get_open_class($current, $array)
    {
        if (in_array($current, $array)) {
            return 'menu-item-open';
        }
        return '';
    }
}

if (!function_exists('get_active_class')) {
    function get_active_class($current, $array, $sub_menu = false)
    {
        if (in_array($current, $array)) {
            $return = 'menu-item-active';
            if ($sub_menu) {
                $return .= ' menu-item-open';
            }
            return $return;
        }
        return '';
    }
}

if (!function_exists('prepare_listing_action_buttons')) {
    function prepare_listing_action_buttons($module = 'users', $slug = 0, $accesses_urls = [], $id = 0, $if_only_label = false)
    {
        $is_root_user = auth()->check() && auth()->user()->is_root_user && auth()->user()->is_root_user > 0 ? 1 : 0;

        $listing_action_button = '';
        if ($module === 'inventories') {
            $listing_action_button .= '<a href="javascript:void(0);" class="manage_inventory" id="manage_inventory" data-inventory-slug="' . $slug . '"
                >Manage Inventory</a>
                <span class="text-primary">&nbsp; | &nbsp;</span>';
        }

        if ($is_root_user == 1 || in_array($module . '.show', $accesses_urls)) {
            $listing_action_button .= '<a href="' . route($module . ".show", $slug) . '">Show</a>';
        }

        if ($is_root_user == 1 && !in_array($module, ['inquiries'])
            || (in_array($module . '.show', $accesses_urls)
                && in_array($module . '.edit', $accesses_urls))) {
            $listing_action_button .= '<span class="text-primary">&nbsp; | &nbsp;</span>';
        }

        if (($is_root_user == 1 || in_array($module . '.edit', $accesses_urls))
            && !in_array($module, ['inquiries', 'bookings'])) {
            if ($if_only_label) {
                $listing_action_button .= '<a>Edit</a>';
            } else {
                $listing_action_button .= '<a href="' . route($module . ".edit", $slug) . '">Edit</a>';
            }
        }

        if ($is_root_user == 1 && !in_array($module, ['inventories'])
            || (in_array($module . '.edit', $accesses_urls)
                && in_array($module . '.delete', $accesses_urls))) {
            $listing_action_button .= '<span class="text-primary">&nbsp; | &nbsp;</span>';
        }

        if ($is_root_user == 1 && !in_array($module, ['inventories']) || in_array($module . '.delete', $accesses_urls)) {
            if ($module == 'groups' && $id <= 4) {
                $listing_action_button .= '<span class="cursor-pointer" title="You can not delete default user groups">Delete</span>';
            } else if ($module == 'organizations' && $id <= 1) {
                $listing_action_button .= '<span class="cursor-pointer" title="You can not delete default user groups">Delete</span>';
            } else {
                $listing_action_button .= '<a href="javascript:void(0);" class="delete_item">Delete</a>
                            <form class="delete_item_form" action="' . route($module . ".destroy", $slug) . '" method="POST" style="display: none;">
                            <input type="hidden" name="_method" value="DELETE">' . csrf_field() . '</form>';
            }
        }

        return !empty($listing_action_button) ? $listing_action_button : '-';
    }
}

if (!function_exists('validate_customer_and_session_token')) {
    function validate_customer_and_session_token($customer_id, $token)
    {
        $customer_response = \App\Models\Customer::where('id', '=', $customer_id)->first();
        if (!isset($customer_response)) {
            return false;
        }

        if (!empty($customer_response)
            && (empty($customer_response->token) || empty($customer_response->token_expired_at))) {
            return false;
        }

        $session_token_expired_at = '';
        if ($token == $customer_response->token) {
            $session_token_expired_at = $customer_response->token_expired_at;
        }

        if (!is_token_active($session_token_expired_at)) {
            return false;
        }

        return $customer_response;
    }
}

if (!function_exists('info_circle')) {
    function info_circle($content)
    {
        $info_icon = '';
        if (!empty($content)) {
            $info_icon = '<i class="fa fa-info-circle text-secondary-outline ml-2"
                        data-toggle="popover"
                        data-placement="top"
                        data-content="' . $content . '"></i>';
        }

        return $info_icon;
    }
}

if (!function_exists('upload_attachment')) {
    function upload_attachment($request, $field_name, $path, $request_from = '')
    {
        $file_name_with_directory = $mime_type = '';
        $old_attachment           = $request->get('old_' . $field_name, '');
        if (isset($old_attachment) && !empty($old_attachment)) {
            $file_name_with_directory = $old_attachment;
        }

        if (!empty($request->hasFile($field_name))) {
            $file_name_with_extension = sha1(time() . rand()) . '.' . $request->file($field_name)->getClientOriginalExtension();
            $mime_type                = $request->file($field_name)->getMimeType();
            $request->file($field_name)->move(public_path($path), $file_name_with_extension);
            $file_name_with_directory = upload_image_to_bucket($file_name_with_extension, $path);
        }

        return in_array($request_from, ['courses', 'announcements', 'lessons', 'introductions', 'questions'])
            ? ['attachment' => $file_name_with_directory, 'mime_type' => $mime_type]
            : $file_name_with_directory;
    }
}

if (!function_exists('upload_image_to_bucket')) {
    function upload_image_to_bucket($file_name, $directory = 'uploads')
    {
        return $file_name_with_directory = $directory . '/' . $file_name;

        $s3 = new \Aws\S3\S3Client([
            'version'     => 'latest',
            'region'      => config('constants.s3.region'),
            'credentials' => [
                'key'    => config('constants.s3.access_key'),
                'secret' => config('constants.s3.access_secret'),
            ],
        ]);

        $s3->putObject(array(
            'Bucket'     => config('constants.s3.bucket'),
            'Key'        => $file_name_with_directory,
            'SourceFile' => public_path($file_name_with_directory),
            'ACL'        => 'public-read',
        ));

        if (strpos($directory, 'lessons') !== false
            || strpos($directory, 'introductions') !== false
            || strpos($directory, 'questions') !== false) {
            //
        } else {
            unlink(public_path($file_name_with_directory));
        }

        return $file_name_with_directory;
    }
}

if (!function_exists('get_aws_object')) {
    function get_aws_object($file_name)
    {
        $s3 = new \Aws\S3\S3Client([
            'version'     => 'latest',
            'region'      => config('constants.s3.region'),
            'credentials' => [
                'key'    => config('constants.s3.access_key'),
                'secret' => config('constants.s3.access_secret'),
            ],
        ]);

        return $s3->getObject(array(
            'Bucket' => config('constants.s3.canned_bucket'),
            'Key'    => $file_name,
        ));
    }
}

if (!function_exists('get_objects')) {
    function get_objects()
    {
        $s3 = new \Aws\S3\S3Client([
            'version'     => 'latest',
            'region'      => config('constants.s3.region'),
            'credentials' => [
                'key'    => config('constants.s3.access_key'),
                'secret' => config('constants.s3.access_secret'),
            ],
        ]);

        $objects         = $s3->getPaginator('ListObjects', ['Bucket' => 'diet']);
        $private_objects = $s3->getPaginator('ListObjects', ['Bucket' => 'diet-private']);

        $objects_array = [];
        foreach ($objects as $object) {
            foreach ($object['Contents'] as $object_content) {
                if (strpos($object_content['Key'], 'uploads/') !== false) {
                    $objects_array[] = $object_content['Key'];
                }
            }
        }

        $private_objects_array = [];
        foreach ($private_objects as $private_object) {
            foreach ($private_object['Contents'] as $private_object_content) {
                if (strpos($private_object_content['Key'], 'uploads/') !== false) {
                    $private_objects_array[] = $private_object_content['Key'];
                }
            }
        }

        return [
            'public_objects'  => $objects_array,
            'private_objects' => $private_objects_array,
        ];
    }
}

if (!function_exists('delete_aws_object')) {
    function delete_aws_object($file_name, $bucket_name)
    {
        if (!empty($file_name)) {
            $s3 = new \Aws\S3\S3Client([
                'version'     => 'latest',
                'region'      => config('constants.s3.region'),
                'credentials' => [
                    'key'    => config('constants.s3.access_key'),
                    'secret' => config('constants.s3.access_secret'),
                ],
            ]);

            return $s3->deleteObject(array(
                'Bucket' => $bucket_name,
                'Key'    => $file_name,
            ));
        }
    }
}

if (!function_exists('send_sms')) {
    function send_sms($customer, $sms_content = '', $organization_id = 1)
    {
        $configuration = get_configurations_data('', $organization_id);
        $curl          = curl_init();
        $url           = 'https://api.future-club.com/falconapi/fccsms.aspx';
        $url           .= '?IID=' . $configuration['account_id'];
        $url           .= '&UID=' . $configuration['uid'];
        $url           .= '&P=' . $configuration['password'];
        $url           .= '&S=' . urlencode($configuration['sender']);
        $url           .= '&G=965' . $customer->phone;
        $url           .= '&M=' . urlencode($sms_content);
        $url           .= '&L=L';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);
        $error    = curl_error($curl);

        curl_close($curl);

        if ($error) {
            \Illuminate\Support\Facades\Log::info('sms log', ["cURL Error #:" . $error]);
            return false;
        } else {
            \Illuminate\Support\Facades\Log::info('sms log', [json_encode($response)]);
            return true;
        }
    }
}

if (!function_exists('prepare_active_button')) {
    function prepare_active_button($module_name, $module)
    {
        $html = '<a href="javascript:void(0);"
                       class="text-decoration-none update_state"
                       data-module="' . $module_name . '" data-id="' . $module->id . '">';

        if (isset($module->is_active) && $module->is_active == 1) {
            $html   .= '<i class="fa fa-check text-success"></i>';
            $status = 'Active';
        } else {
            $html   .= '<i class="fa fa-times text-danger"></i>';
            $status = 'InActive';
        }

        $html .= '<p class="d-none">' . $status . '</p></a>';
        return $html;
    }
}

if (!function_exists('index_module_header')) {
    function index_module_header($module_data)
    {
        $title        = !empty($module_data['title']) ? $module_data['title'] : '-';
        $description  = !empty($module_data['description']) ? $module_data['description'] : '';
        $index_header = '<h3 class="card-label">' . $title . '<br>
                        <span class="text-muted font-weight-lighter index_module_header">
                        ' . $description . '</span></h3>';

        return $index_header;
    }
}

if (!function_exists('generate_serial_code')) {
    function generate_serial_code($company_id)
    {
        $company = Company::where('id', $company_id)->first();
        if ($company->prefix == null) {
            throw new \Exception('Please set company prefix', 201);
        }
        $lastUsedSerialNumber = Coupon::where([
            ['organization_id', $company->organization_id],
            ['company_id', $company->id]
        ])->orderBy('id', 'DESC')->first();

        if (null !== $lastUsedSerialNumber) {
            $parts  = explode($company->prefix, $lastUsedSerialNumber->code);
            $number = $company->prefix . sprintf("%'.06d", ++$parts[1]);
        } else {
            $number = $company->prefix . '000001';
        }
        return $number;
    }
}
