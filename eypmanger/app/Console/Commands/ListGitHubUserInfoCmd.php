<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\UserController;

class ListGitHubUserInfoCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'users:listuserinfo {nickname} {--debug}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'list user info';

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
      $github_userinfo=$github->me()->show();
      if($this->option('debug'))
        print_r($github_userinfo);
      else
      {
        print($github_userinfo['login']." => ".$github_userinfo['name']."\n");
      }
    }
    else print("ERROR: ".$nickname." is not an eypmanager registered user\n");
  }
}
