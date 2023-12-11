<?php

namespace App\Resources\Product;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductTranslationResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'languageId' => $this->pivot->language_id,
      'name' => $this->pivot->name,
      'description' => $this->pivot->description,
    ];
  }
}
