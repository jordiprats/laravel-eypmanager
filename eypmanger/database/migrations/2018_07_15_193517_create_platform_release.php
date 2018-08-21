<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformRelease extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('platform_release', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('platform_id')->references('id')->on('platforms');
      $table->integer('release_id')->references('id')->on('releases');
      $table->boolean('prerelease')->default(false);
      $table->boolean('draft')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('platform_release');
  }
}
