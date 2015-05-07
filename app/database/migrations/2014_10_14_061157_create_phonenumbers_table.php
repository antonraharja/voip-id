<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePhonenumbersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		$this->down();
		
		Schema::create('phone_numbers', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('extension');
			$table->string('sip_password');
			$table->string('description');
			$table->timestamp('created_at');
			$table->timestamp('updated_at')->nullable();
			$table->timestamp('deleted_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('phone_numbers');
	}
}
