<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTglToBrgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bpopp.bast_trs_bast_barang', function (Blueprint $table) {
            //
            $table->date('tgl_datang_barang')->nullable();
            $table->date('tgl_selesai_nego')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bast_trs_bast_barang', function (Blueprint $table) {
            //
        });
    }
}
