<?php

namespace App\Http\Controllers\Admin\Bast;

use App\Models\Bast\BastTransaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Bast\BastUnitKerja;
use App\Models\Bast\BastTrsNomorBa;
use App\Models\Bast\BastPengurusbarang;
use App\Models\Bast\BastStatus;
use Illuminate\Support\Str;

class BastTransaksiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BastTransaksi::with('bastUnitKerja', 'bastTrsNomorBa', 'bastPengurusbarang', 'bastStatus')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('bast-trs-bast-barangs.index', ['id' => $row->id]).'" class="edit btn btn-success btn-sm">barang</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editBastTransaksi">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBastTransaksi">Delete</a>';
                    return $btn;
                })
                ->addColumn('bast_unit_kerja', function($row){
                    return $row->bastUnitKerja ? $row->bastUnitKerja->nama_unit_kerja : '';
                })
                ->addColumn('bast_trs_nomor_ba', function($row){
                    // return $row->bastTrsNomorBa ? $row->bastTrsNomorBa->no_c : '';
                    return $row->bastTrsNomorBa->bastMsNomorBa->no_a . '/' . $row->bastTrsNomorBa->bastMsNomorBa->no_b . '/' . $row->bastTrsNomorBa->no_c .'.'. $row->nomor_surat.'/' . $row->bastTrsNomorBa->bastMsNomorBa->no_d . '/' . $row->bastTrsNomorBa->bastMsNomorBa->no_e;
                })
                ->addColumn('bast_pengurus_barang', function($row){
                    return $row->bastPengurusbarang ? $row->bastPengurusbarang->nama_pengurus : '';
                })
                ->addColumn('bast_status', function($row){
                    return $row->bastStatus ? $row->bastStatus->nama_status : '';
                })
                ->addColumn('surat_pesanan', function($row){
                    $downloadUrl = route('bast-transaksis-download-file', ['id' => $row->uuid]);
                    $btn = '<a href="'.route('bast-trs-bast-barangs.cetakPdf', $row->uuid).'" class="edit btn btn-danger btn-sm" target="_blank">cetak</a>';
                    return '<a href="'.$downloadUrl.'" class="btn btn-success btn-sm">Download File</a> '.$btn;
                })
                ->addColumn('no_surat', function($row){
                    return $row->bastTrsNomorBa->no_c .'.'. $row->nomor_surat;
                })
                ->rawColumns(['action', 'bast_unit_kerja', 'bast_trs_nomor_ba', 'bast_pengurus_barang', 'bast_status', 'surat_pesanan', 'no_surat'])
                ->make(true);
        }
        $BastUnitKerja = BastUnitKerja::orderBy('no_urut','ASC')->get();
        $BastTrsNomorBa = BastTrsNomorBa::latest()->get();
        $BastPengurusbarang = BastPengurusbarang::latest()->get();
        $BastStatus = BastStatus::latest()->get();

        return view('admin.bast.bast-transaksis.index', compact('BastUnitKerja', 'BastTrsNomorBa', 'BastPengurusbarang', 'BastStatus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bast_unit_kerja' => 'required|integer',
            'id_trs_nomor_ba' => 'required|integer',
            'id_pengurus_barang' => 'required|integer',
            'id_bast_status' => 'required|integer',
            'nomor_surat' => 'required|string',
            'surat_pesanan_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);
        $cek = BastTransaksi::where('id_trs_nomor_ba', $request->id_trs_nomor_ba)
                ->where('nomor_surat', $request->nomor_surat)
                ->count();
        $data = $request->only(['id_bast_unit_kerja', 'id_trs_nomor_ba', 'id_pengurus_barang', 'id_bast_status', 'nomor_surat']);

        if ($request->hasFile('surat_pesanan_file')) {
            $file = $request->file('surat_pesanan_file');
            $fileName = (string) Str::uuid() .'-'. time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bast-transaksi', $fileName, 'public');
            $data['surat_pesanan_file'] = $fileName;
            $data['surat_pesanan_path'] = $filePath;
        }

        BastTransaksi::updateOrCreate(
            ['id' => $request->input('id')],
            $data
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
    public function downloadFile($id)
    {
        $bastTransaksi = BastTransaksi::with('bastUnitKerja', 'bastTrsNomorBa')->whereUuid($id)->first();
        if ($bastTransaksi->surat_pesanan_path) {
            $filePath = storage_path('app/public/' . $bastTransaksi->surat_pesanan_path);
            return response()->download($filePath, $bastTransaksi->bastTrsNomorBa->no_c.' .'.$bastTransaksi->nomor_surat.' - BERITA ACARA SERAH TERIMA BELANJA MODAL - ' . $bastTransaksi->bastUnitKerja->nama_unit_kerja . '.pdf');
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
}