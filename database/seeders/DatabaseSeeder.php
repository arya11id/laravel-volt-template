<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'client']);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => Carbon::now()
        ]);

        $admin->assignRole('admin');
        DB::table('detail_layanan')->insert([
            [
                'id' => 1,
                'uuid' => '61e24e3e-8be5-4d32-a8ae-9311ce18bbed',
                'jenis_layanan_id' => 4,
                'pemohon_id' => 1,
                'tgl_pengajuan' => '2025-06-05',
                'tgl_selesai' => null,
                'url_file' => null,
                'keterangan' => 'pensiun dini',
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null,
                'created_at' => '2025-06-05 04:34:25',
                'updated_at' => '2025-06-05 04:34:25',
            ]
        ]);

        DB::statement('SELECT setval(\'detail_layanan_id_seq\', (SELECT MAX(id) FROM detail_layanan), true)');
        DB::table('jenis_layanan')->insert([
            [
                'id' => 1,
                'uuid' => 'b2d1376b-0614-4b62-b995-1fa810e55a61',
                'nama' => 'pensiun',
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => '2025-06-05 02:33:25', // Ensure this timestamp is correct as per your SQL dump
                'created_at' => '2025-06-05 02:30:46',
                'updated_at' => '2025-06-05 02:33:25',
            ],
            [
                'id' => 3,
                'uuid' => '16deb7b5-ffc8-41a0-86a7-234e39234910',
                'nama' => 'kenaikan pangkat',
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null,
                'created_at' => '2025-06-05 02:33:22',
                'updated_at' => '2025-06-05 02:33:22',
            ],
            [
                'id' => 4,
                'uuid' => '2ce45ec8-02f5-4a45-b3b0-27419d7b0a37',
                'nama' => 'pensiun',
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null,
                'created_at' => '2025-06-05 04:34:00',
                'updated_at' => '2025-06-05 04:34:00',
            ]
        ]);

        DB::statement('SELECT setval(\'jenis_layanan_id_seq\', (SELECT MAX(id) FROM jenis_layanan), true)');
        DB::table('pemohon')->insert([
            [
                'id' => 1,
                'uuid' => 'ae8c321d-5c0b-4b91-adf3-5abe452476e4',
                'nip' => 1234,
                'no_hp' => 12444,
                'nama' => 'aziz',
                'tgl_lahir' => '2025-06-05',
                'asal_instansi' => 'sman 2 kediri',
                'alamat' => '12344',
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'deleted_at' => null,
                'created_at' => '2025-06-05 02:08:58',
                'updated_at' => '2025-06-05 02:08:58',
            ]
        ]);

        DB::statement('SELECT setval(\'pemohon_id_seq\', (SELECT MAX(id) FROM pemohon), true)');
        DB::table('riwayat_layanan')->insert([
            ['id' => 1, 'uuid' => '137eb930-1c98-4dfc-b925-81923e0ca4a5', 'detail_layanan_id' => NULL, 'tgl_layanan' => '2025-06-10 00:00:00', 'url_file' => NULL, 'keterangan' => 'proses', 'status_id' => 2, 'created_by' => 1, 'updated_by' => NULL, 'deleted_by' => NULL, 'deleted_at' => NULL, 'created_at' => '2025-06-10 14:54:14', 'updated_at' => '2025-06-10 14:54:14'],
            ['id' => 2, 'uuid' => '63d8ff5b-9914-4ce0-afe1-f5816517d152', 'detail_layanan_id' => NULL, 'tgl_layanan' => '2025-06-10 00:00:00', 'url_file' => NULL, 'keterangan' => 'proses', 'status_id' => 2, 'created_by' => 1, 'updated_by' => NULL, 'deleted_by' => NULL, 'deleted_at' => NULL, 'created_at' => '2025-06-10 14:54:14', 'updated_at' => '2025-06-10 14:54:14'],
            ['id' => 3, 'uuid' => '3c0d7c2b-75d8-46ea-9ef9-66a4a50d04f5', 'detail_layanan_id' => NULL, 'tgl_layanan' => '2025-06-10 00:00:00', 'url_file' => NULL, 'keterangan' => 'fafaf', 'status_id' => 1, 'created_by' => 1, 'updated_by' => NULL, 'deleted_by' => NULL, 'deleted_at' => NULL, 'created_at' => '2025-06-10 14:54:43', 'updated_at' => '2025-06-10 14:54:43'],
            ['id' => 4, 'uuid' => 'ec4d47cd-ce7f-4417-af4a-cc7432be5959', 'detail_layanan_id' => 1, 'tgl_layanan' => '2025-06-07 00:00:00', 'url_file' => 'https://www.youtube.com/@bkdjatimofficial/streams', 'keterangan' => 'proses s', 'status_id' => 1, 'created_by' => 1, 'updated_by' => 1, 'deleted_by' => 1, 'deleted_at' => '2025-06-10 15:21:04', 'created_at' => '2025-06-10 15:00:51', 'updated_at' => '2025-06-10 15:21:04'],
            ['id' => 5, 'uuid' => 'e3ba0ac1-b09f-4302-b165-c4c1fe83ff91', 'detail_layanan_id' => 1, 'tgl_layanan' => '2025-06-10 00:00:00', 'url_file' => 'https://www.youtube.com/@bkdjatimofficial/streams', 'keterangan' => 'ok', 'status_id' => 3, 'created_by' => 1, 'updated_by' => NULL, 'deleted_by' => NULL, 'deleted_at' => NULL, 'created_at' => '2025-06-10 15:01:47', 'updated_at' => '2025-06-10 15:01:47'],
            ['id' => 6, 'uuid' => '64a8d964-6f90-4a4d-8eb6-73c6d37a2ebd', 'detail_layanan_id' => 1, 'tgl_layanan' => '2025-06-11 00:00:00', 'url_file' => 'https://www.youtube.com/@bkdjatimofficial/streams', 'keterangan' => 'selesai', 'status_id' => 4, 'created_by' => 1, 'updated_by' => NULL, 'deleted_by' => NULL, 'deleted_at' => NULL, 'created_at' => '2025-06-10 15:22:03', 'updated_at' => '2025-06-10 15:22:03']
        ]);

        DB::statement('SELECT setval(\'riwayat_layanan_id_seq\', (SELECT MAX(id) FROM riwayat_layanan), true)');
        DB::table('status')->insert([
            ['id' => 1, 'uuid' => '63569b81-7018-4e61-9923-69955f3da6f4', 'nama' => 'proses', 'created_by' => 1, 'updated_by' => NULL, 'deleted_by' => NULL, 'deleted_at' => NULL, 'created_at' => '2025-06-05 04:57:57', 'updated_at' => '2025-06-05 04:57:57'],
            ['id' => 2, 'uuid' => 'f833dedf-7d26-4c17-9d71-cd6b9b5b1e75', 'nama' => 'proses dinas', 'created_by' => 1, 'updated_by' => NULL, 'deleted_by' => NULL, 'deleted_at' => NULL, 'created_at' => '2025-06-05 04:58:18', 'updated_at' => '2025-06-05 04:58:18'],
            ['id' => 3, 'uuid' => 'ae08401b-94ca-4ec4-9339-3ab5da7dd9e6', 'nama' => 'proses bkd', 'created_by' => 1, 'updated_by' => NULL, 'deleted_by' => NULL, 'deleted_at' => NULL, 'created_at' => '2025-06-05 04:58:25', 'updated_at' => '2025-06-05 04:58:25'],
            ['id' => 4, 'uuid' => '3247cd84-5aa9-4068-8b48-781e6c321dc2', 'nama' => 'selesai', 'created_by' => 1, 'updated_by' => NULL, 'deleted_by' => NULL, 'deleted_at' => NULL, 'created_at' => '2025-06-05 04:58:30', 'updated_at' => '2025-06-10 15:19:43']
        ]);

        DB::statement('SELECT setval(\'status_id_seq\', (SELECT MAX(id) FROM status), true)');
    }
}
