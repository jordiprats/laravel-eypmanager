<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkedSocialAccountsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // // OAuth Two Providers
    // $token = $user->token;
    // $refreshToken = $user->refreshToken; // not always provided
    // $expiresIn = $user->expiresIn;
    //
    // // OAuth One Providers
    // $token = $user->token;
    // $tokenSecret = $user->tokenSecret;
    Schema::create('linked_social_accounts', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->references('id')->on('users');
      // link info
      $table->string('provider')->nullable()->index();
      $table->string('token')->nullable();
      $table->string('refresh_token')->nullable();
      $table->string('expires_in')->nullable();
      $table->string('token_secret')->nullable();
      // user info
      $table->string('nickname')->nullable();
      $table->integer('github_id')->nullable();
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
    Schema::dropIfExists('linked_social_accounts');
  }
}
