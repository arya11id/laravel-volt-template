<?php

namespace App\Http\Controllers\Admin\Bast;
use App\Http\Controllers\Controller;

use App\Models\Bast\BastUnitKerja;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BastUnitKerjaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BastUnitKerja::orderBy('no_urut','ASC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editBastUnitKerja">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBastUnitKerja">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.bast.bast-unit-kerjas.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit_kerja' => 'required|string|max:255',
            'kode_unit_kerja' => 'required|string',
            'nip_ks' => 'required|string',
            'nama_ks' => 'required|string',
            'nip_bendahara' => 'required|string',
            'nama_bendahara' => 'required|string',
            'jenis' => 'required|string',
            'no_urut' => 'required|string'
        ]);

        BastUnitKerja::updateOrCreate(
            ['id' => $request->input('id')], // Check if ID exists to update, else create
            $request->only(['nama_unit_kerja', 'kode_unit_kerja', 'nip_ks', 'nama_ks', 'nip_bendahara', 'nama_bendahara', 'jenis', 'no_urut'])
        );

        return response()->json(['success' => 'BastUnitKerja saved successfully.']);
    }

    public function edit($id)
    {
        $bastUnitKerja = BastUnitKerja::find($id);
        return response()->json($bastUnitKerja);
    }

    public function destroy($id)
    {
        BastUnitKerja::find($id)->delete();
        return response()->json(['success' => 'BastUnitKerja deleted successfully.']);
    }
}