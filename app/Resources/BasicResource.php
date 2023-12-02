<?php

namespace App\Resources;

use App\Helpers\ThrowExceptionTrait;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BasicResource extends JsonResource
{
    use ThrowExceptionTrait;
}
