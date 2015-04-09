<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Avion extends Model {

	//Nombre de la tabla MySQL
	protected $table='aviones';
	
	//Clave primaria de la tabla Aviones
	//en este caso es el campo select por lo tanto hay q indicarlo
	//y eso se hace con
	protected $primaryKey='serie';
	//si no se indica pordefecto seria un campo llamado id
	
	//campos de la tabla q se pden asignar masivamente
	protected $fillable=array('modelo','logintud','capacidad','velocidad','alcance');
	
	//campos q no qremos q se devuelvan en las consutas
	protected $hidden=['created_at','updated_at'];
	
	//definimos la relacion d Aviones con Fabricante
	public function fabricante()
	{
		//1 avion pertenece a 1 fabricante
		return $this->belongsTo('App/Fabricante');
	}
	
}
