<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
  public function github_status()
  {
    return [ 'message' => 'webhook listening' ];
  }
}
