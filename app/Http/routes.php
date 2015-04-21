<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//creamos las rutas nuevas q tendran en cuenta los 
//controllers programados en controllers

//ruta/fabricantes y todo lo q cuelga de fabricantes
Route::resource('fabricantes', 'FabricanteController',['except'=>['edit','create']]);

//propiedad q contiene un array de opciones q no quiero q contenga

//Recurso anidado /fabricantes/xx/aviones
Route::resource('fabricantes.aviones','FabricanteAvionController',['except'=>['edit','create','show']]);

//ruta/aviones y todo lo q cuelga de aviones
//El resto de metodos los gestiona FabricanteAvion
Route::resource('aviones', 'AvionController',['only'=>['index','show']]);

//ruta por defecto //asi se muestra eso cuando recargamos
Route::get('/', function()
{
return "Bienvenidos al API RESTful de Aviones";	
});
//cuando entres en el controlador welcome vas a crear el index
/*
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/