<?php

namespace App\Services;

// use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
// use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Log;

class CommonService
{
    public function __construct()
    {
        //
    }

    public function generateQRCode($data, $path)
    {
        // $renderer = new ImageRenderer(
        //     new RendererStyle(400),
        //     new ImagickImageBackEnd()
        // );
        // $writer   = new Writer($renderer);
        // $writer->writeFile($data, $path);
    }

    public function generateShortenURL($long_url, $title)
    {
        $shorten_link_data = ['long_url' => $long_url, 'title' => $title];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api-ssl.bitly.com/v4/bitlinks');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($shorten_link_data));

        $headers   = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . config('constants.BIT_LY_GENERIC_TOKEN');
        $headers[] = 'Content-Length: ' . strlen(json_encode($shorten_link_data));

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $response = json_decode($response);
        Log::info('bit ly shorten url response... ', [$response]);

        if (curl_errno($ch)) {
            Log::error('bit ly shorten url error... ', [curl_error($ch)]);
        }

        curl_close($ch);

        return isset($response->link) && !empty($response->link) ? $response->link : null;
    }
}
