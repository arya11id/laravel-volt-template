<?php

namespace App\Http\Controllers\Admin\Bast;

use App\Models\Bast\BastTrsBastBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class BastTrsBastBarangController extends Controller
{
    public function show(Request $request, $id)
    {
        $satuan = BastSatuan::orderBy('nama_satuan','ASC')->get();
        return view('admin.bast.bast-trs-bast-barangs.index', compact('id'));
    }
    public function data(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = BastTrsBastBarang::where('id_bast_transaksi', $id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editBastTrsBastBarang">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBastTrsBastBarang">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bast_transaksi' => 'required|integer',
            'jenis' => 'required|string',
            'uraian' => 'required|string',
            'volume' => 'required|string',
            'id_bast_satuan' => 'required|integer',
            'harga_satuan' => 'required|string',
            'barang_file_name_a' => 'required|string',
            'barang_file_path_a' => 'required|string',
            'barang_file_name_b' => 'required|string',
            'barang_file_path_b' => 'required|string',
            'barang_file_name_c' => 'required|string',
            'barang_file_path_c' => 'required|string',
            'barang_file_name_d' => 'required|string',
            'barang_file_path_d' => 'required|string',
            'tgl_selesai_nego' => 'required|date',
            'tgl_datang_barang' => 'required|date'
        ]);

        BastTrsBastBarang::updateOrCreate(
            ['id' => $request->input('id')], // Check if ID exists to update, else create
            $request->only(['id_bast_transaksi', 'jenis', 'uraian', 'volume', 'id_bast_satuan', 'harga_satuan', 'barang_file_name_a', 'barang_file_path_a', 'barang_file_name_b', 'barang_file_path_b', 'barang_file_name_c', 'barang_file_path_c', 'barang_file_name_d', 'barang_file_path_d', 'tgl_selesai_nego', 'tgl_datang_barang'])
        );

        return response()->json(['success' => 'BastTrsBastBarang saved successfully.']);
    }

    public function edit($id)
    {
        $bastTrsBastBarang = BastTrsBastBarang::find($id);
        return response()->json($bastTrsBastBarang);
    }

    public function destroy($id)
    {
        BastTrsBastBarang::find($id)->delete();
        return response()->json(['success' => 'BastTrsBastBarang deleted successfully.']);
    }
}