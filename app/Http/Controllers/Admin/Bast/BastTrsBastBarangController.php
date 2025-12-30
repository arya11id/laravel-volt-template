<?php

namespace App\Http\Controllers\Admin\Bast;

use App\Models\Bast\BastTrsBastBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Bast\BastSatuan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Bast\BastTransaksi;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

class BastTrsBastBarangController extends Controller
{
    public function show(Request $request, $id)
    {
        $satuan = BastSatuan::orderBy('nama_satuan','ASC')->get();
        $data = BastTransaksi::with('bastUnitKerja', 'bastTrsNomorBa', 'bastPengurusbarang', 'bastStatus')->where('id', $id)->first();
        return view('admin.bast.bast-trs-bast-barangs.index', compact('id', 'satuan', 'data'));
    }
    public function data(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = BastTrsBastBarang::with('satuan')->where('id_bast_transaksi', $id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editBastTrsBastBarang">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBastTrsBastBarang">Delete</a>';
                    return $btn;
                })
                ->addColumn('barang_file_a', function($row){
                    if($row->barang_file_name_a){
                        $btn = '<a href="'.route('bast-trs-bast-barangs.showFile', ['id' => $row->uuid, 'letter' => 'a']).'" target="_blank">View File A</a>';
                        return $btn;
                    } else {
                        return 'No File';
                    }
                })
                ->addColumn('barang_file_b', function($row){
                    if($row->barang_file_name_b){
                        $btn = '<a href="'.route('bast-trs-bast-barangs.showFile', ['id' => $row->uuid, 'letter' => 'b']).'" target="_blank">View File B</a>';
                        return $btn;
                    } else {
                        return 'No File';
                    }
                })
                ->addColumn('barang_file_c', function($row){
                    if($row->barang_file_name_c){
                        $btn = '<a href="'.route('bast-trs-bast-barangs.showFile', ['id' => $row->uuid, 'letter' => 'c']).'" target="_blank">View File C</a>';
                        return $btn;
                    } else {
                        return 'No File';
                    }
                })
                ->addColumn('barang_file_d', function($row){
                    if($row->barang_file_name_d){
                        $btn = '<a href="'.route('bast-trs-bast-barangs.showFile', ['id' => $row->uuid, 'letter' => 'd']).'" target="_blank">View File D</a>';
                        return $btn;
                    } else {
                        return 'No File';
                    }
                })
                ->addColumn('harga_satuan', function($row){
                    return 'Rp '.number_format($row->harga_satuan, 2, ',', '.');
                })
                ->rawColumns(['action', 'barang_file_a', 'barang_file_b', 'barang_file_c', 'barang_file_d', 'harga_satuan'])
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
            'barang_file_name_a' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'barang_file_name_b' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'barang_file_name_c' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'barang_file_name_d' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'tgl_selesai_nego' => 'required|date',
            'tgl_datang_barang' => 'required|date'
        ]);

        $data = $request->only(['id_bast_transaksi', 'jenis', 'uraian', 'volume', 'id_bast_satuan', 'harga_satuan', 'tgl_selesai_nego', 'tgl_datang_barang']);

        // Handle file uploads
        foreach (['a', 'b', 'c', 'd'] as $letter) {
            if ($request->hasFile("barang_file_name_$letter")) {
                $file = $request->file("barang_file_name_$letter");
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('bast-barang', $filename, 'public');
                $data["barang_file_name_$letter"] = $filename;
                $data["barang_file_path_$letter"] = $path;
            }
        }

        BastTrsBastBarang::updateOrCreate(
            ['id' => $request->input('id')],
            $data
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
    public function showFile($id, $letter)
    {
        $bastTrsBastBarang = BastTrsBastBarang::whereUuid($id)->firstOrFail();
        $filePath = $bastTrsBastBarang->{"barang_file_path_$letter"};

        if (Storage::disk('public')->exists($filePath)) {
            return response()->file(storage_path('app/public/' . $filePath));
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
    public function cetakPdf($uuid)
    {
        // This function can be implemented to generate PDF reports
        $data = BastTransaksi::with('bastUnitKerja', 'bastTrsNomorBa', 'bastPengurusbarang', 'bastStatus')->whereUuid($uuid)->first();
        $bastTrsBastBarang = BastTrsBastBarang::where('id_bast_transaksi', $data->id)->get();
        // dd($bastTrsBastBarang);
        Carbon::setLocale('id');
        $tanggal =  $data->bastTrsNomorBa->tgl_nomor;
        try {
            $date = Carbon::createFromFormat('d/m/Y', trim($tanggal));
        } catch (\Exception $e) {
            $date = Carbon::parse($tanggal);
        }

        $hari = $date->translatedFormat('l');
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        // PDF generation logic goes here
        $pdf = PDF::loadView('admin.bast.bast-trs-bast-barangs.cetak-new', compact('data', 'bastTrsBastBarang', 'hari', 'date','bulan'));
        $fileName = $data->bastTrsNomorBa->no_c.' .'.$data->nomor_surat.' - BERITA ACARA SERAH TERIMA BELANJA MODAL - ' . $data->bastUnitKerja->nama_unit_kerja;
       
        return $pdf->setPaper('a4')->stream($fileName . '.pdf');
    }
    public function cetakWord($uuid)
{
    // Mengambil data utama [cite: 10, 32]
    $data = BastTransaksi::with('bastUnitKerja', 'bastTrsNomorBa', 'bastPengurusbarang', 'bastStatus')
            ->whereUuid($uuid)
            ->firstOrFail();

    // Mengambil data detail barang [cite: 32]
    $bastTrsBastBarang = BastTrsBastBarang::where('id_bast_transaksi', $data->id)->get();

    Carbon::setLocale('id');
    $tanggal = $data->bastTrsNomorBa->tgl_nomor;
    
    try {
        $date = Carbon::createFromFormat('d/m/Y', trim($tanggal));
    } catch (\Exception $e) {
        $date = Carbon::parse($tanggal);
    }

    $hari = $date->translatedFormat('l');

    // Render View menjadi String 
    $html = View::make('admin.bast.bast-trs-bast-barangs.cetak-word', compact('data', 'bastTrsBastBarang', 'hari', 'date'))->render();
    $fileName = $data->bastTrsNomorBa->no_c.' .'.$data->nomor_surat.' - BERITA ACARA SERAH TERIMA BELANJA MODAL - ' . $data->bastUnitKerja->nama_unit_kerja;
    return response($html)
        ->header('Content-Type', 'application/msword')
        ->header('Content-Disposition', 'attachment; filename="' . $fileName . '.doc"');
    // --- PERBAIKAN STRUKTUR HTML UNTUK PHPWORD ---
    // 1. Ambil isi di dalam body saja (PhpWord tidak suka tag head/body lengkap)
    if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches)) {
        $html = $matches[1];
    }

    // 2. Bersihkan spasi berlebih dan baris baru yang tidak perlu
    $html = str_replace(["\n", "\r", "\t"], '', $html);

    // 3. Pastikan entitas karakter benar
    $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
    $html = str_replace('&', '&amp;', $html);

    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $phpWord->setDefaultFontName('Times New Roman');
    $phpWord->setDefaultFontSize(11);

    // Konfigurasi Margin A4 
    $section = $phpWord->addSection([
        'paperSize'    => 'A4',
        'marginLeft'   => 1134, // Sekitar 2cm
        'marginRight'  => 1134,
        'marginTop'    => 1134,
        'marginBottom' => 1134,
    ]);

    // Tambahkan HTML ke Section 
    if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches)) {
        $html = $matches[1];
    }

    // 2. Gunakan Regex untuk memaksa self-closing pada tag img, br, dan hr
    $html = preg_replace('/<(img|br|hr)([^>]*)(?<!\/)>/i', '<$1$2 />', $html);

    // 3. Pastikan tidak ada karakter & telanjang yang merusak XML
    $html = str_replace('&', '&amp;', $html);
    $html = str_replace('&amp;amp;', '&amp;', $html); // Cegah double encoding

    // 4. Load ke PhpWord
    Html::addHtml($section, $html, false, false);

    // Penamaan file yang aman
    $safeUnitName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $data->bastUnitKerja->nama_unit_kerja);
    $fileName = $data->bastTrsNomorBa->no_c . ' .' . $data->nomor_surat . ' - BAST - ' . $safeUnitName . '.docx';
    
    $path = storage_path('app/public/' . $fileName);

    $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($path);

    return response()->download($path)->deleteFileAfterSend(true);
}
}