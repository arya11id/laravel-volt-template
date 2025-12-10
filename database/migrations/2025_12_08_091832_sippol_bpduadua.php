<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SippolBpduadua extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('bpopp.sippol_bast_bpduadua', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->integer('id_periode')->nullable();
            $table->integer('id_unit_kerja')->nullable();
            $table->string('jenis')->nullable();
            $table->string('nomor')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('sekolah')->nullable();
            $table->string('kode')->nullable();
            $table->text('uraian')->nullable();
            $table->integer('penerimaan')->nullable();
            $table->integer('pengeluaran')->nullable();
            $table->integer('id_sippol_jenis')->nullable();
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
