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
Route::get('/data.json', function() {
    //$cursor = DB::getCollection('posts')->find(); //official communication proccess
    $cursor = User::raw()->find();
    $posts = [];
    foreach ($cursor as $d)
        $posts[] = $d;
    return response()->json($posts);
});
Route::get('/user.data', function() {
    $user = Auth::user();
    $user->teste = array("ab", "cd", "ef");
    $user->save();
    return var_dump(($user), true);
});
Route::get('collect', function() {
    $feed = \Feeds::make('http://jovemnerd.com.br/rss');
    $ret = "";
    foreach ($feed->get_items() as $item) {
        $ret .= $item->get_title() . "<br/>";
    }
    return $ret;
});
Route::post('dashboard/feeds/{page}', 'dashboard@get_feeds')->where('page', '[0-9]+');
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
    'dashboard' => 'Dashboard',
    'profile' => 'Profile'
]);
