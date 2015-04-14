<?php

use Illuminate\Database\Seeder;

use App\Avion;//hace uso del modelo de avion

//hace uso del modelo fabricante
use App\Fabricante;
//hace uso del modelo fabricante para averiguar cuantos fabricanted
//utiliza el faker
use Faker\Factory as Faker;

class avionSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//creamos una instancia de faker
		$faker= Faker::create();
		//necesitamos saber cuantos fabricantes tenemos
		$cuantos= Fabricante ::all()->count();
		
		//creamos un bucle para cubir 20 aviones
		for ($i=0; $i<19; $i++)
		{
			Avion::create(
					[
						'modelo'=>$faker->word(),
						'longitud'=>$faker->randomFloat(),
						'capacidad'=>$faker->randomNumber(),
						'velocidad'=>$faker->randomNumber(),
						'alcance'=>$faker->randomNumber(),
						'fabricante_id'=>$faker->numberBetween(1,$cuantos),
						//un numero al azar entre esas dos tablas
						
					]);
		}
	}

}
