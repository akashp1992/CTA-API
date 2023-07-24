<?php

namespace App\Services\Reports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MtReportsExport implements WithHeadings, FromArray
{
    protected $header, $particulars;

    public function __construct($particulars)
    {
        $this->header      = [];
        $this->particulars = $particulars;
    }

    public function headings(): array
    {
        return $this->header = ['Subscription Type','Menu Item','Food Type','Order'];
    }

    public function array(): array
    {
        $count = count($this->particulars) +1;
        foreach($this->particulars as $row)
        {
            $arr[] = (array) $row;
        }
        array_push($arr,['Total:','', '' ,'=SUM(D2:D'.$count.')','', '']);
        return [
            'values' => $arr
        ];
    }
}
