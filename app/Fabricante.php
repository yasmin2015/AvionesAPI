<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model {

	//Definir la tabla MySQL que usará este modelo
	protected $table="fabricantes";//sobreescribimos
	
	//atributos de la tabla q se pden rellenar de forma masiva
	protected $fillable=array('nombre','direccion','telefono');
	
	//ocultamos los campos de timestamps en las consultas
	protected $hidden=['created_at','updated_at'];
    //estos son los campos q crea automaticamente laravel cada vez q yo creo un modelo
	
	//relacion de fabricante con aviones
	public function aviones()
    {
		//la relacion seria un fabricante fabrica muchos aviones
		return $this->hasMany('App\Avion');
		//1 objeto de la clase fabricante pde tener muxos objetos de la clase avion
		
	}
}
