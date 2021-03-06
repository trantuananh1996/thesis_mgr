<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::create('roles', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('code')->unique();
			$table->string('name');
			$table->text('description');
			$table->integer('created_user_id');
			$table->integer('modified_user_id')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		Schema::dropIfExists('roles');
	}
}
