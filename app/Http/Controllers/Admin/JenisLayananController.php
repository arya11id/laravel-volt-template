<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class JenisLayananController extends Controller
{
    //
    public function index()
    {
        return view('admin.jenis-layanan.index');
    }

    public function data(Request $request)
    {
        $data = JenisLayanan::get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-info btn-edit" data-id="' . $row->id . '">Edit</button> <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        JenisLayanan::create(array_merge($request->all(), [
            'uuid' => Str::uuid(),
            'created_by' => auth()->id(),
        ]));

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return response()->json(JenisLayanan::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $layanan = JenisLayanan::findOrFail($id);
        $layanan->update(array_merge($request->all(), [
            'updated_by' => auth()->id(),
        ]));
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        JenisLayanan::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
