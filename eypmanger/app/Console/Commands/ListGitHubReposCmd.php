<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Github\ResultPager;
use App\Http\Controllers\UserController;

class ListGitHubReposCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'users:listgithubrepos {nickname} {--debug}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'list github repos for a given registered user';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $nickname=$this->argument('nickname');

    $github=UserController::githubAPI($nickname);
    if($github)
    {
      $github_paginator  = new ResultPager($github);

      $github_repos=$github_paginator->fetchAll($github->users(), 'repositories', [$nickname]);

      if($this->option('debug'))
        print_r($github_repos);
      else
        foreach ($github_repos as $github_repo)
          print($github_repo['full_name']."\n");
    }
    else print("ERROR: ".$nickname." is not an eypmanager registered user\n");
  }
}
