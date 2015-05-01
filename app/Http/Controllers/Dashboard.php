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
        $channels = \Auth::user()->channels;
        $condition = [];
        
        $condition['channel']['$in'] = \Auth::user()->channels;
        
        if($r->input("searchFilter"))
        {
            $condition['$or'][]['title'] = new \MongoRegex("/".$r->input('searchFilter')."/i");
            $condition['$or'][]['body'] = new \MongoRegex("/".$r->input('searchFilter')."/i");
        }

        $cursor = \App\Post::raw()->find($condition)->sort(['publish_date' => -1])->skip($page * 50)->limit(50);
        return response()->json(['error'=>0, 'result'=>  iterator_to_array($cursor, false)]);
    }

}
