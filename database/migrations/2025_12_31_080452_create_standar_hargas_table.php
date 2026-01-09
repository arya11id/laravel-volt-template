<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandarHargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sipdri.standar_hargas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kelompok_barang')->nullable();
            $table->string('uraian_kelompok_barang')->nullable();
            $table->bigInteger('id_standar_harga')->nullable();
            $table->string('kode_barang')->nullable();
            $table->string('uraian_barang')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->string('satuan')->nullable();
            $table->integer('harga_satuan')->nullable();
            $table->string('kode_rekening')->nullable();
            $table->integer('id_tahun');
            $table->string('jenis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standar_hargas');
    }
}
