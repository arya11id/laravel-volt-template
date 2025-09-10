<?php

namespace App\Imports;

use App\Models\SkpPegawaiDetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class KinerjaImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $jenis;
    protected $id;

    public function __construct($jenis, $id)
    {
        $this->jenis = $jenis;
        $this->id = $id;
    }
    public function model(array $row)
    {
        DB::beginTransaction();

        try {
            SkpPegawaiDetail::updateOrCreate(
            // The unique condition (i.e., check if a user with this email exists)
            [
                'nip' => $row['NIP BARU']
            ],
            // The data to update or insert
            [
                'nip'       => trim($row['NIP BARU']),
                'status_verifikasi' => $row['STATUS VERIFIKASI'],
                'uuid'       => Str::uuid(),
                'created_by' => auth()->id(),
                'jenis' => $this->jenis,
                'skp_pegawai_id' => $this->id,
                // You can add more fields to insert or update here
            ]
        );
        DB::commit();
        } catch (Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
            // You can log or handle the exception as needed
            throw $e;
        }
    }
}
