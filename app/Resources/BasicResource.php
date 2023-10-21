<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use App\Helpers\ThrowExceptionTrait;
abstract class BasicResource extends JsonResource
{
    use ThrowExceptionTrait;
}
