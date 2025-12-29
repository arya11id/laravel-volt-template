<?php

namespace App\Http\Controllers\Admin\Bast;

use App\Models\Bast\BastTransaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Bast\BastUnitKerja;
use App\Models\Bast\BastTrsNomorBa;

class BastTransaksiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BastTransaksi::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editBastTransaksi">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBastTransaksi">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $BastUnitKerja = BastUnitKerja::orderBy('no_urut','ASC')->get();
        $BastTrsNomorBa = BastTrsNomorBa::orderBy('tgl_nomor','ASC')->get();

        return view('admin.bast.bast-transaksis.index', compact('BastUnitKerja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bast_unit_kerja' => 'required|integer',
            'id_trs_nomor_ba' => 'required|integer',
            'id_pengurus_barang' => 'required|integer',
            'id_bast_status' => 'required|integer',
            'nomor_surat' => 'required|string',
            'surat_pesanan_path' => 'required|string',
            'surat_pesanan_file' => 'required|string'
        ]);

        BastTransaksi::updateOrCreate(
            ['id' => $request->input('id')], // Check if ID exists to update, else create
            $request->only(['id_bast_unit_kerja', 'id_trs_nomor_ba', 'id_pengurus_barang', 'id_bast_status', 'nomor_surat', 'surat_pesanan_path', 'surat_pesanan_file'])
        );

        return response()->json(['success' => 'BastTransaksi saved successfully.']);
    }

    public function edit($id)
    {
        $bastTransaksi = BastTransaksi::find($id);
        return response()->json($bastTransaksi);
    }

    public function destroy($id)
    {
        BastTransaksi::find($id)->delete();
        return response()->json(['success' => 'BastTransaksi deleted successfully.']);
    }
}