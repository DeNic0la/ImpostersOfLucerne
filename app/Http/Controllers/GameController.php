<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function rooms( Request $request){
      return Room::all();
    }

    public function players(Request $request, $roomId){
      return Player::where('room_id', $roomId)->with('user');
    }

    public function newPlayer( Request $request, $roomId){
      if (DB::table('Player')->where('room_id', $roomId)->where('user_id', Auth::id())->count() == 0){
        $Player = new Player;
        $Player->user_id = Auth::id();
        $Player->room_id = $roomId;
        $Player->ready = 0;
        $Player->save();

        return $Player;
      }
    }
}
