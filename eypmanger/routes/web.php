<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/webhook/github', 'WebhookController@github_status')->name('github.webhook.status');
Route::post('/webhook/github', array(
                                      'uses' => 'MergeController@listener',
                                      'middleware' => ['githubvalidator']
                                    ))->name('github.mergehook');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('/login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Route::prefix('/settings')->group(function () {
  Route::get('/profile', 'UserController@edit')->name('user.edit');
  Route::post('/profile', 'UserController@edit')->name('user.edit');
  Route::put('/profile.update', 'UserController@update')->name('user.update');
  Route::post('/profile.update', 'UserController@update')->name('user.update');
  Route::prefix('/controllers')->group(function () {
    Route::resource('/orgs', 'OrganizationController');
    Route::resource('/repos', 'RepoController');
    Route::resource('/platforms', 'PlatformController');
    Route::resource('/reporeleases', 'RepoReleaseController');
  });
});

Route::prefix('/{nickname}')->group(function () {
  Route::prefix('/platforms/{platform}')->group(function () {
    Route::get('/', 'PlatformController@getUserPlatform')->name('show.eyp.user.platform');
  });
  Route::prefix('/repos/{repo}')->group(function () {
    Route::get('/', 'RepoController@getUserRepo')->name('show.eyp.user.repo');
  });
  Route::get('/', 'UserController@getUserInfo')->name('show.eyp.user');
});
