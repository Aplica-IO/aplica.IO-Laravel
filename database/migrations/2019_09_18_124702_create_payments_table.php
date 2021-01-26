<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('payments', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->float('amount_payed');
			$table->bigInteger('bcv')->nullable();
			$table->unsignedBigInteger('bank');
			$table->unsignedBigInteger('id_method');
			$table->unsignedBigInteger('status');
			$table->unsignedBigInteger('property_id');
			$table->unsignedBigInteger('currency_id');
			$table->string('transaction_ref', 200);

			$table->foreign('id_method')->references('id')->on('payment_methods')
			->onDelete('cascade');

			$table->foreign('currency_id')->references('id')->on('currencies')
			->onDelete('cascade');
			
			$table->foreign('property_id')->references('id')
			->on('properties')->onDelete('cascade');

			$table->foreign('status')->references('id')
			->on('status')->onDelete('cascade');

			$table->foreign('bank')->references('id')->on('banks')
			->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('payments');
	}
}
