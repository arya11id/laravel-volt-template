<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LayananSuratDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('detail_layanan_surat', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->integer('layanan_surat_id')->nullable();
            $table->datetime('tgl_layanan')->nullable();
            $table->string('url_file')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('status_id')->nullable(); // 0: pending, 1: approved, 2: rejected
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
