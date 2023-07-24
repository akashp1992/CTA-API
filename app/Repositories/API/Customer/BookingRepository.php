<?php

namespace App\Repositories\API\Customer;

use App\Models\Customer;
use App\Services\PaymentService;
use Carbon\Carbon;

use App\Models\Pos;
use App\Models\PosHasItem;
use App\Models\PosHasTransaction;

class BookingRepository
{
    protected $payment_service, $customer, $pos_has_transaction, $pos_has_item, $pos;

    public function __construct()
    {
        $this->pos = new Pos();
        $this->customer = new Customer();
        $this->pos_has_item = new PosHasItem();
        $this->payment_service = new PaymentService();
        $this->pos_has_transaction = new PosHasTransaction();
    }

    public function store($data)
    {
        $data['slug']             = generate_slug('bookings');
        $data['status']           = 'completed';
        $data['scheduled_at']     = Carbon::parse($data['schedule_date'])->format('Y-m-d H:i:s') ?? Carbon::now()->format('Y-m-d H:i:s');
        $data['final_amount']     = $data['final_cost'];
        $data['invoice_number']   = $this->generate_bill_number();
        $data['invoice_amount']   = $data['final_cost'];

        $booking = $this->pos->create($data);
        if (isset($booking)) {
            $initial_booking_data = [
                            'pos_id' => $booking->id, 'action' => 'booking', 
                            'type' => 'debit', 'payment_type' => 'k-net',
                            'amount' => $data['final_cost'], 'notes' => 'Booking has been created', 'created_by'=> 0
                        ];
            $booking_debit = $this->pos_has_transaction->create($initial_booking_data);
            if(isset($booking_debit)){
                $booking_detail['pos_id']       = $booking->id ?? 0;
                $booking_detail['action']       = 'receipt';
                $booking_detail['type']         = 'credit';
                $booking_detail['payment_type'] = 'k-net'; // @todo payment type should be dynamic
                $booking_detail['amount']       = $data['final_cost'];
                $booking_detail['created_by']   = 0;
                $this->pos_has_transaction->create($booking_detail);
            }
        }

        $customer = $this->customer->where('id', $data['customer_id'])->first();
        if(isset($booking) && isset($data['services'])){
            // $items = json_decode(json_encode($data['services']));
            $items = json_decode($data['services']);
            if(!empty($items)){
                foreach($items as $item){
                    $service_details = \App\Providers\FormList::fetchTodaysService($item->service_id, $booking->organization_id);
                    $item_data['pos_id']        = $booking->id ?? 0;
                    $item_data['item_id']       = $item->service_id;
                    $item_data['type']          = $item->type;
                    $item_data['quantity']      = $item->quantity ?? 1;
                    $item_data['per_item_cost'] = $service_details->day_price ?? 0;
                    $item_data['final_cost']    = ($service_details->day_price * $item->quantity) ?? 0;
                    if($item->type == 'service'){
                        if ($service_details->duration_in_minutes == 0) {
                            $organization_data = $this->organization->select('start_time', 'end_time')->where('id', $booking->organization_id)->first();
                            $start_time = Carbon::parse($organization_data->start_time)->format('g:i A') ?? Carbon::now()->format('g:i A');
                            $end_time = Carbon::parse($organization_data->end_time)->format('g:i A') ?? date('23:59');
                            $organization_time_slot = $start_time . ' - ' . $end_time;
                            if ($service_details->service_type == 'trampoline') {
                                $item_data['trampoline_time'] = $organization_time_slot ?? '';
                            } elseif ($service_details->service_type == 'playground') {
                                $item_data['playground_time'] = $organization_time_slot ?? '';
                            } else {
                                $item_data['trampoline_time'] = $organization_time_slot ?? '';
                                $item_data['playground_time'] = $organization_time_slot ?? '';
                            }
                        } else {
                            $item_data['trampoline_time'] = $item->trampoline_time ?? '';
                            $item_data['playground_time'] = $item->playground_time ?? '';
                        }
                    }
                    $this->pos_has_item->create($item_data);
                }
            }            
        }

        $charge_response = $this->payment_service
            ->create_charge_url(
                $booking->id, $data['final_cost'], $customer, $booking->organization_id
            );
        $this->pos
            ->where('id', $booking->id)
            ->update([
                'charge_id'  => $charge_response['charge_id'],
                'charge_url' => $charge_response['charge_url']
            ]);
        return $booking;
    }

    public function generate_bill_number()
    {
        $booking = Pos::orderBy('id', 'desc')->first();
        return isset($booking)
            ? 'INV-' . str_pad((int)$booking->id + 1, 6, '0', STR_PAD_LEFT)
            : 'INV-' . str_pad(1, 6, '0', STR_PAD_LEFT);
    }

    public function getBookingById($id)
    {
        return $this->pos->where('id', $id)->first();
    }

    public function getBookingBySlug($slug)
    {
        return $this->pos->where('slug', $slug)->first();
    }
}
