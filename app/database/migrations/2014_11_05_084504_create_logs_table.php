<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('logs', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('event_name',50);
            $table->string('custom_parameter');
            $table->string('verbose_level',1);
            $table->string('ip_address',50);
            $table->string('request_uri');
            $table->integer('flag')->unsigned()->nullable();
			$table->timestamps('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('logs');
	}

}
