<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('charges', function (Blueprint $table) {
			$table->bigIncrements('id')->unsigned();
			$table->unsignedBigInteger('invoice_id');
			$table->bigInteger('bcv')->nullable();
			$table->string('name', 100);
			$table->BigInteger('amount');			
			$table->integer('propertyId')->nullable();
			$table->string('reason')->nullable();
			$table->date('spend_date');
			$table->unsignedBigInteger('type');

			$table->foreign('invoice_id')->references('id')
				->on('invoices')->onDelete('cascade');
			$table->foreign('type')->references('id')
				->on('charges_types')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('charges');
	}
}
