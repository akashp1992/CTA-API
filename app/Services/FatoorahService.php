<?php

namespace App\Services;

use App\Services\Fatoorah\PaymentMyfatoorahApiV2;
use Illuminate\Support\Facades\Log;

class FatoorahService
{
    protected $fatoorah;

    public function initiatePayment($order_id, $cost, $customer, $organization_id, $type)
    {
        try {
            $this->initiateService($organization_id);
            return $this->fatoorah
                ->getInvoiceURL($order_id, [
                    'CustomerName'       => check_empty($customer, 'name', ''),
                    'CustomerEmail'      => check_empty($customer, 'email', ''),
                    'NotificationOption' => 'lnk',
                    'MobileCountryCode'  => '965',
                    'CustomerMobile'     => check_empty($customer, 'phone', ''),
                    'InvoiceValue'       => $cost,
                    'DisplayCurrencyIso' => 'kwd',
                    'CallBackUrl'        => 'https://console.ridesglobal.fun/fatoorah/callback?organization_id=' . $organization_id . '&type=' . $type,
                    'ErrorUrl'           => 'https://console.ridesglobal.fun/fatoorah/callback?organization_id=' . $organization_id . '&type=' . $type,
                    'Language'           => 'En',
                ]);
        } catch (\Exception $e) {
            Log::error('payment error ... ' . $e->getFile() . ', ' . $e->getMessage() . ', ' . $e->getCode());
            return false;
        }
    }

    public function getPaymentStatus($payment_id, $payment_type, $organization_id)
    {
        try {
            $this->initiateService($organization_id);
            $response = $this->fatoorah->getPaymentStatus($payment_id, $payment_type);
            Log::error('payment status success ... ', [json_encode($response)]);
            return $response;
        } catch (\Exception $e) {
            Log::error('payment status error ... ' . $e->getFile() . ', ' . $e->getMessage() . ', ' . $e->getCode());
            return $e;
        }
    }

    private function initiateService($organization_id)
    {
        $configurations   = get_configurations_data('', $organization_id);
        $fatoorah_api_key = !empty($configurations['fatoorah_api_key']) ? $configurations['fatoorah_api_key'] : config('constants.fatoorah.api_key');
        $is_sandbox       = !empty($configurations['is_sandbox']) && $configurations['is_sandbox'] === 'Yes';
        $this->fatoorah   = new PaymentMyfatoorahApiV2($fatoorah_api_key, $is_sandbox);
    }
}
