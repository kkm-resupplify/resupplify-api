<?php

namespace App\Services;

use App\Helpers\ThrowExceptionTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BasicService {
  use ThrowExceptionTrait;

  public function __construct() {}

  
}