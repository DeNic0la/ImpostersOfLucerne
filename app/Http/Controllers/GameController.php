<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Quotation;
use App\Events\GameStateUpdated;

class GameController extends Controller
{
    public function rooms( Request $request){
      return Room::where('state',0)->get();
    }

    public function players(Request $request, $roomId){
      return Player::where('room_id', $roomId)->with('user')->get();
    }

    public function newPlayer( Request $request, $roomId){
      if (DB::table('Players')->where('room_id', $roomId)->where('user_id', Auth::id())->count() == 0){
        $Player = new Player;
        $Player->user_id = Auth::id();
        $Player->room_id = $roomId;
        $Player->ready = 0;
        $Player->save();

        return $Player;
      }
    }

    public function playerReadyConfirm(Request $request,$roomId){
      $updateRoom = Room::where('room_id', $roomId);
      $updateRoom->update(['state' => 1]);
      broadcast(new GameStateUpdated($updateRoom->get()))->toOthers();
    }

    public function deletePlayer(Request $request, $roomId){            
      return Player::where('id', $request['playerId'])->delete();
    }
}
