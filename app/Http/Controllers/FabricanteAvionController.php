<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Fabricante;
use App\Avion;
use Response;

class FabricanteAvionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idFabricante)//le ponemos un parametro
	{
		//mostramos todos los aviones de un fabricante
		//comprobamos si ese fabricante existe
		$fabricante=Fabricante::find($idFabricante);
		if (!$fabricante)
		{
		return response()->json(['errors' => array(['code' => 404, "messagge" => "No se encuentra el fabricante"])], 404);
		}
		return response()->json(['status'=>'ok','data'=>$fabricante->aviones()->get()],200);
		//otra forma
		//return response()->json(['status'=>'ok','data'=>$fabricante->aviones],200);
	}
	

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	
	public function store($idFabricante,Request $resquest)
	{
		//damos de alta un avion de un fabricante
		//comprobamos q recibimos todos los datos de avion
		if(!$request->input('modelo')||!$request->input('longitud')||!$request->input('capacidad')||!$request->input('velocidad')||!$request->input('alcance'))
			
	{
	//error 422 no se pde procesar
	return response ()->json(['errors' => array(['code' => 422, "messagge" => "Faltan datos"])], 422);
}
//compruebo si existe el fabricante

$fabricante=Fabricante::find($idFabricante);

if(!$fabricante)
{
 return	response ()->json(['errors' => array(['code' => 404, "messagge" => "No se encuentra fabricante"])], 404);
 
}
//damos de alta el avion de ese fabricante
//devolvemos un json con los datos
$nuevoAvion=$fabricante->aviones()->create ($request->all());
//devolvemos un json con los datos,codigo 201 created y location del nuevo recurso creado
$respuesta=Response::make(json_encode(['data' => $nuevoFabricante]), 201)->header('Location', 'http://www.dominio.local/aviones/' . $nuevoAvion->serie)->header('Content-Type', 'application/json');
			return $respuesta;
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	
	//cuando se hagan peticiones de patch o put
	//detectamos si estamos x put o patch
	public function update($idFabricante,$idAvion,Request $request)
			//Request $request->inyeccion de dependencias como Singletone,patron active record.....
	{
		//comprobamos si el fabricante existe
		$fabricante = Fabricante::find($idFabricante);
		
		if(!$fabricante)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante asociado a ese codigo.'])],404);
			
		}
		//comprobamos si el avion q buscamos pertenece de ese fabricante
		$avion = $fabricante->aviones()->find($idAvion);
		 
		if(!$avion)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un avion asociado a ese fabricante.'])],404);
			
		}//si llegamos aqui es q ha ido todo bien
		
		//ahora almacenamos todos los datos en una variable
		//Lista de los campos recibidos del formulario de actualizacion
		$modelo=$request->input('modelo');
		$longitud=$request->input('longitud');
		$capacidad=$request->input('capacidad');
		$velocidad=$request->input('velocidad');
		$alcance=$request->input('alcance');
		
		//comprobamos si el metodo es patch o put
		//si es patch es parcial y es put total
		if ($request->method()==='PATCH')//ACTUALIZACION PARCIAL
		{
			$bandera=false;
			//comprobamos campo a campo si hemos recibido datos
			if($modelo !=null && $modelo!='')
			{//SI CUANDO QUIERO Q ME ACTUALICE TENGO Q PONER DATOS TENGO Q DEJAR EL FINAL ASI
			
				//actualizamos este campo en el modelo avion
				$avion->modelo=$modelo;
				$bandera=true;
			}
			if($longitud !=null && $longitud!='')
			{
				//actualizamos este campo en el modelo avion
				$avion->modelo=$longitud;
				$bandera=true;
			}
			if($velocidad !=null && $velocidad !='')
			{
				//actualizamos este campo en el modelo avion
				$avion->modelo=$velocidad ;
				$bandera=true;
			}
			if($capacidad !=null && $capacidad!='')
			{
				//actualizamos este campo en el modelo avion
				$avion->modelo=$capacidad;
				$bandera=true;
			}
			if($alcance !=null && $alcance!='')
			{
				//actualizamos este campo en el modelo avion
				$avion->modelo=$alcance;
				$bandera=true;
			}
			//ahora se comprueba la bandera
			if($bandera)
			{
				//almacenamos los cambios del modelo en la tabla
				$avion->save();
				return response()->json(['status'=>'ok', 'data'=>$avion],200);
			}
			else
			{
				//codigo 304 no modified
				return response()->json(['errors' => array(['code' => 304, "messagge" => "No se ha modificado ningun dato de avion"])], 304);
			}
		}
		//metodo put // ACTUALIZACION TOTAL
		if(!$modelo || !$longitud || !$capacidad || !$velocidad || !$alcance)
		{//AQUI PUEDE SER UN VACIO O TEXTO SINO HAY Q PONERLO COMO ARRIBA SI QREMOS Q CONTENGA DATOS
			//codigo 422 , no se pde procesar pq faltan datos
			return response()->json(['errors' => array(['code' => 422, "messagge" => "Faltan valores para completar el procesamiento"])], 422);
		}
		
		
		$avion->modelo=$modelo;
		$avion->longitud=$longitud;
		$avion->capacidad=$capacidad;
		$avion->alcance=$alcance;
		$avion->velocidad=$velocidad;
		//grabamos los datos del modelo en la tabla
		$avion->save();
		
		return response()->json(['status'=>'ok','data'=>200]);
			
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idFabricante,$idAvion)
	{
		// Compruebo si existe el fabricante.
		$fabricante=Fabricante::find($idFabricante);

		if (! $fabricante)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);
		}

		// Compruebo si existe el avion.
		$avion=$fabricante->aviones()->find($idAvion);

		if (! $avion)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un avión asociado a ese fabricante.'])],404);
		}

		// Borramos el avión.
		$avion->delete();

		// Devolvemos código 204 No Content.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado el avión correctamente.'],204);
	}
}