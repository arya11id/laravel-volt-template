<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SipdExport implements FromArray, WithHeadings, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $export = [];

        foreach ($this->data as $item) {
           $export[] = [
                    'Kode Akun' => $item['kode_akun'],
                    'Nama Akun' => $item['nama_akun']
                    ];
            foreach ($item['data'] as $detail) {
                $export[] = [
                    'Kode Akun' => $item['kode_akun'],
                    'Nama Akun' => $item['nama_akun'],
                    
                    'Sub Kegiatan' => $detail->subs_bl_teks ?? '',
                    'Keterangan BL' => $detail->ket_bl_teks ?? '',
                    'Nama Standar Harga' => $detail->nama_standar_harga ?? '',
                    'Spesifikasi' => $detail->spek ?? '',
                    'Koefisien Sebelum' => $detail->koefisien_sebelum ?? '',
                    'Harga Sebelum' => $detail->harga_sebelum ?? '',
                    'Total Sebelum' => $detail->total_sebelum ?? '',
                    'Koefisien Setelah' => $detail->koefisien_setelah ?? '',
                    'Harga Setelah' => $detail->harga_setelah ?? '',
                    'Total Setelah' => $detail->total_setelah ?? '',
                ];
            }
        }

        return $export;
    }

    public function headings(): array
    {
        return [
            'Kode Akun',
            'Nama Akun',
            'Sub Kegiatan',
            'Keterangan BL',
            'Nama Standar Harga',
            'Spesifikasi',
            'Koefisien Sebelum',
            'Harga Sebelum',
            'Total Sebelum',
            'Koefisien Setelah',
            'Harga Setelah',
            'Total Setelah',
        ];
    }

    public function title(): string
    {
        return 'Data SIPD';
    }
}
