<?php

namespace App\Http\Controllers\Admin\Sippol;
use App\Http\Controllers\Controller;

use App\Models\Sippol\SippolBpDuaDua;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SipdExport;
use App\Models\Sippol\SippolJenis;

class SippolBpDuaDuaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SippolBpDuaDua::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editSippolBpDuaDua">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteSippolBpDuaDua">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('sippol-bp-dua-duas.index');
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'id_periode' => 'required|integer',
        //     'id_unit_kerja' => 'required|integer',
        //     'jenis' => 'required|string',
        //     'nomor' => 'required|string',
        //     'tanggal' => 'required|string',
        //     'sekolah' => 'required|string',
        //     'kode' => 'required|string',
        //     'uraian' => 'required|string',
        //     'penerimaan' => 'required|integer',
        //     'pengeluaran' => 'required|integer',
        //     'id_sippol_jenis' => 'required|integer'
        // ]);
        $request->validate([
            'bp' => 'required|mimes:xlsx,xls'
        ]);

        // Membaca file tanpa menyimpannya
        $data = Excel::toArray([], $request->file('bp'));

        // Index [0] berarti sheet pertama
        $rows = $data[0];
        $startFromRow18 = array_slice($rows, 13);
        $no = 1;
        foreach ($startFromRow18 as $row) {
            // $cek = $row[3] != null ? $no++ : null;
            SippolBpDuaDua::create(
                [
                    'id_periode' => $request->input('id_periode'),
                    // 'id_unit_kerja' => $row[2],
                    'jenis' => $row[1],
                    'nomor' => $no++,
                    'tanggal' => $row[3],
                    'kode' => $row[5],
                    'sekolah' => strtoupper(substr($row[5], 0, strpos($row[5], '/'))),
                    'uraian' => $row[6],
                    'penerimaan' => $row[14],
                    'pengeluaran' => $row[15],
                    // 'id_sippol_jenis' => $row[11]
                ]
            );
        }
        // $sippolBpDuaDuas = SippolBpDuaDua::select('jenis', 'nomor')
        //     ->where('id_periode', $request->input('id_periode')) // Assuming id_periode is hardcoded to 1 for this example. You might need to make this dynamic.
        //     ->whereNull('tanggal')
        //     ->where('jenis', '!=', 'Jumlah Saat Ini')
        //     ->orderBy('nomor')
        //     ->get();
        $idPeriode = $request->input('id_periode');
        $sumber = SippolBpDuaDua::query()
            ->select('jenis', 'nomor')
            ->where('id_periode', $idPeriode)
            ->whereNull('tanggal')
            ->where('jenis', '!=', 'Jumlah Saat Ini')
            ->orderBy('nomor')
            ->get();
        // foreach ($sippolBpDuaDuas as $index => $item) {
        //     SippolJenis::create([
        //         'nama_jenis' => $item->jenis,
        //         'urutan' => $index + 1,
        //         'nomor' => $item->nomor,
        //         'mulai' => 0,
        //         'akhir' => 0,
        //         'is_bm' => 0,
        //         'id_periode' => $request->input('id_periode')
        //     ]);
        // }
        $dataInsert = $sumber->values()->map(function ($item, $index) use ($idPeriode) {
            return [
                'uuid'       => \Str::uuid(),
                'nama_jenis' => $item->jenis,
                'urutan'     => $index + 1,
                'nomor'      => $item->nomor,
                'mulai'      => 0,
                'akhir'      => 0,
                'is_bm'      => 0,
                'id_periode' => $idPeriode,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        SippolJenis::insert($dataInsert);

        // $SippolJenis = SippolJenis::where('id_periode', $request->input('id_periode'))
        //                 ->orderBy('urutan')
        //                 ->get();
        // $lastSippolJenis = SippolBpDuaDua::select('jenis', 'nomor')
        //     ->where('id_periode', $request->input('id_periode'))
        //     ->orderByDesc('nomor')
        //     ->first();
        $jenisList = SippolJenis::where('id_periode', $idPeriode)
                    ->orderBy('urutan')
                    ->get()
                    ->values();

        $lastNomorBp = SippolBpDuaDua::where('id_periode', $idPeriode)
                        ->max('nomor');

        // $SippolJenis2 = SippolJenis::where('id_periode', $request->input('id_periode'))
        //                 ->orderByDesc('urutan')
        //                 ->first();
        // foreach ($SippolJenis as $item) {
        //     $dax = SippolJenis::find($item->id);
        //     if ($dax) {
        //         if($dax->urutan == 1){
        //             $dax->update(['mulai' => 2]);
        //             $dax2 = SippolJenis::where('urutan', 2)
        //                     ->where('id_periode', $request->input('id_periode'))
        //                     ->first();
        //             $dax->update(['akhir' => $dax2->nomor - 1]);
        //         } else if ($dax->urutan == $SippolJenis2->urutan){
        //             $dax->update(['mulai' => $dax->nomor+1]);
        //             $dax->update(['akhir' => $lastSippolJenis->nomor]);
        //         } else {
        //             $dax->update(['mulai' => $dax->nomor+1]);
        //             $dax2 = SippolJenis::where('urutan', $dax->urutan + 1)
        //                     ->where('id_periode', $request->input('id_periode'))
        //                     ->first();
        //             $dax->update(['akhir' => $dax2->nomor - 1]);
        //         }
        //     }
        // }
        foreach ($jenisList as $i => $jenis) {

            if ($i === 0) {
                $mulai = 2;
                $akhir = $jenisList[$i + 1]->nomor - 1;
            }
            elseif ($i === $jenisList->count() - 1) {
                $mulai = $jenis->nomor + 1;
                $akhir = $lastNomorBp;
            }
            else {
                if($jenis->nomor != 0 or $jenis->nomor != null){
                    $mulai = $jenis->nomor + 1;
                    $akhir = $jenisList[$i + 1]->nomor - 1;
                }
            }

            $updates[] = [
                'id'     => $jenis->id,
                'mulai'  => $mulai,
                'akhir'  => $akhir,
            ];
        }
        foreach ($updates as $row) {
            SippolJenis::where('id', $row['id'])
                ->update([
                    'mulai' => $row['mulai'],
                    'akhir' => $row['akhir'],
                ]);
        }

        // $updatejenis = SippolBpDuaDua::select('jenis', 'nomor')
        //                 ->where('id_periode', $request->input('id_periode'))
        //                 ->orderByDesc('nomor')
        //                 ->get();
        // foreach ($updatejenis as $item) {
        //     $cari = SippolBpDuaDua::find($item->id);
        //     if ($cari) {
        //         $SippolJenis2 = SippolJenis::where('id_periode', $request->input('id_periode'))
        //                         ->where('mulai', '>=', $cari->nomor)
        //                         ->where('akhir', '<=', $cari->nomor)
        //                         ->first();
        //         if ($SippolJenis2) {
        //             $cari->update(['id_sippol_jenis' => $SippolJenis2->id]);
        //         }
        //     }
        // } 
        $jenisRange = SippolJenis::where('id_periode', $idPeriode)->get();

        SippolBpDuaDua::where('id_periode', $idPeriode)
            ->orderByDesc('nomor')
            ->chunk(500, function ($bps) use ($jenisRange) {

                foreach ($bps as $bp) {
                    $jenis = $jenisRange->first(function ($j) use ($bp) {
                        return $bp->nomor >= $j->mulai && $bp->nomor <= $j->akhir;
                    });

                    if ($jenis) {
                        $bp->update([
                            'id_sippol_jenis' => $jenis->id
                        ]);
                    }
                }
            }); 
        return response()->json(['success' => 'SippolBpDuaDua saved successfully.']);
    }

    public function edit($id)
    {
        $sippolBpDuaDua = SippolBpDuaDua::find($id);
        return response()->json($sippolBpDuaDua);
    }

    public function destroy($id)
    {
        SippolBpDuaDua::find($id)->delete();
        return response()->json(['success' => 'SippolBpDuaDua deleted successfully.']);
    }
    public function bersih(Request $request)
    {
        SippolBpDuaDua::where('id_periode', $request->id_periode)->delete();
        SippolJenis::where('id_periode', $request->id_periode)->delete();
        return response()->json(['success' => 'SippolBpDuaDua deleted successfully.']);
    }
}