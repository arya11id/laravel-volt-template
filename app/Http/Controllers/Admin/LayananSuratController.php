<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LayananSurat;
use App\Models\DetailLayananSurat; // If you want to manage details from here
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables; // Make sure to install Yajra/Laravel-DataTables
use App\Models\JenisLayanan;

class LayananSuratController extends Controller
{
    public function index()
    {
        $jenisLayanan = JenisLayanan::all();
        return view('admin.layanan-surat.index', compact('jenisLayanan'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = LayananSurat::select([
                'id',
                'uuid',
                'no_surat',
                'tgl_surat',
                'keterangan',
                'jenis_layanan_id',
                'tgl_pengajuan',
                'tgl_selesai',
                'url_file',
                'created_at',
                'updated_at'
            ]);

            return DataTables::of($data)
                ->addIndexColumn() // Add a "DT_RowIndex" column for numbering
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm editLayananSurat">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteLayananSurat">Delete</a>';
                    // Add a button to view details if needed
                    // $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Details" class="btn btn-secondary btn-sm viewDetails">Details</a>';
                    return $btn;
                })
                ->editColumn('tgl_pengajuan', function ($row) {
                    return $row->tgl_pengajuan ? $row->tgl_pengajuan->format('d-m-Y') : '-';
                })
                ->editColumn('tgl_surat', function ($row) {
                    return $row->tgl_surat ? $row->tgl_surat->format('d-m-Y') : '-';
                })
                ->addColumn('riwayat', function ($row) {
                    return '<a href="' . route('layanan-surat-detail.data', $row->id) . '" class="btn btn-sm btn-primary btn-track" ">tracking</a>';
                })
                ->rawColumns(['action', 'riwayat'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_surat' => 'required|string|max:255',
            'tgl_surat' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'jenis_layanan_id' => 'nullable|integer',
            'tgl_pengajuan' => 'nullable|date',
            'tgl_selesai' => 'nullable|date',
            'url_file' => 'nullable|string', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // $data = $request->except('url_file'); // Get all data except file

        // if ($request->hasFile('url_file')) {
        //     $filePath = $request->file('url_file')->store('public/layanan_surat_files');
        //     $data['url_file'] = Storage::url($filePath); // Get public URL
        // }

        // Populate created_by/updated_by if authenticated
        // $data['created_by'] = auth()->id();
        // $data['updated_by'] = auth()->id();

        LayananSurat::updateOrCreate(['id' => $request->layanan_surat_id], $request->all());

        return response()->json(['success' => 'Layanan Surat saved successfully.']);
    }

    public function edit($id)
    {
        $layananSurat = LayananSurat::find($id);
        return response()->json($layananSurat);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_surat' => 'required|string|max:255',
            'tgl_surat' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'jenis_layanan_id' => 'nullable|integer',
            'tgl_pengajuan' => 'nullable|date',
            'tgl_selesai' => 'nullable|date',
            'url_file' => 'nullable|string', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        LayananSurat::updateOrCreate(['id' => $request->layanan_surat_id], $request->all());

        return response()->json(['success' => 'Layanan Surat saved successfully.']);
    }

    public function destroy($id)
    {
        $layananSurat = LayananSurat::find($id);

        if (!$layananSurat) {
            return response()->json(['error' => 'Layanan Surat not found.'], 404);
        }

        // Optional: Delete associated file from storage
        if ($layananSurat->url_file) {
            $filePath = str_replace('/storage/', 'public/', $layananSurat->url_file);
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }

        $layananSurat->delete(); // Soft delete

        return response()->json(['success' => 'Layanan Surat deleted successfully.']);
    }
}
