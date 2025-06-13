<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DetailLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('detail_layanan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->integer('jenis_layanan_id')->nullable();
            $table->integer('pemohon_id')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->string('url_file')->nullable();
            $table->text('keterangan')->nullable();
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
