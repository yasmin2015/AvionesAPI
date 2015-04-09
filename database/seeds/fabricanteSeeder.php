<?php

use Illuminate\Database\Seeder;

//hace uso del modelo fabricante
use App\Fabricante;

//usamos el faker q instalamos antes
use Faker\Factory as Faker;//pongo un alias en vez del metodo estatico

class fabricanteSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//creamos una instancia de faker
		$faker=Faker::create();
		
		//vamos a cubrir 5 fabricantes
		for($i=0; $i<5; $i++)
		{
			//cuando llamamos al m,etodo create de modelo fabricante
			//se esta creando una nueva fila en la ytabla fabricante
			Fabricante::create(
					['nombre'=>$faker->word(),
					 'direccion'=>$faker->word(),
					 'telefono'=>$faker->randomNumber()
						]
					);
		}
	}

}
