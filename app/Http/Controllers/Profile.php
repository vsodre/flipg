<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class Profile extends Controller {

    private $user;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex() {
        return response()->json(['error' => 0, 'result' => $this->user]);
    }

    public function postIndex(Request $r) {
        $val['name'] = 'required|max:255';
        if($r->input('password')){
            $val['password'] = 'required|confirmed|min:6';
            $this->user->password = bcrypt($r->input('password'));
        }
        $validator = Validator::make($r->all(), $val);
        if(!$validator->fails()){
            $this->user->name = $r->input('name');
            $this->user->save();
            return response()->json(['error' => 0, 'result' => $this->user]);
        } else {
            return response()->json(['error' => 1, 'result' => $validator->errors()->getMessages()]);
        }
    }

    public function __construct() {
        $this->middleware('auth');
        $this->user = \Auth::user();
    }

}
