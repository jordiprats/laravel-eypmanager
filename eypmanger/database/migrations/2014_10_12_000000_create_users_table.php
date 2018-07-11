<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->string('email')->unique();
      $table->string('name')->nullable();
      $table->string('nickname')->nullable();
      $table->string('password')->nullable();
      $table->boolean('organization')->default(false);
      $table->boolean('webhook')->default(false);
      $table->string('webhook_password')->nullable();
      $table->timestamp('fetched_repos_on')->nullable();
      $table->rememberToken();
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
    Schema::dropIfExists('users');
  }
}
