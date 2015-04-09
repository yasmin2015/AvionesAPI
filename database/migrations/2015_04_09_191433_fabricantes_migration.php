<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FabricantesMigration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fabricantes', function(Blueprint $table)
		{
			//indicamos los campos de la tabla en MySQL
			$table->increments('id');
			$table->string('nombre');
			$table->string('direccion');
			$table->string('telefono');
			//automaticamente añadira created_at y updates_at 
			//al activar la opcion timestamps
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fabricantes');
	}

}
