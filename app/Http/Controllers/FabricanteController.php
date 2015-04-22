<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//cargamos Fabricante
use App\Fabricante;
use Response;
use Iluminate\Support\Facades\Cache;
//aqui creamos todas las rutas del controladorç
//entonces aqui le decimos q antes de entrar en las rutas le decimos q ejecute el middleware
//entonces le decimos q qro ejecutar ese
//aqui le indico q antes d acceder a esos metodos me diga si el usuario esta autentificado
class FabricanteController extends Controller {
//constructor
	public function __construct() 
	{
		$this->middleware('auth.basic',['only'=>['store','update','destroy']]);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 *///
	public function index() {
		//return "En el index de Fabricante";
		//devolvemos un JSON con todos los fabricantes
		//return Fabricante::all();
		//la cache se actualizara con los nuevos datos cada 15 seg
		//cachefabricantes es la clave con la q se almacenaran
		//los registros obtenidos de Fabricante::all()
		$fabricantes=Cache::remember('fabricantes',15/60,function()
		{
			return Fabricante::all();
		});
		
	
		//hacemos uso del modelo Fabricante pero hay q cargarlo arriba
	
		//para devolver un JSON con codigo de respuesta http
		//return response()->json(['status' => 'ok', 'data' => Fabricante::all()], 200);
		//codigo http q se manda al cliente
		
		//devolvemos el json usando cache
		return response()->json(['status' => 'ok', 'data' => $fabricantes::all()], 200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	/*
	  //no se utiliza pq se usaria para mostrar un formulario de creacion d Fabricantes
	  //y una api rest no hace eso
	  public function create()
	  {
	  //
	  }

	  /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 *//*
	  public function store(Request $request)
	  {
	  //metodo llamado al hacer un POST (insercion en la tabla)
	  //comprobamos q recibimos todos los campos (datos d la tabla)
	  //para comprobar un campo en particular pongo input y el nombre del campo
	  if(!$request->input('nombre')|| !$request->input('direccion') || !$request->input('telefono'))
	  {
	  return response()->json(['errors'=>array(['code'=>422,'message'=>"Faltan datos"])],422);
	  //insertamos datos
	  $nuevoFabricante=Fabricante::create($request->all());

	  //devolvemos la respuesta http 201 (created)
	  //+ los datos del nuevo fabricante
	  //+ una cabecera de location+ cabecera JSON
	  $respuesta= Response::make(json_encode(['data'=>$nuevoFabricante]),201)->header('Location','http://www.dominio.local/fabricantes/'.$nuevoFabricante->id)->header('Content-Type','application/json');

	  return $respuesta;
	  }
	  //NO VA!!!!!!!!!!!!!!!

	 * 
	 */

	public function store(Request $request) {
		//
		// Método llamado al hacer un POST.
		// Comprobamos que recibimos todos los campos.
		if (!$request->input('nombre') || !$request->input('direccion') || !$request->input('telefono')) 
		{
			// NO estamos recibiendo los campos necesarios. Devolvemos error.
			return response()->json(['errors' => array(['code' => 422, 'message' => 'Faltan datos necesarios para procesar el alta.'])], 422);

		}
				
					// Insertamos los datos recibidos en la tabla.
			$nuevoFabricante = Fabricante::create($request->all());

			// Devolvemos la respuesta Http 201 (Created) + los datos del nuevo fabricante + una cabecera de Location + cabecera JSON
			$respuesta = Response::make(json_encode(['data' => $nuevoFabricante]), 201)->header('Location', 'http://www.dominio.local/fabricantes/' . $nuevoFabricante->id)->header('Content-Type', 'application/json');
			return $respuesta;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {//se le pasa a un id
	//se llama a este metodo cuando pongo fabricantes barra y un id de fabricante
	//me muestra la informacion de un fabricante
	//el metodo q se le pasa para buscar a un fabricante es find
	//y hay q pasarle un json
		//corresponde con la ruta /fabricantes({fabricante}
		//buscamos un fabricante x el ID
		$fabricante = Fabricante::find($id);
		//compramos si ese fabricante existe o no
		//si hay datos devolvemos un codigo 200 y si no los hay devolvemos un 404
		if (!$fabricante) {
			//se devuelve un array errors con los errores y codigo 404
			return response()->json(['errors' => Array(['code' => 404, 'message' => 'No se encuentra un fabricante con ese código'])], 404);
		}
		//devolvemos la informacion encontrada
		return response()->json(['status' => 'ok', 'data' => $fabricante], 200);
	}

	//el show es para uno en particular si qro filtrar lo haria en el index
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	/*
	  public function edit($id)
	  {
	  //
	  }

	  /**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request) {//para put y patch//PROBAR!!!!!!!!!!!!
	// en el put se actualizan los datos y en el patch se actualiza uno de los campos y en los dos se entra x update
	//asi q tengo q comprobar...
		// para actualizar un fabricante se le pasa el id (en la ruta)
		//vamos a actualizar un fabricante y para eso comprobamos si el fabricante existe o no
		//en otro caso devolvemos error
		$fabricante=Fabricante::find($id);
		//si no existe mostramos error
		if(!$fabricante)
		{   //return response()->json(['errors' => Array(['code' => 404, 'message' => 'No se /
			//	un fabricante con ese código'])], 404);/
			return response()->json(['errors'=>array(['code'=>404, "message"=>"error"])], 404);
		}
		//almacenamos variables para facilitar el uso, los campos recibidos
		$nombre=$request->input('nombre');
		$direccion=$request->input('direccion');
		$telefono=$request->input('telefono');
		
		//comprobamos si recibimos peticion x patch
		if($request->method()=='PATCH')
		{
			$bandera=false;
			//ACTUALIZACION PARCIAL DE DATOS
				if($nombre !=null && $nombre!='')
				{
					$fabricante->nombre=$nombre;
					$bandera=true;
				}
			//ACTUALIZACION PARCIAL DE DATOS
				if($direccion !=null && $direccion!='')
				{
					$fabricante->direccion=$direccion;
					$bandera=true;
				}
				//ACTUALIZACION PARCIAL DE DATOS
				if($telefono !=null && $telefono!='')
				{
					$fabricante->telefono=$telefono;
					$bandera=true;
				}
				if ($bandera)
				{
					//grabamos fabricante
					$fabricante->save();
					//devolvemos un 200
					return response()->json(['status'=>'ok','data'=>$fabricante],200);
				}
				else
				{
					//devolvemos un 304 not modified
					return response()->json(['errors'=>array(['code'=>304, 'message'=>"No se ha modificado ningun dato del fabricante"])],304);
				}
		}
		
		
		//METODO PUT actualizamos todos los campos
		//comprobamos q recibimos todos
		if (!$nombre || !$direccion || $telefono)
		{
			//de devuelve codigo 422 q sig q no se pden procesar los campos
			return response()->json(['errors'=>array(['code=>422','message'=>"Faltan valores"])],422);
			//actualizamos los 3 campos
			$fabricante->nombre=$nombre;
			$fabricante->direccion=$direccion;
			$fabricante->telefono=$telefono;
			
			//grabamos el fabricante
			$fabricante->save();
			return response()->json(['status'=>'ok','data'=>$fabricante],200);
			
		}
	}

	
	public function destroy($id) {
		//borrado de un fabricante
		//ejemplo: /fabricantes/89 por DELETE
		//COMPROBAMOS si el fabricante existe o no
		$fabricante = Fabricante::find($id);
		if (!$fabricante) {
			//devolvemos error
			return response()->json(['errors' => array(['code' => 404, "messagge" => "No se encuentra el fabricante"])], 404);
		}
		//borramos el fabricante y delvovemos codigo 204
		//204 sig NO CONTENT
		//ESTE CODIGO no mustra texto en el body
		//si qsieramos ver el mensaje devolveriamos un codigo 200
		//antes de borrarlo comprobamos si tiene aviones y si es asi 
		//sacamos un mensaje d error
		//$aviones = $fabricante->aviones()->get();
		$aviones = $fabricante->aviones;		
		if (sizeof($aviones)>0)
		{
			
			//si quisieramos borrar todos los aviones del fabricante seria:
			//$fabricante->aviones->delete();
			//
			
			
			//devolvemos un codigo de conflicto 409
			return response()->json(['errors' => array(['code' => 409, "messagge" => "Este fabricante posee aviones y no puede ser eliminado"])], 409);
		}
		//eliminamos el fabricante si no tiene aviones
		$fabricante->delete();

		//se devuelve el codigo 204 No content
		return response()->json(['code' => 204, "message" => "Se ha eliminado correctamente el fabricante"], 204);
	}

}
