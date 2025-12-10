<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SippolSts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bpopp.sippol_unit_kerja', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->integer('id_bast_unit_kerja')->nullable();
            $table->integer('jml_gu')->nullable();
            $table->integer('jml_sts')->nullable();
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
