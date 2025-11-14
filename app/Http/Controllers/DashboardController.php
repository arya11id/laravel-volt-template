<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Models\DetailLayanan;
use App\Models\RiwayatLayanan;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\Pemohon;
use App\Models\LayananSurat;
use App\Models\DetailLayananSurat;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SipdExport;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        if ($role == 'admin') {
            return $this->admin();
        } elseif ($role == 'client') {
            return $this->client();
        }
    }

    public function admin()
    {
        $proses = DetailLayanan::where('tgl_selesai', null)->count();
        $selesai = DetailLayanan::where('tgl_selesai', '!=', null)->count();
        $list = Http::get('https://api.data.belajar.id/data-portal-backend/v2/master-data/peserta-didik/statistics/056300/descendants?sortBy=bentuk_pendidikan&sortDir=ASC')
            ->json();
        $listKab = Http::get('https://api.data.belajar.id/data-portal-backend/v2/master-data/peserta-didik/statistics/051300/descendants?sortBy=bentuk_pendidikan&sortDir=ASC')
            ->json();
        $formattedDate = Carbon::parse($list['meta']['lastUpdatedAt'])->setTimezone('Asia/Jakarta')->translatedFormat('d F Y, H:i:s T');
        $formattedDateKab = Carbon::parse($list['meta']['lastUpdatedAt'])->setTimezone('Asia/Jakarta')->translatedFormat('d F Y, H:i:s T');
        // return $list;
        return view('dashboard.admin', compact('proses', 'selesai', 'list', 'formattedDate', 'formattedDateKab', 'listKab'));
    }
    public function home()
    {

        $proses = DetailLayanan::where('tgl_selesai', null)->count();
        $selesai = DetailLayanan::where('tgl_selesai', '!=', null)->count();

        return view('dashboard.home', compact('proses', 'selesai'));
    }

    public function client()
    {
        return view('dashboard.client');
    }
    public function track(Request $request)
    {
        $tracking = '';
        if ($request->has(['nip', 'tgl_lahir'])) {
            $cari = Pemohon::where('nip', $request->nip)
                ->where('tgl_lahir', $request->tgl_lahir)
                ->first();
            if ($cari) {
                $tracking = DetailLayanan::with(['jenisLayanan', 'pemohon'])
                    ->whereHas('pemohon', function ($query) use ($request) {
                        $query->where('nip', $request->nip)
                            ->where('tgl_lahir', $request->tgl_lahir);
                    })
                    ->get();
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan. Silakan periksa kembali NIP dan Tanggal Lahir Anda.');
            }
        }

        // return view('track', compact('tracking'));
        return view('depan.track-nip', compact('tracking'));
    }
    public function trackDetail($uuid)
    {
        $data = DetailLayanan::with('jenisLayanan')->with('pemohon')->whereUuid($uuid)->firstOrFail();
        $id = $data->id;
        $tracking = RiwayatLayanan::where('detail_layanan_id', $id)
            ->with('status')
            ->with('createdBy')
            ->orderBy('created_at', 'desc')
            ->get();
        // return view('track-detail', compact('tracking', 'data'));
        return view('depan.detail-track-nip', compact('tracking', 'data'));
    }
    public function detailKec($kode)
    {
        $code = Crypt::decrypt($kode);
        $list = http::get('https://api.data.belajar.id/data-portal-backend/v1/master-data/satuan-pendidikan/search?kodeKecamatan=' . $code['kode'] . '&bentukPendidikan=dikmen&sortBy=bentuk_pendidikan&sortDir=asc&limit=20&offset=0')
            ->json();
        $data = http::get('https://api.data.belajar.id/data-portal-backend/v2/master-data/peserta-didik/search?kodeKecamatan=' . $code['kode'] . '&bentukPendidikan=dikmen&sortBy=bentuk_pendidikan&sortDir=DESC&limit=20&offset=0')
            ->json();
        $formattedDate = $code['formattedDateKab'];
        $count = $list['meta']['total'];
        $totalPages = $count > 0 ? ceil($count / 20) : 1;
        $page = 0;
        return view('dashboard.detail-kec', compact('data', 'code', 'formattedDate', 'totalPages', 'page', 'count'));
    }
    public function detailKecPage($kode, $page)
    {
        $code = Crypt::decrypt($kode);
        $list = http::get('https://api.data.belajar.id/data-portal-backend/v1/master-data/satuan-pendidikan/search?kodeKecamatan=' . $code['kode'] . '&bentukPendidikan=dikmen&sortBy=bentuk_pendidikan&sortDir=asc&limit=20&offset=' . $page)
            ->json();
        $data = http::get('https://api.data.belajar.id/data-portal-backend/v2/master-data/peserta-didik/search?kodeKecamatan=' . $code['kode'] . '&bentukPendidikan=dikmen&sortBy=bentuk_pendidikan&sortDir=DESC&limit=20&offset=' . $page)
            ->json();
        $formattedDate = $code['formattedDateKab'];
        $count = $list['meta']['total'];
        $totalPages = $count > 0 ? ceil($count / 20) : 1;
        return view('dashboard.detail-kec', compact('data', 'code', 'formattedDate', 'totalPages', 'page', 'count'));
    }
    public function absensi()
    {
        // $data = DB::connection('pgsql_dindik')->selectRaw("SELECT rekap_absensi_2.nip,
        //                         rekap_absensi_2.nama_pegawai,
        //                         rekap_absensi_2.unit_kerja,
        //                         COUNT (
        //                         CASE

        //                                 WHEN rekap_absensi_2.detail_ijin IN ( 'DLD', 'KTL', 'MJ', 'P5', 'LDK', 'DLP', 'R)', 'BT)', 'LA', 'E', 'e', 'a' ) THEN
        //                                 1
        //                             END
        //                             ) AS jumlah_hari_masuk_kerja,
        //                             COUNT ( CASE WHEN rekap_absensi_2.detail_ijin IN ( 'a' ) THEN 1 END ) AS tanpa_keterangan,
        //                             COUNT ( CASE WHEN rekap_absensi_2.ket_senam = 'TERLAMBAT SENAM' THEN 1 END ) AS terlambat_senam,
        //                             COUNT ( CASE WHEN rekap_absensi_2.ket_senam = 'TIDAK IKUT SENAM' THEN 1 END ) AS tidak_ikut_senam,
        //                             COUNT ( CASE WHEN rekap_absensi_2.ket_senam = 'TIDAK APEL' THEN 1 END ) AS tidak_apel,
        //                             COUNT ( CASE WHEN rekap_absensi_2.ket_senam = 'TIDAK IKUT UPACARA' THEN 1 END ) AS tidak_ikut_upacara,
        //                             SUM (rekap_absensi_2.durasi_terlambat_2) as total_durasi_terlambat_1_bulan
        //                         FROM
        //                             rekap_absensi_2 A
        //                         where EXTRACT(MONTH FROM rekap_absensi_2.tgl ) = 5
        //                         GROUP BY
        //                             rekap_absensi_2.nip,
        //                             rekap_absensi_2.nama_pegawai,
        //                             rekap_absensi_2.unit_kerja
        //                     ORDER BY
        //                         rekap_absensi_2.unit_kerja ASC");
        $data = DB::connection('pgsql_dindik')
            ->table('rekap_absensi_2')
            ->selectRaw("
                    rekap_absensi_2.nip,
                    rekap_absensi_2.nama_pegawai,
                    rekap_absensi_2.unit_kerja,
                    COUNT(CASE WHEN rekap_absensi_2.detail_ijin IN ('DLD', 'KTL', 'MJ', 'P5', 'LDK', 'DLP', 'R)', 'BT)', 'LA', 'E', 'e', 'a') THEN 1 END) AS jumlah_hari_masuk_kerja,
                    COUNT(CASE WHEN rekap_absensi_2.detail_ijin = 'a' THEN 1 END) AS tanpa_keterangan,
                    COUNT(CASE WHEN rekap_absensi_2.ket_senam = 'TERLAMBAT SENAM' THEN 1 END) AS terlambat_senam,
                    COUNT(CASE WHEN rekap_absensi_2.ket_senam = 'TIDAK IKUT SENAM' THEN 1 END) AS tidak_ikut_senam,
                    COUNT(CASE WHEN rekap_absensi_2.ket_senam = 'TIDAK APEL' THEN 1 END) AS tidak_apel,
                    COUNT(CASE WHEN rekap_absensi_2.ket_senam = 'TIDAK IKUT UPACARA' THEN 1 END) AS tidak_ikut_upacara,
                    SUM(rekap_absensi_2.durasi_terlambat_2) AS total_durasi_terlambat_1_bulan
                ")
            ->whereRaw('EXTRACT(MONTH FROM rekap_absensi_2.tgl) = ?', [5])
            ->groupBy(
                'rekap_absensi_2.nip',
                'rekap_absensi_2.nama_pegawai',
                'rekap_absensi_2.unit_kerja'
            )
            ->orderBy('rekap_absensi_2.unit_kerja', 'ASC')
            ->get();

        return response()->json($data);
    }
    public function trackSurat(Request $request)
    {
        $tracking = '';
        if ($request->has(['no_surat'])) {
            $cari = LayananSurat::where('no_surat', $request->no_surat)
                ->first();
            if ($cari) {
                $tracking = $cari;
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan. Silakan periksa kembali No Surat anda.');
            }
        }

        // return view('track-surat', compact('tracking'));
        return view('depan.track-surat', compact('tracking'));
    }
    public function trackDetailSurat($uuid)
    {
        $data = LayananSurat::with('jenisLayanan')->whereUuid($uuid)->firstOrFail();
        $id = $data->id;
        $tracking = DetailLayananSurat::where('layanan_surat_id', $id)
            ->with('status')
            ->with('createdBy')
            ->orderBy('created_at', 'desc')
            ->get();
        // return view('track-detail-surat', compact('tracking', 'data'));
        return view('depan.detail-surat', compact('tracking', 'data'));
    }
    public function sipd(Request $request)
    {
        $unit = '';
        if ($request->query('unit')) {
            $unit = $request->query('unit') ?? '';
        }
        $kodeList = DB::select("
            SELECT 
                rb.kode_akun,
                rb.nama_akun
            FROM sipdri.rinci_sub_bl rb
                LEFT JOIN sipdri.unit_kerja uk ON rb.id_subs_sub_bl = uk.id_subs_sub_bl
                LEFT JOIN sipdri.ket_sub_bl kb ON rb.id_ket_sub_bl = kb.id_ket_sub_bl
                WHERE uk.subs_bl_teks = ?
            GROUP BY  rb.kode_akun,
                rb.nama_akun
            ORDER BY  rb.kode_akun,
                rb.nama_akun
        ", [$unit]);
        

        $list = [];

        foreach ($kodeList as $k) {
            $data = DB::select("
                SELECT
                    uk.subs_bl_teks,
                    kb.ket_bl_teks,
                    rb.nama_standar_harga,
                    rb.spek,
                    rb.koefisien_murni AS koefisien_sebelum,
                    rb.harga_satuan_murni AS harga_sebelum,
                    rb.total_harga_murni AS total_sebelum,
                    rb.koefisien AS koefisien_setelah,
                    rb.harga_satuan AS harga_setelah,
                    rb.total_harga AS total_setelah
                FROM sipdri.rinci_sub_bl rb
                LEFT JOIN sipdri.unit_kerja uk ON rb.id_subs_sub_bl = uk.id_subs_sub_bl
                LEFT JOIN sipdri.ket_sub_bl kb ON rb.id_ket_sub_bl = kb.id_ket_sub_bl
                WHERE rb.kode_akun = ? AND uk.subs_bl_teks = ?
                ORDER BY 
                    uk.subs_bl_teks,
                    kb.ket_bl_teks,
                    rb.kode_akun,
                    rb.nama_standar_harga
            ", [$k->kode_akun,$unit]);

            $list[] = [
                'kode_akun' => $k->kode_akun,
                'nama_akun' => $k->nama_akun,
                'data' => $data
            ];
        }

        // Jika ada parameter ?export=excel maka download Excel
        if ($request->query('export') === 'excel') {
            $filename = 'data_sipd_' .$unit.'_'. now()->format('Ymd_His') . '.xlsx';
            return Excel::download(new SipdExport($list), $filename);
        }

        // Default: tampilkan JSON
        return response()->json($list);
    }

}
