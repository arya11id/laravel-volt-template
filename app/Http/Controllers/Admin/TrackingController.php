<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\RiwayatLayanan;
use App\Models\DetailLayanan;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TrackingController extends Controller
{
    //
    public function index($id)
    {
        $tracking = RiwayatLayanan::where('detail_layanan_id', $id)
            ->with('status')
            ->with('createdBy')
            ->orderBy('created_at', 'desc')
            ->get();
        $data = DetailLayanan::with('jenisLayanan')->with('pemohon')->find($id);
        $status =  Status::get();
        return view('admin.tracking.index', compact('tracking', 'data', 'status'));
    }
    public function store(Request $request)
    {
        RiwayatLayanan::create(array_merge($request->all(), [
            'uuid' => Str::uuid(),
            'created_by' => auth()->id(),
        ]));
        return response()->json(['success' => true]);
    }
    public function show($id)
    {
        return response()->json(RiwayatLayanan::findOrFail($id));
    }
    public function update(Request $request, $id)
    {
        $data = RiwayatLayanan::findOrFail($id);
        $data->update(array_merge($request->all(), [
            'updated_by' => auth()->id(),
        ]));
        return response()->json(['success' => true]);
    }
    public function destroy($id)
    {
        $data = RiwayatLayanan::findOrFail($id);
        $data->deleted_by = auth()->id();
        $data->save();
        $data->delete();
        return response()->json(['success' => true]);
    }
}
