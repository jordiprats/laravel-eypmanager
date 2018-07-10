<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\UserController;

class ListRepoHooksCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'repos:listhooks {full_name} {--debug}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'get hooks';

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
    $full_name=$this->argument('full_name');
    $full_name_tokenized=explode('/',$full_name);
    $nickname=$full_name_tokenized[0];
    $reponame=$full_name_tokenized[1];

    $github=UserController::githubAPI($nickname);

    if($github)
    {
      $github_hooks=$github->repo()->hooks()->all($nickname, $reponame);
      if($this->option('debug'))
        print_r($github_hooks);
      else
      {
        foreach ($github_hooks as $github_hook)
        {
          $hook_type = $github_hook['name'];
          switch ($hook_type)
          {
            case "web":
              print("web: ".$github_hook['config']['url']."\n");
              break;
            case "travis":
              print("travis: ".$github_hook['config']['domain']."\n");
              break;
          }
        }
      }
    }
    else print("ERROR: ".$nickname." is not an eypmanager registered user\n");

  }
}
