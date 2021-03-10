<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResidencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('nif');
            $table->float('reserve')->default(0.00);
            $table->float('reserve_percentage')->default(0);
            $table->date('expiration_date')->default(today()->addMonth());
            $table->boolean('expired')->default(false);
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('auditor_id');
            $table->unsignedBigInteger('community_type');
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses')
                ->onDelete('cascade');
            $table->foreign('community_type')->references('id')->on('residences_type')
                ->onDelete('cascade');
            $table->foreign('auditor_id')->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residences');
    }
}
