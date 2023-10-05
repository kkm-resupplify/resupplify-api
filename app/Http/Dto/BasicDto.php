<?php

namespace App\Http\Dto;

use App\Helpers\ThrowExceptionTrait;
use Spatie\LaravelData\Data;
use Illuminate\Validation\Validator;
use App\Exceptions\General\ValidationFailedException;

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
                self::throw(new ValidationFailedException(errorData: ['errors' => $validator->errors()]));
            }
        });
    }

}
