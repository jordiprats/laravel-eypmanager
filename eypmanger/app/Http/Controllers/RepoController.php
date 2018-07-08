<?php

namespace App\Http\Controllers;

use App\User;
use Github\ResultPager;
use Illuminate\Http\Request;

class RepoController extends Controller
{
  public static function fetchUserRepos($nickname)
  {
    $user=User::where(['nickname'=> $nickname])->first();

    if($user)
    {
      $github = UserController::githubAPI($nickname);
      $github_paginator  = new ResultPager($github);

      foreach ($github_paginator->fetchAll($github->users(), 'repositories', [$user->nickname]) as $github_repo)
      {
        $repo = Repo::where(['clone_url' => $github_repo['clone_url']])->first();

        if($github_repo['fork'])
        {
          $github_repo_extended=$github->repos()->showById($github_repo['id']);
          $fork=$github_repo_extended['parent']['full_name'];
        }
        else
        {
          $fork=NULL;
        }

        $is_private=$github_repo['private']?true:false;

        if(!$repo)
        {

          $repo = Repo::create([
              'repo_name'        => $github_repo['name'],
              'full_name'        => $github_repo['full_name'],
              'fork'             => $fork,
              'private'          => $is_private,
              'clone_url'        => $github_repo['clone_url'],
              'user_id'          => $user->id,
              'github_id'        => $github_repo['id'],
          ]);
        }
        else
        {

        }

      }
    }
    else return null;
  }
}
