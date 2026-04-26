<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TrafficExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $traffics;
    private $rowNumber = 0; // Untuk bikin nomor urut otomatis

    public function __construct($traffics)
    {
        $this->traffics = $traffics;
    }

    // 1. Mengambil datanya
    public function collection()
    {
        return $this->traffics;
    }

    // 2. Mapping (Memasukkan data ke dalam baris Excel)
    public function map($traffic): array
    {
        return[
            ++$this->rowNumber,
            $traffic->tanggal,
            $traffic->kamera->area->nama_area ?? '-',
            $traffic->kamera->nama_kamera ?? '-',
            $traffic->kendaraan_masuk,
            $traffic->kendaraan_keluar,
        ];
    }

    // 3. Membuat Judul Kolom (Header)
    public function headings(): array
    {
        return[
            'No',
            'Tanggal',
            'Lokasi Area',
            'Kamera CCTV',
            'Kendaraan Masuk',
            'Kendaraan Keluar',
        ];
    }

    // 4. (Opsional) Menebalkan huruf di baris pertama (Header)
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}