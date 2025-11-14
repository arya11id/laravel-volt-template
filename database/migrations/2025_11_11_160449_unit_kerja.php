<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UnitKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bpopp.unit_kerja', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nama_unit_kerja')->nullable();
            $table->string('nip_ks')->nullable();
            $table->string('nama_ks')->nullable();
            $table->string('nip_bendahara')->nullable();
            $table->string('nama_bendahara')->nullable();
            $table->string('nama_unit_kerja')->nullable();
            $table->integer('jenis')->nullable()->comment('1 = SMA,2 = SMK, 3 = SLB');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->boolean('is_active')->nullable();
            $table->integer('no_urut')->nullable();
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
