<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('properties', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('reference');
			$table->float('alicuota');
			$table->float('balance')->default(0);
			$table->boolean('is_active')->default(true);
			$table->unsignedBigInteger('residence_id');
			$table->unsignedBigInteger('user_id');
			$table->timestamps();

			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade');

			$table->foreign('residence_id')
				->references('id')->on('residences')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('properties');
	}
}
