<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
  protected $guarded = [];

  public function repo()
  {
    return $this->belongsTo(Repo::class);
  }

  public function platforms()
  {
      return $this->belongsToMany(Platforms::class)->withTimestamps();
  }
}
