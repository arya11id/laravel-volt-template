<?php

namespace App\Http\Controllers\Admin\Sipd;

use App\Http\Controllers\Controller;

use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TahunController extends Controller
{
    public function index()
    {
        return view('admin.sipd.tahun.index');
    }

    public function data(Request $request)
    {
        $data = Tahun::get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                <a href="'.route('sipd.dpa.index',$row->id_tahun).'" class="btn btn-sm btn-warning btn-eye" data-id="' . $row->id_tahun . '">detail</a>
                <button class="btn btn-sm btn-info btn-edit" data-id="' . $row->id_tahun . '">Edit</button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id_tahun . '">Hapus</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}