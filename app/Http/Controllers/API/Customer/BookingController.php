<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\API\Customer\BookingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    protected $booking_repository;

    public function __construct()
    {
        $this->booking_repository = new BookingRepository();
    }

    public function store(Request $request)
    {
        try {
            $data      = $request->all();
            $validator = Validator::make($data, [
                'services'     => 'required',
                'customer_id'    => 'required',
                'schedule_date'    => 'required',
                'final_cost'    => 'required',
            ]);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }
            $booking_data = $this->booking_repository->store($data);
            $booking_response    = $this->booking_repository->getBookingById($booking_data->id);
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Booking.',
                    'data'    => [
                        'booking' => $this->prepare_booking_data($booking_response)
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

    private function prepare_booking_data($booking): array
    {
        return [
            'id'                => check_empty($booking, 'id', 0),
            'slug'              => check_empty($booking, 'slug', ''),
            'bill_number'       => check_empty($booking, 'invoice_number', ''),
            'schedule_date'     => check_empty($booking, 'scheduled_at', ''),
            'payment_status'    => check_empty($booking, 'payment_status', ''),
            'final_cost'        => check_empty($booking, 'final_amount', ''),
            'charge_url'        => check_empty($booking, 'charge_url', '')
        ];
    }
}
