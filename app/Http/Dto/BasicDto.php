<?php

namespace App\Http\Dto;

use App\Helpers\ThrowExceptionTrait;
use Spatie\LaravelData\Data;
use Illuminate\Validation\Validator;

class BasicDto extends Data
{
    use ThrowExceptionTrait;

    /**
     * Set validator.
     *
     * @param Validator $validator
     *
     * @return void
     */
    public static function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                self::throw(new ValidationFailedException(moreData: ['errors' => $validator->errors()]));
            }
        });
    }

}
