<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Pegawai;
use App\Models\SkpPegawaiDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use App\Imports\KinerjaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SkpPegawai;
use Illuminate\Support\Facades\DB;

class SkpPegawaiDetailController extends Controller
{
    public function index($uuid)
    {
        $data = SkpPegawai::where('uuid',$uuid)->first();
        dd($data);
        return view('admin.skp-pegawai-detail.index',compact('data'));
    }

    public function data(Request $request,$uuid)
    {
        $data = Pegawai::get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-info btn-edit" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '">Hapus</button>';
            })
            ->editColumn('tgllahir', function ($row) {
                return $row->tgl_lahir ? date('d-m-Y', strtotime($row->tgl_lahir)) : '';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        Pegawai::create(array_merge($request->all(), [
            'uuid' => Str::uuid(),
            'created_by' => auth()->id(),
        ]));

        return response()->json(['success' => true]);
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
            Excel::import(new KinerjaImport($request->jenis,$request->id), $request->file('file'));

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
