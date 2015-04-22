<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Avion;

class AvionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$listaAviones=Cache::remember('cacheTodosAviones',5,function()
		{
			return Avion::all();
		});
		//devuelve la lista de todos los aviones dsde cache
		return response()->json(['status'=>"ok",'data'=>$listaAviones],200);
		
		//devuelve la lista de todos los aviones sin cache
		return response()->json(['status'=>"ok",'data'=>Avion::all()],200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	
	public function show($id)
	{
		//buscamos ese avion y si lo encuentra mostramos info
		$avion=Avion::find($id);
		if(!$avion)
		{
			return response()->json(['errors'=>["code"=>404,'message'=>"No se encuentra avion con ese codigo"]],404);
		}
		return response()->json(['status'=>'ok','data'=>$avion],200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	
}
