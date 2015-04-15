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

Route::get('/', function() {
    if (Auth::check())
        return redirect('dashboard');
    return redirect('auth/login');
});

Route::get('/data.json', function() {
    $cursor = DB::getCollection('posts')->find(); //official communication proccess
    $posts = [];
    foreach ($cursor as $d)
        $posts[] = $d;
    return response()->json($posts);
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
    'dashboard' => 'Dashboard',
]);
