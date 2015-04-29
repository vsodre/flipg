<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dashboard extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex() {
        return view('index')->with('name', \Auth::user()->name);
    }

    public function get_feeds(Request $r, $page) {
        $cursor = \App\Post::raw()->find()->skip($page * 50)->limit(50);
        $feeds = [];
        foreach ($cursor as $data)
            $feeds[] = $data;
        return response()->json(['error'=>0, 'result'=>$feeds]);
    }

}
