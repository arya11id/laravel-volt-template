<?php

use Carbon\Carbon;

if (!function_exists('tanggalIndoLengkap')) {
    function tanggalIndoLengkap($tanggal)
    {
        Carbon::setLocale('id');

        $date = Carbon::createFromFormat('d/m/Y', $tanggal);

        $hari = $date->translatedFormat('l');

        $bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return $hari . ' tanggal ' .
            terbilang($date->day) . ' ' .
            $bulan[$date->month - 1] . ' ' .
            'tahun ' . terbilang($date->year);
    }
}

if (!function_exists('terbilang')) {
    function terbilang($angka)
    {
        $angka = abs($angka);
        $bilangan = [
            '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima',
            'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'
        ];

        if ($angka < 12) {
            return $bilangan[$angka];
        } elseif ($angka < 20) {
            return terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            return terbilang(floor($angka / 10)) . ' Puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            return 'Seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return terbilang(floor($angka / 100)) . ' Ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return 'Seribu ' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return terbilang(floor($angka / 1000)) . ' Ribu ' . terbilang($angka % 1000);
        }

        return '';
    }
}
function nip($angka){
    $hasil = substr($angka, 0, 8) . ' ' .   // 19851016
            substr($angka, 8, 6) . ' ' .   // 202421
            substr($angka, 14, 1) . ' ' .  // 2
            substr($angka, 15, 3);         // 001
    return $hasil;
}
