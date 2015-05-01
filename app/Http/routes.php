<?php

use App\User;

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
Route::post('dashboard/feeds/{page}', 'dashboard@get_feeds')->where('page', '[0-9]+');
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
    'dashboard' => 'Dashboard',
    'profile' => 'Profile'
]);
