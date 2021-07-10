<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChargeIdToProntoPagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pronto_pagos', function (Blueprint $table) {
            $table->unsignedBigInteger('charge_id');
            $table->foreign('charge_id')->references('id')->on('charges')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pronto_pagos', function (Blueprint $table) {
            //
        });
    }
}
