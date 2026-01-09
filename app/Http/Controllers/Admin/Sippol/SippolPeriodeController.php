<?php

namespace App\Http\Controllers\Admin\Sippol;
use App\Http\Controllers\Controller;

use App\Models\Sippol\SippolPeriode;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SippolPeriodeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SippolPeriode::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('sippol-unit-kerjas.show', $row->id).'" class="edit btn btn-primary btn-sm">detail</a>';
                    $btn = $btn.'<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editSippolPeriode">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteSippolPeriode">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.sippol.periode.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string',
            'tgl' => 'required|date'
        ]);

        SippolPeriode::updateOrCreate(
            ['id' => $request->input('id')], // Check if ID exists to update, else create
            $request->only(['nama_periode', 'tgl'])
        );

        return response()->json(['success' => 'SippolPeriode saved successfully.']);
    }

    public function edit($id)
    {
        $sippolPeriode = SippolPeriode::find($id);
        return response()->json($sippolPeriode);
    }

    public function destroy($id)
    {
        SippolPeriode::find($id)->delete();
        return response()->json(['success' => 'SippolPeriode deleted successfully.']);
    }
    public function detail($id)
    {
        $sippolPeriode = SippolPeriode::whereUuid($id)->first();
        return view('admin.sippol.periode.detail', compact('sippolPeriode'));
    }
}