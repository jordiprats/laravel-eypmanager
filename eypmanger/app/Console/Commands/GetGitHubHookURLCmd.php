<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetGitHubHookURLCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'eypmanager:getgithubhookurl';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'get github\'s webhook';

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
    //print(route('post.show'));
    print("TODO");
  }
}
