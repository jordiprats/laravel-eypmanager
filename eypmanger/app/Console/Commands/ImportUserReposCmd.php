<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\ImportUserRepos;

class ImportUserReposCmd extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'users:importgithubrepos {nickname}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'import user\'s repos';

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

    try
    {
      Log::info("scheduled job ImportUserRepos: ".$nickname);
      dispatch(new ImportUserRepos($nickname));
    }
    catch(\Exception $e)
    {
      Log::info("-_(._.)_-");
      Log::info($e);
    }
  }
}
