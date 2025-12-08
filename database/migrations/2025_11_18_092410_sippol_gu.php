<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SippolGu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bpopp.sippol_gu', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->integer('id_trs_bast')->nullable();
            $table->string('jenis')->nullable();
            $table->string('uraian')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('id_satuan')->nullable();
            $table->integer('harga_satuan')->nullable();
            $table->string('barang_file_name_a')->nullable();
            $table->string('barang_file_path_a')->nullable();

            $table->string('barang_file_name_b')->nullable();
            $table->string('barang_file_path_b')->nullable();

            $table->string('barang_file_name_c')->nullable();
            $table->string('barang_file_path_c')->nullable();

            $table->string('barang_file_name_d')->nullable();
            $table->string('barang_file_path_d')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            
            $table->softDeletes();
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
        //
    }
}
