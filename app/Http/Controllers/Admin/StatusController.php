<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class StatusController extends Controller
{
    public function index()
    {
        return view('admin.status.index');
    }

    public function data(Request $request)
    {
        $data = Status::get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-info btn-edit" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        Status::create([
            'uuid' => Str::uuid(),
            'nama' => $request->nama,
            'created_by' => auth()->id(),
        ]);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return response()->json(Status::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $status = Status::findOrFail($id);
        $status->update([
            'nama' => $request->nama,
            'updated_by' => auth()->id(),
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        $status->deleted_by = auth()->id();
        $status->save();
        $status->delete();

        return response()->json(['success' => true]);
    }
}
