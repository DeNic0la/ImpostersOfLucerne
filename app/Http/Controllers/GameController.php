<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Player;
use App\Models\User;
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
      if (DB::table('players')->where('room_id', $roomId)->where('user_id', Auth::id())->count() == 0){
        $Player = new Player;
        $Player->user_id = Auth::id();
        $Player->room_id = $roomId;
        $Player->ready = 0;
        $Player->save();

        return $Player;
      }
    }

    public function playerReadyConfirm(Request $request,$roomId){
      $updateRoom = Room::where('id', $roomId);
      $updateRoom->update(['state' => 1]);
      //return ;
      broadcast(new GameStateUpdated(Room::where('id',$roomId)->first()))->toOthers();

      return 1;

    }

    public function resestRoom(Request $request,$roomId){
      $updateRoom = Room::where('id', $roomId);
      $updateRoom->update(['state' => 0]);

      Player::where('room_id', $roomId)->delete();

      return 1;

    }

    public function confirmSelf(Request $request,$roomId){
  
      Player::where('user_id', Auth::id())->where('room_id', $roomId)->update(['ready' => 1]);
      return 1;
    }

    public function startGame(Request $request, $roomId){
      Player::where('room_id', $roomId)->where('ready', 0)->delete();
      $roomToStart = Room::where('id', $roomId);
      $Spieler = Player::where('room_id', $roomId)->where('ready', 1);
      $Anzahl = $Spieler->count();
      $AnzahlImposter = $request->imposter;
      $AnzahlSecurity = $request->security ? 1 : 0;
      $AnzahlVitals = $request->vitals ? 1 : 0;
      $AnzahlAdmin = $request->admin ? 1 : 0;
      $Spieler = $Spieler->get();
      $AnzahlCrewmate = $Anzahl - ($AnzahlImposter+$AnzahlSecurity+$AnzahlVitals+$AnzahlAdmin);
      Player::unguard();
      foreach ($Spieler as $Spieler){
        $numberIsOkey = false;
        $number = 0;
        while (!$numberIsOkey){
          $number = rand(0,5);
          if ($number == 1){
            if ($AnzahlCrewmate > 0){
              $numberIsOkey = true;
              $AnzahlCrewmate--;
            }
          }else if($number ==2){
            if ($AnzahlImposter > 0){
              $numberIsOkey = true;
              $AnzahlImposter--;
            }
          }else if($number ==3){
            if ($AnzahlSecurity > 0){
              $numberIsOkey = true;
              $AnzahlSecurity--;
            }
          }else if($number ==4){
            if ($AnzahlVitals > 0){
              $numberIsOkey = true;
              $AnzahlVitals--;
            }
          }else if($number ==5){
            if ($AnzahlAdmin > 0){
              $numberIsOkey = true;
              $AnzahlAdmin--;
            }
          }
        }
        $Spieler->update([
          'role' => $number,
        ]);
      }
      Player::reguard();
      $roomToStart->update(['state' => 2]);
      broadcast(new GameStateUpdated(Room::where('id',$roomId)->first()))->toOthers();
      
    }

    public function deletePlayer(Request $request, $roomId){            
      return Player::where('id', $request['playerId'])->delete();
    }

    public function getOwnIdentity(Request $request,$roomId){
      return Player::where('user_id', Auth::id())->where('room_id', $roomId)->value('role');
    }
}
