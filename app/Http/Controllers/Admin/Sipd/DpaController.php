<?php

namespace App\Http\Controllers\Admin\Sipd;

use App\Http\Controllers\Controller;

use App\Models\ViewDpa;
use App\Models\SubsSubBl;
use App\Models\Akun;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class DpaController extends Controller
{
    public function index($jenis)
    {
        $akun = Akun::where('id_tahun',$jenis)->get();
        $unit = SubsSubBl::where('id_tahun',$jenis)->get();
        $tahun = Tahun::where('id_tahun',$jenis)->first();
        return view('admin.sipd.dpa.index', compact('akun','jenis','unit','tahun'));
    }

    public function data(Request $request,$jenis)
    {
        if ($request->ajax()) {
        
            $query = ViewDpa::where('id_tahun',$jenis);
            if ($request->input('kode_akun')) {
                //$query->where('code','=',$auid );
                $query->where('kode_akun', $request->input('kode_akun'));
            }
            if ($request->input('nama_akun')) {
                //$query->where('code','=',$auid );
                $query->where('kode_akun', $request->input('nama_akun'));
            }
            if ($request->input('unit')) {
                //$query->where('code','=',$auid );
                $query->where('subs_bl_teks', $request->input('unit'));
            }
            if ($request->input('bm')) {
                //$query->where('code','=',$auid );
                $query->where('is_bm', $request->input('bm'));
            }
            $data = $query->get();
            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function ($row) {
                //     return '
                //     <a href="" class="btn btn-sm btn-warning btn-eye" data-id="' . $row->subs_bl_teks . '">detail</a>';
                // })
                ->addColumn('harga_awal', function ($row) {
                    return 'Rp ' . number_format($row->harga_sebelum, 0, ',', '.');
                })
                ->addColumn('total_awal', function ($row) {
                    return 'Rp ' . number_format($row->total_sebelum, 0, ',', '.');
                })
                ->addColumn('harga_akhir', function ($row) {
                    return 'Rp ' . number_format($row->harga_setelah, 0, ',', '.');
                })
                ->addColumn('total_akhir', function ($row) {
                    return 'Rp ' . number_format($row->total_setelah, 0, ',', '.');
                })
                ->addColumn('selisih', function ($row) {
                    $selisih = $row->total_setelah - $row->total_sebelum;
                    return 'Rp ' . number_format($selisih, 0, ',', '.');
                })
                ->rawColumns([ 'selisih','harga_awal'])
                ->make(true);
        }
    }
    public function create()
    {
        //
        return view('admin.sipd.dpa.create');
    }
    public function store(Request $request)
    {
        // ✅ Validasi
        $request->validate([
            'id_rinci_sub_bl' => 'required|file|mimes:json|max:5120',
            'id_subs_sub_bl' => 'required|file|mimes:json|max:5120',
            'id_ket_sub_bl' => 'required|file|mimes:json|max:5120',
        ]);

        // ✅ Ambil file
        $file1 = $request->file('id_rinci_sub_bl');
        $file2 = $request->file('id_subs_sub_bl');
        $file3 = $request->file('id_ket_sub_bl');


        // ✅ Baca isi JSON langsung (TANPA simpan)
        $json1 = json_decode(file_get_contents($file1->getRealPath()), true);
        $json2 = json_decode(file_get_contents($file2->getRealPath()), true);
        $json3 = json_decode(file_get_contents($file3->getRealPath()), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors('File JSON tidak valid');
        }

        // 🔎 Contoh akses data
        // $json['data'][0]['name']

        return response()->json([
            'status' => true,
            'data' => [
                'id_rinci_sub_bl' => $json1,
                'id_subs_sub_bl' => $json2,
                'id_ket_sub_bl' => $json3,
            ],
        ]);
    }
}