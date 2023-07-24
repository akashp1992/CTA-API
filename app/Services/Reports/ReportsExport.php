<?php

namespace App\Services\Reports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements WithHeadings, FromArray
{
    protected $header, $particulars;

    public function __construct($particulars)
    {
        $this->header      = [];
        $this->particulars = $particulars;
    }

    public function headings(): array
    {
        return $this->header = array_keys($this->particulars[0]);
    }

    public function array(): array
    {
        return [
            'values' => $this->particulars
        ];
    }
}
