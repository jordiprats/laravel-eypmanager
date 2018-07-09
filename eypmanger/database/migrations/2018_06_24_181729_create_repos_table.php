<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('repos', function (Blueprint $table) {
        $table->increments('id');
        $table->string('repo_name');
        $table->string('clone_url');
        $table->string('full_name')->nullable();
        $table->string('project_name')->nullable();
        $table->string('fork')->nullable();
        $table->boolean('private')->default(false);
        $table->integer('user_id')->nullable()->references('id')->on('users');
        $table->boolean('webhook')->default(false);
        $table->string('webhook_password')->nullable();
        $table->boolean('autoreleasetags')->default(true);
        $table->boolean('autotag')->default(true);
        $table->integer('github_id')->nullable();
        $table->boolean('puppet_module')->default(false);
        $table->timestamp('repo_analyzed_on')->nullable();
        $table->timestamp('fetched_repo_releases_on')->nullable();
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
      Schema::dropIfExists('repos');
    }
}
