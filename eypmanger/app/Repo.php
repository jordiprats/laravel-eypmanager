<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repo extends Model
{
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function releases()
  {
    return $this->hasMany(Release::class, 'repo_id');
  }

}
