<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateDomainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		$this->down();
		
		Schema::create('domains', function (Blueprint $table) {
			$table->string('id', 255);
			$table->primary('id');
			$table->integer('user_id');
			$table->string('domain', 50);
			$table->string('sip_server', 50);
			$table->integer('prefix');
			$table->string('description', 255);
			$table->string('title', 15);
			$table->text('homepage');
			$table->string('theme', 20);
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
			$table->timestamp('deleted_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('domains');
	}
}
