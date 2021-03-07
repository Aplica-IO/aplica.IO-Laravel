<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref_code');
            $table->bigInteger('total')->default(0);
            
            //$table->boolean('prontopago')->default(false);
            $table->date('date');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('residence_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('currency');
            $table->timestamps();


            $table->foreign('currency')->references('id')
                ->on('currencies')->onDelete('cascade');
            $table->foreign('residence_id')->references('id')
                ->on('residences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
