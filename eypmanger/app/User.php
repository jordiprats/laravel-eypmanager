<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;

  protected $guarded = [];

  protected $hidden = [
      'password', 'remember_token',
  ];

  public function repos()
  {
    return $this->hasMany(Repo::class);
  }

  public function linkedsocialaccounts()
  {
    return $this->hasMany(LinkedSocialAccount::class);
  }

  public function github()
  {
    return $this->hasMany(LinkedSocialAccount::class)>where('provider', 'github');
  }

  public function platforms()
  {
    return $this->hasMany(Platform::class);
  }
}
