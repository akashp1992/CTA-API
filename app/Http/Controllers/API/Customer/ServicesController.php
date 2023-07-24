<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\API\Customer\ServicesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    protected $services_repository;

    public function __construct()
    {
        $this->services_repository = new ServicesRepository();
    }

    public function getSalesByTicketTypeReport(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), ['organization_id'    => 'required']);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $bookings = $this->services_repository->getBookingsForServices($request);
            if (!isset($bookings)) {
                throw new \Exception('Service Category does not exist.', 201);
            }

            $total_invoice_amount = $total_discount_amount = $total_final_amount = $total_token_amount =
            $total_remaining_amount = $total_paid_amount = $total_cancel_amount = $total_cancelled_sales = 0;

            $temporary_items = [];
            if (!empty($bookings) && count($bookings) > 0) {
                foreach ($bookings as $booking) {
                    $cancel_transaction = $booking->transactions->where('action', 'refund')->first();
                    $cancelled_sales_amount = $cancel_amount = $discount_amount = $remaining_amount = 0;
                    if(isset($cancel_transaction)){
                        $total_cancelled_sales  += floatval($booking->invoice_amount);
                        $cancelled_sales_amount = floatval($booking->invoice_amount);
                        $cancel_amount = $cancel_transaction->amount ?? 0;
                    }else{
                        $remaining_amount = $booking->remaining_amount;
                        $discount_amount = $booking->discount_amount;
                        $total_discount_amount  += floatval($discount_amount);
                    }

                    $total_invoice_amount   += floatval($booking->invoice_amount);
                    $total_final_amount     += $booking->invoice_amount - $discount_amount - $cancelled_sales_amount;
                    $total_token_amount     += floatval($booking->advance_amount);
                    $total_remaining_amount += floatval($remaining_amount);
                    $total_paid_amount      += $booking->final_amount - $booking->remaining_amount - $cancel_amount;
                    $total_cancel_amount    += floatval($cancel_amount);

                    if (!empty($booking->items) && count($booking->items) > 0) {
                        foreach ($booking->items as $booking_item) {
                            $booking_item_arabic_name                 = isset($booking_item->item) ? $booking_item->item->arabic_name : '';
                            $booking_item_name                        = isset($booking_item->item) ? $booking_item->item->name : '';
                            $booking_item_index                       = $booking_item_arabic_name . '---' . $booking_item_name . '---' . $booking_item->per_item_cost;
                            $temporary_items[ $booking_item_index ][] = $booking_item->quantity ?? 0;
                        }
                    }
                }
            }

            $items = [];
            if (!empty($temporary_items)) {
                foreach ($temporary_items as $temporary_item_index => $quantity) {

                    $counted_quantity = 0;
                    if (!empty($quantity)) {
                        foreach ($quantity as $individual_quantity) {
                            $counted_quantity += $individual_quantity;
                        }
                    }

                    $exploded = explode('---', $temporary_item_index);
                    $items[]  = [
                        'arabic_name'       => $exploded[0],
                        'name'              => $exploded[1],
                        'per_item_cost'     => 'KD ' .$exploded[2],
                        'item_quantity'     => $counted_quantity,
                        'item_final_cost'   => 'KD ' .$counted_quantity * $exploded[2]
                    ];
                }
            }

            $bookings = [
                'total_invoice_amount'   => 'KD ' .$total_invoice_amount,
                'total_discount_amount'  => 'KD ' .$total_discount_amount,
                'total_cancelled_sales'  => 'KD ' .$total_cancelled_sales,
                'total_final_amount'     => 'KD ' .$total_final_amount,
                'total_token_amount'     => 'KD ' .$total_token_amount,
                'total_remaining_amount' => 'KD ' .$total_remaining_amount,
                'total_paid_amount'      => 'KD ' .$total_paid_amount,
                'total_cancel_amount'    => 'KD ' .$total_cancel_amount
            ];

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Service Categories.',
                    'data'    => [
                        'ticket_types' => $items,
                        'widgets_counts' => $bookings
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
}
