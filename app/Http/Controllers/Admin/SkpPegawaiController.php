<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Pegawai;
use App\Models\SkpPegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use App\Imports\pegawaiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class SkpPegawaiController extends Controller
{
    public function index()
    {
        return view('admin.skp-pegawai.index');
    }

    public function data(Request $request)
    {
        $data = SkpPegawai::get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<a href="'.route('skp-pegawai-detail.index',$row->uuid).'" class="btn btn-sm btn-info btn-edit"">data skp</a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
            })
            ->editColumn('batch', function ($row) {
                return $row->batch ? date('d-m-Y H:i', strtotime($row->batch)) : '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $kon = SkpPegawai::create(array_merge($request->all(), [
                'uuid' => Str::uuid(),
                'created_by' => auth()->id(),
            ]));
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        return response()->json(Pemohon::findOrFail($id));
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
    public function import(Request $request)
    {
        // Validate the request to ensure a file is uploaded
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            // Perform the import using the UsersImport class
            Excel::import(new pegawaiImport, $request->file('file'));

            return response()->json([
                'status' => 'success',
                'msg' => 'pegawai imported successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error importing pegawai: ' . $e->getMessage()
            ], 500);
        }
    }
}
