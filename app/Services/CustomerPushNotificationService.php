<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class CustomerPushNotificationService
{
    protected $fp, $pass_phrase, $ssl, $sandbox_ssl, $sandbox_feedback, $device_type;

    public function __construct()
    {
        $this->pass_phrase      = '';
        $this->ssl              = 'ssl://gateway.push.apple.com:2195';
        $this->sandbox_ssl      = 'ssl://gateway.sandbox.push.apple.com:2195';
        $this->sandbox_feedback = 'ssl://feedback.sandbox.push.apple.com:2196';

        $this->initialize_apns();
    }

    private function get_certificate_path()
    {
        return config_path() . '/push_notification/customer/certificates/certificate.pem';
    }

    public function initialize_apns()
    {
        try {
            $ssl_path = env('APP_ENV') == 'production' || env('APP_ENV') == 'staging' ? $this->ssl : $this->sandbox_ssl;
            $ctx      = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', $this->get_certificate_path());
            stream_context_set_option($ctx, 'ssl', 'passphrase', $this->pass_phrase);

            // xdebug_break();

            // Open a connection to the APNS server
            $this->fp = stream_socket_client(
                $ssl_path,
                $error, $error_string, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx
            );

            if ($this->fp) {
                Log::info("connected to APNS - $this->fp");
            } else {
                Log::error("failed to connect: $error $error_string");
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function send_notification($devices, $message)
    {
        try {
            $error_counter = 0;
            $payload       = json_encode(array('aps' => $message));
            $result        = 0;
            $body_error    = '';

            foreach ($devices as $key => $value) {
                $msg        = chr(0) . pack('n', 32) . pack('H*', str_replace(' ', '', $value)) . pack('n', (strlen($payload))) . $payload;
                $result     = fwrite($this->fp, $msg);
                $body_error .= 'result: ' . $result . ', devicetoken: ' . $value;
                if (!$result) {
                    $error_counter = $error_counter + 1;
                }
            }

            if ($result) {
                Log::info("send_ios_push response:", ['input' => 'inputs', 'response' => $result]);
                $bool_result = true;
            } else {
                Log::info('could not deliver a message to APNS' . PHP_EOL);
                $bool_result = false;
            }

            // @socket_close($this->fp);
            @fclose($this->fp);
            return $bool_result;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
