<?php

namespace App\Http\Controllers\Admin\Sippol;
use App\Http\Controllers\Controller;

use App\Models\Sippol\SippolUnitKerja;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Bast\BastUnitKerja;
use App\Models\Sippol\SippolPeriode;

class SippolUnitKerjaController extends Controller
{
    public function data(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = SippolUnitKerja::with('bastUnitKerja')->where('id_periode', $id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editSippolUnitKerja">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteSippolUnitKerja">Delete</a>';
                    return $btn;
                })
                ->addColumn('jml_gu', function($row){
                    return 'Rp '.number_format($row->jml_gu, 0, ',', '.');
                })
                ->addColumn('jml_sts', function($row){
                    return 'Rp '.number_format($row->jml_sts, 0, ',', '.');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.sippol.unit-kerjas.index', compact('id'));
    }
    public function show($id)
    {
        $SippolPeriode = SippolPeriode::find($id);
        $BastUnitKerja = BastUnitKerja::orderBy('no_urut','ASC')->get();
        $SippolUnitKerja = SippolUnitKerja::with('bastUnitKerja')->where('id_periode', $id)->get();
        return view('admin.sippol.unit-kerjas.index', compact('id', 'BastUnitKerja','SippolPeriode','SippolUnitKerja'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'id_bast_unit_kerja' => 'required|integer',
        //     'jml_gu' => 'required|integer',
        //     'jml_sts' => 'required|integer',
        //     'id_periode' => 'required|integer',
        //     'kode' => 'required|string'
        // ]);
        foreach ( $request->id_bast_unit_kerja as $key => $value ) {
            $data = [
                'id_bast_unit_kerja' => $value,
                'jml_gu' => $request->jml_gu[$key],
                'jml_sts' => $request->jml_sts[$key],
                'id_periode' => $request->id_periode[$key],
                'kode' => $request->kode[$key],
            ];
            SippolUnitKerja::updateOrCreate(
                ['id_bast_unit_kerja' => $value,
            'id_periode' => $request->id_periode], // Check if ID exists to update, else create
                $data
            );
        }
        // SippolUnitKerja::updateOrCreate(
        //     ['id' => $request->input('id'),
        // 'id_periode' => $request->input('id_periode')], // Check if ID exists to update, else create
        //     $request->only(['id_bast_unit_kerja', 'jml_gu', 'jml_sts', 'id_periode', 'kode'])
        // );

        return response()->json(['success' => 'SippolUnitKerja saved successfully.']);
    }

    public function edit($id)
    {
        $sippolUnitKerja = SippolUnitKerja::with('bastUnitKerja')->find($id);
        return response()->json($sippolUnitKerja);
    }

    public function destroy($id)
    {
        SippolUnitKerja::find($id)->delete();
        return response()->json(['success' => 'SippolUnitKerja deleted successfully.']);
    }
}