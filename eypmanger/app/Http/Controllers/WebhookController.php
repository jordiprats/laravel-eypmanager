<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
  public function github_status()
  {
    return [ 'message' => 'webhook listening' ];
  }

  public function listener(Request $request)
  {
    // github
    $reponame=$request->input('repository.name');
    $fork=$request->input('repository.fork');
    $full_name_tokenized=explode("/", $request->input('repository.full_name'));
    $nickname=$full_name_tokenized[0];

    // bitbucket
    $project_key=$request->input('repository.project.key');

    $user = User::where(['nickname' => $nickname])->first();
    if($user)
      $repo = Repo::where(['user_id'=>$user->id, 'full_name'=>$full_name]);

    // heuristics tipus repo
    if($project_key=="")
    {
      if($user && $repo)
      {
        if(!$fork || $repo->autotag)
        {
          //WORK here
          return [ 'penis'=> '8==============D~~' ];
        }
        else
        {
          Log::info("discarted webhook:".$full_name);
          return [ 'penis'=> '8=====D' ];
        }
      }
      else
      {
        Log::info("not a registered user/repo: ".$full_name);
        return [ 'penis'=> '8=======D' ];
      }
    }
    else
    {
      Log::info("discarting bitbucket repo: ".$project_key."/".$repo);
      return [ 'penis'=> '8======D' ];
    }
  }
}
