<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\User;
use App\LinkedSocialAccount;
use App\Jobs\ImportUserRepos;

use Socialite;

class SocialAccountController extends Controller
{
  /**
   * Redirect the user to the GitHub authentication page.
   *
   * @return Response
   */
  public function redirectToProvider($provider)
  {
    return \Socialite::driver($provider)->scopes(['read:user', 'repo', 'admin:repo_hook' ])->redirect();
  }

  /**
   * Obtain the user information
   *
   * @return Response
   */
  public function handleProviderCallback($provider)
  {
    Log::info($provider);

    $userSocial = Socialite::driver($provider)->user();
    $user = User::where(['email' => $userSocial->getEmail()])->first();

    if($user)
    {
      # usuari ja existent (mail ja esta a la DB)
      auth()->login($user, true);
      $lsa = LinkedSocialAccount::where(['user_id' => $user->id])->first();

      $user->name = $userSocial->getName();
      $user->nickname = $userSocial->getNickname();

      $user->save();

      $lsa->nickname  = $userSocial->getNickname();
      $lsa->provider = $provider;
      $lsa->token = $userSocial->token;
      $lsa->refresh_token = $userSocial->refreshToken;
      $lsa->expires_in = $userSocial->expiresIn;

      $lsa->save();
    }
    else
    {
      # donar d'alta user si no el tenim per un altre provider
      $user = User::create([
          'email'            => $userSocial->getEmail(),
          'name'             => $userSocial->getName(),
          'nickname'         => $userSocial->getNickname(),
          'webhook_password' => substr(md5(str_random(10).uniqid().$provider),0,12),
      ]);

      // // OAuth Two Providers
      // $token = $user->token;
      // $refreshToken = $user->refreshToken; // not always provided
      // $expiresIn = $user->expiresIn;
      //
      // // OAuth One Providers
      // $token = $user->token;
      // $tokenSecret = $user->tokenSecret;

      // TODO: gestio OAuth One
      $lsa = LinkedSocialAccount::create([
        'user_id'       => $user->id,
        'nickname'      => $userSocial->getNickname(),
        'provider'      => $provider,
        'token'         => $userSocial->token,
        'refresh_token' => $userSocial->refreshToken,
        'expires_in'    => $userSocial->expiresIn,
      ]);

      auth()->login($user, true);
    }

    if($provider=="github")
    {
      if((!$user->fetched_repos_on) || ($user->fetched_repos_on < strtotime("-24 hours")))
        dispatch(new ImportUserRepos($user->nickname));
    }

    return redirect()->route('show.eyp.user', [$user->nickname]);
  }
}
