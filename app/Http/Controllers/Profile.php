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
        if ($r->input('password')) {
            $val['password'] = 'required|confirmed|min:6';
            $this->user->password = bcrypt($r->input('password'));
        }
        $validator = Validator::make($r->all(), $val);
        if (!$validator->fails()) {
            $this->user->name = $r->input('name');
            $this->user->save();
            return response()->json(['error' => 0, 'result' => $this->user]);
        } else {
            return response()->json(['error' => 1, 'result' => $validator->errors()->getMessages()]);
        }
    }

    public function getChannels() {
        return response()->json(['error' => 0, 'result' => $this->user->channels]);
    }

    public function postChannels(Request $r) {
        $validator = Validator::make($r->all(), ['address' => 'required']);
        if ($validator->fails()) {
            return response()->json(['error' => 1, 'result' => $validator->errors()->getMessages()]);
        } else {
            $channel = \App\Services\Channel::lookup($r->input('address'));
            $channels = (is_array($this->user->channels)?$this->user->channels:[]);
            if (!\in_array($channel->_id, $channels))
                $channels[] = $channel->_id;
            $this->user->channels = $channels;
            $this->user->save();
            return response()->json(['error' => 0, 'result' => $this->user->channels]);
        }
    }

    public function postChannelsUpdate(Request $r) {
        $validator = Validator::make($r->all(), ['channels' => 'required|array']);
        if (!$validator->fails()) {
            $this->user->channels = $r->input('channels');
        } else {
            $this->user->channels = [];
        }
        $this->user->save();
        return response()->json(['error' => 0, 'result' => $this->user->channels]);
    }

    public function __construct() {
        $this->middleware('auth');
        $this->user = \Auth::user();
    }

}
