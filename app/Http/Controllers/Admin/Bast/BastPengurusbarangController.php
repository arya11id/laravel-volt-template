<?php

namespace App\Http\Controllers\Admin\Bast;
use App\Http\Controllers\Controller;
use App\Models\Bast\BastPengurusbarang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BastPengurusbarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BastPengurusbarang::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editBastPengurusbarang">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBastPengurusbarang">Delete</a>';
                    return $btn;
                })
                ->addColumn('nip_x', function($row){
                    $angka = $row->nip_pengurus;
                    $hasil = substr($angka, 0, 8) . ' ' .   // 19851016
                            substr($angka, 8, 6) . ' ' .   // 202421
                            substr($angka, 14, 1) . ' ' .  // 2
                            substr($angka, 15, 3);         // 001
                    return $hasil;
                })
                ->rawColumns(['action','nip_x'])
                ->make(true);
        }
        return view('admin.bast.bast-pengurusbarangs.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengurus' => 'required|string|max:255',
            'nip_pengurus' => 'required|string'
        ]);

        BastPengurusbarang::updateOrCreate(
            ['id' => $request->input('id')], // Check if ID exists to update, else create
            $request->only(['nama_pengurus', 'nip_pengurus'])
        );

        return response()->json(['success' => 'BastPengurusbarang saved successfully.']);
    }

    public function edit($id)
    {
        $bastPengurusbarang = BastPengurusbarang::find($id);
        return response()->json($bastPengurusbarang);
    }

    public function destroy($id)
    {
        BastPengurusbarang::find($id)->delete();
        return response()->json(['success' => 'BastPengurusbarang deleted successfully.']);
    }
}