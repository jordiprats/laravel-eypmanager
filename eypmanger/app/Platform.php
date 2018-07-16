<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
  public function releases()
  {
      return $this->belongsToMany(Release::class)->withTimestamps();
  }
}
