<?php

namespace App\Repositories\API\Customer;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Pos;
use App\Models\PosHasItem;
use Illuminate\Support\Facades\DB;

class ServicesRepository
{
    protected $service;

    public function __construct()
    {
        $this->pos = new Pos();
        $this->service = new Service();
    }

    public function getBookingsForServices($request) {
        $start_date = Carbon::parse($request->get('start_date'))->format('Y-m-d 00:00:01');
        $end_date   = Carbon::parse($request->get('end_date'))->format('Y-m-d 23:59:59');
       
        return $this->pos
            ->with(['customer', 'transactions', 'items'])
            ->where('organization_id', $request->get('organization_id'))
            ->where('created_at', '>=', $start_date)
            ->where('created_at', '<=', $end_date)
            ->get();
    }
}
