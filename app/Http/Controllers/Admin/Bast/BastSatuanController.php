<?php

namespace App\Http\Controllers\Admin\Bast;
use App\Http\Controllers\Controller;

use App\Models\Bast\BastSatuan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BastSatuanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BastSatuan::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editBastSatuan">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBastSatuan">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.bast.bast-satuans.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255'
        ]);

        BastSatuan::updateOrCreate(
            ['id' => $request->input('id')], // Check if ID exists to update, else create
            $request->only(['nama_satuan'])
        );

        return response()->json(['success' => 'BastSatuan saved successfully.']);
    }

    public function edit($id)
    {
        $bastSatuan = BastSatuan::find($id);
        return response()->json($bastSatuan);
    }

    public function destroy($id)
    {
        BastSatuan::find($id)->delete();
        return response()->json(['success' => 'BastSatuan deleted successfully.']);
    }
}