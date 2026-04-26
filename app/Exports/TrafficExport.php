<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TrafficExport implements FromView, ShouldAutoSize
{
    protected $traffics;

    public function __construct($traffics)
    {
        $this->traffics = $traffics;
    }

    public function view(): View
    {
        // Akan memanggil file blade cetak.blade.php
        return view('laporan.cetak',[
            'traffics' => $this->traffics
        ]);
    }
}