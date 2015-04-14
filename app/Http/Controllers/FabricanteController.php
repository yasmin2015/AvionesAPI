<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//cargamos Fabricante
use App\Fabricante;
class FabricanteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 *///
	public function index()
	{
		//return "En el index de Fabricante";
		//devolvemos un JSON con todos los fabricantes
		//return Fabricante::all();
		//hacemos uso del modelo Fabricante pero hay q cargarlo arriba
		
		//para devolver un JSON con codigo de respuesta http
		return response()->json(['status'=>'ok','data'=>Fabricante::all()],200);
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
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)//se le pasa a un id
	//se llama a este metodo cuando pongo fabricantes barra y un id de fabricante
	//me muestra la informacion de un fabricante
	//el metodo q se le pasa para buscar a un fabricante es find
	//y hay q pasarle un json
	{
		//corresponde con la ruta /fabricantes({fabricante}
		//buscamos un fabricante x el ID
		$fabricante=Fabricante::find($id);
		//compramos si ese fabricante existe o no
		//si hay datos devolvemos un codigo 200 y si no los hay devolvemos un 404
		if (! $fabricante)
		{
			//se devuelve un array errors con los errores y codigo 404
			return response()->json(['errors'=>Array(['code'=>404,'message'=>'No se encuentra					un fabricante con ese código'])],404);
		}
		//devolvemos la informacion encontrada
		return response()->json(['status'=>'ok','data'=>$fabricante],200);
	}

	//el show es para uno en particular si qro filtrar lo haria en el index
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
