<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Registrar;

class Profile extends Controller {

    private $registrar;
    private $user;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex() {
        return response()->json($this->user);
    }

    public function postIndex(Request $r) {
        $validator = $this->registrar->validator($r->all());

        if (!$validator->fails()) {
            $new = $this->registrar->create($r->all());
            $this->user->name = $new->name;
            $this->user->password = $new->password;
            $this->user->save();
        }
        return redirect('profile');
    }

    public function __construct(Registrar $registrar) {
        $this->registrar = $registrar;
        $this->middleware('auth');
        $this->user = \Auth::user();
    }

}
