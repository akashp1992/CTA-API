<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function sendNotification($data)
    {
        ini_set('max_execution_time', 0);
        try {
            $user = $this->user->where('id', $data['user_id'])->first();
            if (!isset($user)) {
                Log::error('push notification... user does not exist.');
            }

            $data['device_token'] = !empty($user->device_token) ? $user->device_token : '';
            if (!empty($user->device_type)) {
                if ($user->device_type == 'android') {
                    $this->android($data);
                } else {
                    $this->ios($data);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage() . PHP_EOL);
        }
    }

    public function ios($data)
    {
        $customer_apns = new CustomerPushNotificationService();
        $message_array = array(
            'alert'      => $data['title'],
            'badge'      => 1,
            'sound'      => 'default',
            'status'     => 'success',
            'data'       => [
                'body'      => $data['body'],
                'flag'      => $data['flag'],
                'image_url' => $data['image_url'],
            ],
            'extra_data' => !empty($data['extra_data']) ? $data['extra_data'] : []
        );

        $device_token = is_array($data['device_token']) ? $data['device_token'] : array(trim($data['device_token']));
        $response     = $customer_apns->send_notification($device_token, $message_array);
        Log::info("send_ios_push response:", ['input' => $data, 'response' => $response], []);

        return $response;
    }

    public function android($data)
    {
        $message = [
            'data'             => [
                'payload' => [
                    'Title'      => $data['title'],
                    'Body'       => $data['body'],
                    'Flag'       => $data['flag'],
                    'ImageURL'   => $data['image_url'],
                    'extra_data' => !empty($data['extra_data']) ? $data['extra_data'] : []
                ]
            ],
            'registration_ids' => [$data['device_token']]
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode($message),
            CURLOPT_HTTPHEADER     => array(
                "Content-Type: application/json",
                "Authorization: key=" . config('constants.fcm_token.customer')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        Log::info("send_android_push response:", ['input' => $data, 'response' => json_decode($response)], []);
        return $response;
    }

    public function sendPubNubNotification($channel_name = '', $pubnub_data = '')
    {
        ini_set('max_execution_time', 0);
        try {
            $pubnub_configuration = new \PubNub\PNConfiguration();
            $pubnub_configuration->setSubscribeKey(config('config.pubnub_subscribe_key'));
            $pubnub_configuration->setPublishKey(config('config.pubnub_publish_key'));
            $pubnub_configuration->setSecure(true);
            $pubnub = new \PubNub\PubNub($pubnub_configuration);

            $response = $pubnub->publish()
                ->channel($channel_name)
                ->message($pubnub_data)
                ->sync();

            Log::info('pubnub notification published', [$response->getTimetoken()], [json_encode(['channel_name' => $channel_name, 'data' => $pubnub_data])]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
