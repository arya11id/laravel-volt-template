<?php

namespace App\Http\Controllers\Admin\Sippol;
use App\Http\Controllers\Controller;

use App\Models\Sippol\SippolBpDuaDua;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SipdExport;
use App\Models\Sippol\SippolJenis;
use App\Models\Sippol\SippolPeriode;
use App\Models\Sippol\SippolUnitKerja;
use Illuminate\Support\Facades\DB;


class SippolJenisController extends Controller
{
    public function index($id)
    {
        $cek = SippolJenis::whereIn('id_kategori', [1,2,3,4,5])->where('id_periode', $id)->orderBy('urutan','ASC')->count();
        $SippolPeriode = SippolPeriode::find($id);
        $SippolUnitKerja = SippolUnitKerja::with('bastUnitKerja')->where('id_periode', $id)->get();
        $SippolJenis = SippolJenis::select(
            'bpopp.sippol_jenis.id',
            'bpopp.sippol_jenis.urutan',
            'bpopp.sippol_jenis.nomor',
            'bpopp.sippol_jenis.mulai',
            'bpopp.sippol_jenis.akhir',
            'bpopp.sippol_jenis.nama_jenis',
            DB::raw('SUM(bpopp.sippol_bast_bpduadua.pengeluaran) as total_pengeluaran'),
            'bpopp.kategori.nama'
        )
        ->join('bpopp.sippol_bast_bpduadua', 'bpopp.sippol_jenis.id', '=', 'bpopp.sippol_bast_bpduadua.id_sippol_jenis')
        ->leftJoin('bpopp.kategori', 'bpopp.sippol_jenis.id_kategori', '=', 'bpopp.kategori.id')
        ->where('bpopp.sippol_jenis.id_periode', $id)
        ->where('bpopp.sippol_bast_bpduadua.id_periode', $id)
        ->where('bpopp.sippol_bast_bpduadua.tanggal','!=',null)
        ->groupBy(
            'bpopp.sippol_jenis.nama_jenis',
            'bpopp.sippol_jenis.urutan',
            'bpopp.sippol_jenis.nomor',
            'bpopp.sippol_jenis.mulai',
            'bpopp.sippol_jenis.akhir',
            'bpopp.sippol_jenis.id',
            'bpopp.kategori.nama'
        )
        ->orderBy('bpopp.sippol_jenis.urutan', 'ASC')
        ->get();
        return view('admin.sippol.jenis.index', compact('SippolJenis', 'SippolPeriode', 'SippolUnitKerja', 'cek'));
    }
    public function rekap($id)
    {
        $result = SippolBpDuaDua::query()
            ->select('sekolah',DB::raw('SUM(pengeluaran) as total_pengeluaran'))
            ->where('id_sippol_jenis', $id)
            ->whereNotIn('sekolah', ['KDR', ''])
            ->where('tanggal','!=',null)
            ->groupBy('sekolah')
            ->get();
        return response()->json($result);
    }
    public function hasil($id)
    {
        $cari = SippolJenis::find($id);
        $subQueryXa = SippolBpDuaDua::select(
                'sekolah',
                DB::raw('SUM(pengeluaran) AS total_pengeluaran')
            )
            ->where('id_sippol_jenis', $id)
            ->where('tanggal','!=',null)
            ->whereNotIn('sekolah', ['KDR', 'STS', ''])
            ->groupBy('sekolah');

        $results = SippolUnitKerja::with('bastUnitKerja:id,nama_unit_kerja')
        ->leftJoinSub($subQueryXa, 'xa', function ($join) {
            $join->on('bpopp.sippol_unit_kerja.kode', '=', 'xa.sekolah');
        })
        ->select(
            'bpopp.sippol_unit_kerja.*',
            'xa.sekolah',
            'xa.total_pengeluaran'
        )
        ->where('bpopp.sippol_unit_kerja.id_periode', $cari->id_periode)
        ->orderBy('id_bast_unit_kerja')
        ->get();



        return response()->json($results);
    }
    public function kategori($id,$kategori)
    {
        //
        if ($kategori == 100) {
            SippolJenis::where('id_kategori', '!=', null)
            ->update(['id_kategori' => null]);
            return response()->json(['success' => 'Kategori cleared successfully.']);
        }
        SippolJenis::where('id', $id)
            ->update(['id_kategori' => $kategori]);
        return response()->json(['success' => 'Kategori updated successfully.']);
        
    }
    public function final($id)
    {
        //
        $subQuery = function ($id_periode, $id_kategori) {
            return SippolBpDuaDua::query()
                ->select(
                    'sekolah',
                    DB::raw('SUM(penerimaan) AS total_penerimaan'),
                    DB::raw('SUM(pengeluaran) AS total_pengeluaran')
                )
                ->join('bpopp.sippol_jenis', 'bpopp.sippol_bast_bpduadua.id_sippol_jenis', '=', 'bpopp.sippol_jenis.id')
                ->where('bpopp.sippol_jenis.id_kategori', $id_kategori)
                ->where('bpopp.sippol_bast_bpduadua.id_periode', $id_periode)
                ->whereNotIn('bpopp.sippol_bast_bpduadua.sekolah', ['KDR', 'STS', ''])
                ->groupBy('sekolah');
        };

        $xa = $subQuery($id, 1);
        $xb = $subQuery($id, 2);
        $xc = $subQuery($id, 3);
        $xd = $subQuery($id, 4);
        $xe = $subQuery($id, 5);

        $results = SippolUnitKerja::leftJoin('bpopp.bast_unit_kerja as buk', 'bpopp.sippol_unit_kerja.id_bast_unit_kerja', '=', 'buk.id')
            ->leftJoinSub($xa, 'xa', 'bpopp.sippol_unit_kerja.kode', '=', 'xa.sekolah')
            ->leftJoinSub($xb, 'xb', 'bpopp.sippol_unit_kerja.kode', '=', 'xb.sekolah')
            ->leftJoinSub($xc, 'xc', 'bpopp.sippol_unit_kerja.kode', '=', 'xc.sekolah')
            ->leftJoinSub($xd, 'xd', 'bpopp.sippol_unit_kerja.kode', '=', 'xd.sekolah')
            ->leftJoinSub($xe, 'xe', 'bpopp.sippol_unit_kerja.kode', '=', 'xe.sekolah')
            ->select(
                'bpopp.sippol_unit_kerja.id_bast_unit_kerja',
                'buk.nama_unit_kerja',
                'bpopp.sippol_unit_kerja.jml_gu',
                'bpopp.sippol_unit_kerja.jml_sts',
                'bpopp.sippol_unit_kerja.kode',
                'xa.sekolah',
                'xa.total_pengeluaran as panjar',
                'xb.total_penerimaan as pph21_penerimaan',
                'xb.total_pengeluaran as pph21_pengeluaran',
                'xc.total_penerimaan as pph22_penerimaan',
                'xc.total_pengeluaran as pph22_pengeluaran',
                'xd.total_penerimaan as pph23_penerimaan',
                'xd.total_pengeluaran as pph23_pengeluaran',
                'xe.total_penerimaan as ppn_penerimaan',
                'xe.total_pengeluaran as ppn_pengeluaran'
            )
            ->orderBy('bpopp.sippol_unit_kerja.id_bast_unit_kerja')
            ->where('bpopp.sippol_unit_kerja.id_periode', $id)
            ->get();
        $SippolPeriode = SippolPeriode::find($id);
        $SippolUnitKerja = SippolUnitKerja::with('bastUnitKerja')->where('id_periode', $id)->get();
        $panjarok = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->jml_gu - ($item->jml_sts + $item->panjar);

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil == 0;
        });
        $panjarminus = $results->map(function ($item) {
            $item->hasil = $item->jml_gu - ($item->jml_sts + $item->panjar);

            return $item;
        })->filter(function ($item) {
            return $item->hasil < 0;
        });
        $panjarlebih = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->jml_gu - ($item->jml_sts + $item->panjar);

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil > 0;
        });
        $beluminput = $results->map(function ($item) {

            $item->hasil =  $item->panjar;
            return $item;
        })->filter(function ($item) {
            return $item->hasil == 0;
        });
        $pph21ok = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->pph21_penerimaan - $item->pph21_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil == 0;
        });
        $pph21minus = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->pph21_penerimaan - $item->pph21_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil < 0;
        });
        $pph21lebih = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->pph21_penerimaan - $item->pph21_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil > 0;
        });
        $pph22ok = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->pph22_penerimaan - $item->pph22_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil == 0;
        });
        $pph22minus = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->pph22_penerimaan - $item->pph22_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil < 0;
        });
        $pph22lebih = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->pph22_penerimaan - $item->pph22_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil > 0;
        });
        $pph23ok = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->pph23_penerimaan - $item->pph23_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil == 0;
        });
        $pph23minus = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->pph23_penerimaan - $item->pph23_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil < 0;
        });
        $pph23lebih = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->pph23_penerimaan - $item->pph23_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil > 0;
        });
        $ppnok = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->ppn_penerimaan - $item->ppn_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil == 0;
        });
        $ppnminus = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->ppn_penerimaan - $item->ppn_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil < 0;
        });
        $ppnlebih = $results->map(function ($item) {
            // hitung hasil
            $hasil = $item->ppn_penerimaan - $item->ppn_pengeluaran;

            // paksa tampil 0 jika hasilnya 0 atau minus kecil (floating error)
            $item->hasil = ($hasil == 0) ? 0 : $hasil;

            return $item;
        })->filter(function ($item) {
            return $item->hasil > 0;
        });
        // return response()->json([
        //     'beluminput' => $beluminput,
        //     // 'panjarminus' => $panjarminus,
        //     // 'panjarlebih' => $panjarlebih,
        //     // 'pph21ok' => $pph21ok,
        //     // 'pph21minus' => $pph21minus,
        //     // 'pph21lebih' => $pph21lebih,
        //     // 'pph22ok' => $pph22ok,
        //     // 'pph22minus' => $pph22minus,
        //     // 'pph22lebih' => $pph22lebih,
        //     // 'pph23ok' => $pph23ok,
        //     // 'pph23minus' => $pph23minus,
        //     // 'pph23lebih' => $pph23lebih,
        //     // 'ppnok' => $ppnok,
        //     // 'ppnminus' => $ppnminus,
        //     // 'ppnlebih' => $ppnlebih,
        // ]);
        return view('admin.sippol.unit-kerjas.final', compact(
            'results',
            'SippolPeriode',
            'SippolUnitKerja',
            'panjarok',
            'panjarminus',
            'panjarlebih',
            'pph21ok',
            'pph21minus',
            'pph21lebih',
            'pph22ok',
            'pph22minus',
            'pph22lebih',
            'pph23ok',
            'pph23minus',
            'pph23lebih',
            'ppnok',
            'ppnminus',
            'ppnlebih','beluminput'
        ));
    }
    public function sekolah($id,$sekolah)
    {
        //
        $data = SippolBpDuaDua::where('bpopp.sippol_bast_bpduadua.id_periode', $id)
            ->leftJoin('bpopp.sippol_jenis', 'bpopp.sippol_bast_bpduadua.id_sippol_jenis', '=', 'bpopp.sippol_jenis.id')
            ->select(
            'bpopp.sippol_bast_bpduadua.id',
            'bpopp.sippol_bast_bpduadua.tanggal',
            'bpopp.sippol_bast_bpduadua.kode',
            'bpopp.sippol_bast_bpduadua.uraian',
            'bpopp.sippol_bast_bpduadua.penerimaan',
            'bpopp.sippol_bast_bpduadua.pengeluaran',
            'bpopp.sippol_jenis.id_kategori'
            )
            ->where('bpopp.sippol_bast_bpduadua.sekolah', $sekolah)
            ->whereNotNull('bpopp.sippol_bast_bpduadua.tanggal')
            ->whereIn('bpopp.sippol_jenis.id_kategori', [1, 2, 3, 4, 5])
            ->orderBy('bpopp.sippol_bast_bpduadua.id', 'ASC')
            ->get();

        $result = $data->groupBy('id_kategori');
        $SippolPeriode = SippolPeriode::find($id);
        $SippolUnitKerja = SippolUnitKerja::with('bastUnitKerja')->where('id_periode', $id)->where('kode', $sekolah)->first();
        // return response()->json($result[1]);
        return view('admin.sippol.unit-kerjas.sekolah', compact('result', 'SippolPeriode', 'SippolUnitKerja'));
    }
    public function export($id,$sekolah)
    {
        //
        $data = SippolBpDuaDua::where('bpopp.sippol_bast_bpduadua.id_periode', $id)
            ->leftJoin('bpopp.sippol_jenis', 'bpopp.sippol_bast_bpduadua.id_sippol_jenis', '=', 'bpopp.sippol_jenis.id')
            ->select(
            'bpopp.sippol_bast_bpduadua.id',
            'bpopp.sippol_bast_bpduadua.tanggal',
            'bpopp.sippol_bast_bpduadua.kode',
            'bpopp.sippol_bast_bpduadua.uraian',
            'bpopp.sippol_bast_bpduadua.penerimaan',
            'bpopp.sippol_bast_bpduadua.pengeluaran',
            'bpopp.sippol_jenis.id_kategori'
            )
            ->where('bpopp.sippol_bast_bpduadua.sekolah', $sekolah)
            ->whereNotNull('bpopp.sippol_bast_bpduadua.tanggal')
            ->whereIn('bpopp.sippol_jenis.id_kategori', [1, 2, 3, 4, 5])
            ->orderBy('bpopp.sippol_bast_bpduadua.id', 'ASC')
            ->get();

        $result = $data->groupBy('id_kategori');
        $SippolUnitKerja = SippolUnitKerja::with('bastUnitKerja')->where('id_periode', $id)->where('kode', $sekolah)->first();
        $fileName = 'Rekap SIPPOL ' . $SippolUnitKerja->bastUnitKerja->nama_unit_kerja . '.xlsx';

        return Excel::download(new SipdExport($id), $fileName);
    }
}