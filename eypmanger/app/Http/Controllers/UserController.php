<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
  //

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
