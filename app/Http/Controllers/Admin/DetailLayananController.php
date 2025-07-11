<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\DetailLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Models\JenisLayanan;
use App\Models\Pemohon;

class DetailLayananController extends Controller
{
    public function index()
    {
        $pemohon = Pemohon::all();
        $jenisLayanan = JenisLayanan::all();
        return view('admin.detail-layanan.index', compact('pemohon', 'jenisLayanan'));
    }

    public function data(Request $request)
    {
        $data = DetailLayanan::with('jenisLayanan')->with('pemohon')->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-info btn-edit" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
            })
            ->editColumn('tgl_pengajuan', function ($row) {
                return $row->tgl_pengajuan ? $row->tgl_pengajuan->format('d-m-Y') : '-';
            })
            ->editColumn('tgl_selesai', function ($row) {
                return $row->tgl_selesai ? $row->tgl_selesai->format('d-m-Y') : '-';
            })
            ->addColumn('riwayat', function ($row) {
                return '<a href="' . route('tracking.data', $row->id) . '" class="btn btn-sm btn-primary btn-track" ">tracking</a>';
            })
            ->rawColumns(['action', 'riwayat'])
            ->make(true);
    }

    public function store(Request $request)
    {
        DetailLayanan::create(array_merge($request->all(), [
            'uuid' => Str::uuid(),
            'created_by' => auth()->id(),
        ]));
        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return response()->json(DetailLayanan::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $data = DetailLayanan::findOrFail($id);
        $data->update(array_merge($request->all(), [
            'updated_by' => auth()->id(),
        ]));
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $data = DetailLayanan::findOrFail($id);
        $data->deleted_by = auth()->id();
        $data->save();
        $data->delete();
        return response()->json(['success' => true]);
    }
}
