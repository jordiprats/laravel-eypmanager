<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
  public static function importOrganizations()
  {

  }
  
  public static function githubAPI($nickname)
  {
    $user=User::where(['nickname'=> $nickname])->first();

    if($user)
    {
      if(!$user->organization)
      {
        return app('github.factory')->make(['token' => $user->githubSocialAccount->first()->token, 'method' => 'token']);
      }
      else
      {
        // TODO
        Log::info("UserController::githubAPI: ".$this->nickname." is organization - NOT IMPLEMENTED");
        return null;
      }
    }
    else return null;
  }

  public function getUserInfo($nickname)
  {
    if(User::where('nickname', $nickname)->count() == 1)
    {
      return view('users.show')
              ->with('user',      User::where('nickname', $nickname)->first())
              ->with('repos',     User::where('nickname', $nickname)->first()->repos)
              ->with('platforms', User::where('nickname', $nickname)->first()->platforms);
    }
    else
    {
      abort(404);
    }
  }
}
