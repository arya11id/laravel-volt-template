<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpToTrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bpopp.bast_transaksi', function (Blueprint $table) {
            //
            $table->string('surat_pesanan_file')->nullable();
            $table->string('surat_pesanan_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bpopp.bast_transaksi', function (Blueprint $table) {
            //
        });
    }
}
