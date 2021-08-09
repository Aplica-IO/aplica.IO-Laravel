<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProntoPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pronto_pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('invoice_id');
            $table->boolean('is_applied')->default(false);
            $table->double('amount', '9', '2');
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')
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
        Schema::dropIfExists('pronto_pagos');
    }
}
