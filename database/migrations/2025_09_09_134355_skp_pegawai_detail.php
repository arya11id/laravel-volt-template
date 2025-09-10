<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SkpPegawaiDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('skp_pegawai_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nip')->nullable();
            $table->integer('skp_pegawai_id')->nullable();
            $table->integer('jenis')->nullable();
            $table->string('status_verifikasi')->nullable();
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
