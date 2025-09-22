<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Pemohon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use App\Models\UnitKerja;

class PemohonController extends Controller
{
    public function index()
    {
        $unitKerja = UnitKerja::get();
        return view('admin.pemohon.index', compact('unitKerja'));
    }

    public function data(Request $request)
    {
        $data = Pemohon::with('unitKerja')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-info btn-edit" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
            })
            ->editColumn('tgllahir', function ($row) {
                return $row->tgl_lahir ? date('d-m-Y', strtotime($row->tgl_lahir)) : '';
            })

            ->rawColumns(['action', 'tgllahir'])
            ->make(true);
    }

    public function store(Request $request)
    {
        Pemohon::create(array_merge($request->all(), [
            'uuid' => Str::uuid(),
            'created_by' => auth()->id(),
        ]));

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return response()->json(Pemohon::with('unitKerja')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $pemohon = Pemohon::findOrFail($id);
        $pemohon->update(array_merge($request->all(), [
            'updated_by' => auth()->id(),
        ]));
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Pemohon::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
