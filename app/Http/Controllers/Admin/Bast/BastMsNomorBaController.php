<?php

namespace App\Http\Controllers\Admin\Bast;
use App\Http\Controllers\Controller;
use App\Models\Bast\BastMsNomorBa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BastMsNomorBaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BastMsNomorBa::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editBastMsNomorBa">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBastMsNomorBa">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.bast.bast-ms-nomor-bas.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_a' => 'nullable|string|max:255',
            'no_b' => 'nullable|string',
            'no_d' => 'nullable|string',
            'no_e' => 'nullable|string'
        ]);

        BastMsNomorBa::updateOrCreate(
            ['id' => $request->input('id')], // Check if ID exists to update, else create
            $request->only(['no_a', 'no_b', 'no_d', 'no_e'])
        );

        return response()->json(['success' => 'BastMsNomorBa saved successfully.']);
    }

    public function edit($id)
    {
        $bastMsNomorBa = BastMsNomorBa::find($id);
        return response()->json($bastMsNomorBa);
    }

    public function destroy($id)
    {
        BastMsNomorBa::find($id)->delete();
        return response()->json(['success' => 'BastMsNomorBa deleted successfully.']);
    }
    public function fetchAll()
    {
        return BastMsNomorBa::latest()->get();
    }
}