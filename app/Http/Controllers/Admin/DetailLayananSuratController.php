<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailLayananSurat;
use App\Models\LayananSurat; // Import LayananSurat model for dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Status;

class DetailLayananSuratController extends Controller
{
    public function data($id)
    {
        $tracking = DetailLayananSurat::where('layanan_surat_id', $id)
            ->with('status')
            ->with('createdBy')
            ->orderBy('created_at', 'desc')
            ->get();
        $data = LayananSurat::find($id);
        $status =  Status::get();
        return view('admin.detail-layanan-surat.index', compact('tracking', 'data', 'status'));
    }

    public function store(Request $request)
    {
        DetailLayananSurat::create(array_merge($request->all(), [
            'created_by' => auth()->id(),
        ]));
        if ($request->status_id == 4) {
            $detailLayanan = LayananSurat::find($request->layanan_surat_id);
            $detailLayanan->tgl_selesai = now();
            $detailLayanan->save();
        }
        return response()->json(['success' => true]);
    }
    public function show($id)
    {
        $data = DetailLayananSurat::findOrFail($id);
        $data['tgl'] = $data->tgl_layanan ? $data->tgl_layanan->format('Y-m-d') : null;
        return response()->json($data);
    }
    public function update(Request $request, $id)
    {
        $data = DetailLayananSurat::findOrFail($id);
        $data->update(array_merge($request->all(), [
            'updated_by' => auth()->id(),
        ]));
        return response()->json(['success' => true]);
    }
    public function destroy($id)
    {
        $data = DetailLayananSurat::findOrFail($id);
        $data->deleted_by = auth()->id();
        $data->save();
        $data->delete();
        return response()->json(['success' => true]);
    }
}
