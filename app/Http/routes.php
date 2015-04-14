<?php
use Illuminate\Http\Response;
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

//Route::get('/', 'WelcomeController@index');

//Route::get('home', 'HomeController@index');

Route::get('/', function(){
	return view("index");
});
Route::get('/login', function(){
	return view("login");
});
Route::get('/data.json', function(){
	/*$cursor = DB::collection('posts')->raw(function($collection){
		return $collection->find();
	});*/
	$cursor = DB::getCollection('posts')->find(['title'=>'y first Post']);
	$posts = [];
	foreach($cursor as $d) $posts[] = $d;
	return response()->json($posts);
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
