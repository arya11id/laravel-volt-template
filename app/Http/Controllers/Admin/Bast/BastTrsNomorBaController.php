<?php

namespace App\Http\Controllers\Admin\Bast;

use App\Models\Bast\BastTrsNomorBa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Bast\BastMsNomorBa;

class BastTrsNomorBaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BastTrsNomorBa::with('bastMsNomorBa')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editBastTrsNomorBa">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBastTrsNomorBa">Delete</a>';
                    return $btn;
                })
                ->addColumn('ms_nomor_ba', function($row){
                    return $row->bastMsNomorBa ? $row->bastMsNomorBa->no_a . '/' . $row->bastMsNomorBa->no_b . '/.../' . $row->bastMsNomorBa->no_d . '/' . $row->bastMsNomorBa->no_e : '';
                })
                ->rawColumns(['action', 'ms_nomor_ba'])
                ->make(true);
        }
        $BastMsNomorBa = BastMsNomorBa::latest()->get();
        return view('admin.bast.bast-trs-nomor-bas.index', compact('BastMsNomorBa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bast_ms_nomor_ba' => 'required|integer',
            'tgl_nomor' => 'required|date',
            'no_c' => 'required|string'
        ]);

        BastTrsNomorBa::updateOrCreate(
            ['id' => $request->input('id')], // Check if ID exists to update, else create
            $request->only(['id_bast_ms_nomor_ba', 'tgl_nomor', 'no_c'])
        );

        return response()->json(['success' => 'BastTrsNomorBa saved successfully.']);
    }

    public function edit($id)
    {
        $bastTrsNomorBa = BastTrsNomorBa::find($id);
        return response()->json($bastTrsNomorBa);
    }

    public function destroy($id)
    {
        BastTrsNomorBa::find($id)->delete();
        return response()->json(['success' => 'BastTrsNomorBa deleted successfully.']);
    }
}