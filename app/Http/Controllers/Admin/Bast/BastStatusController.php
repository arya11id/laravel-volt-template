<?php

namespace App\Http\Controllers\Admin\Bast;
use App\Http\Controllers\Controller;

use App\Models\Bast\BastStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BastStatusController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BastStatus::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editBastStatus">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBastStatus">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.bast.bast-statuss.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_status' => 'required|string|max:255'
        ]);

        BastStatus::updateOrCreate(
            ['id' => $request->input('id')], // Check if ID exists to update, else create
            $request->only(['nama_status'])
        );

        return response()->json(['success' => 'BastStatus saved successfully.']);
    }

    public function edit($id)
    {
        $bastStatus = BastStatus::find($id);
        return response()->json($bastStatus);
    }

    public function destroy($id)
    {
        BastStatus::find($id)->delete();
        return response()->json(['success' => 'BastStatus deleted successfully.']);
    }
}