<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class ListUsersCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'users:emails';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'get emails list';

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
    foreach(User::orderBy('email', 'ASC')->get() as $user)
    {
      print($user->email."\n");
    }
  }
}
