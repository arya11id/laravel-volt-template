<?php

namespace App\Imports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class pegawaiImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        DB::beginTransaction();

        try {
            Pegawai::updateOrCreate(
            // The unique condition (i.e., check if a user with this email exists)
            [
                'nip' => $row['nip']
            ],
            // The data to update or insert
            [
                'nip'       => trim($row['nip']),
                'nama'        => $row['nama'],
                'unit_kerja' => $row['unit_kerja'],
                'uuid'       => Str::uuid(),
                'created_by' => auth()->id(),
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
