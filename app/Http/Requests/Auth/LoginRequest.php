<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;

class LoginRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }
  public function rules(): array
  {
    return [
      'email' =>'required|email|string',
      'password' =>'required|max_length:30|min_length:6',
    ];
  }
  protected function failedValidation(Validator $validator)
  {
    if($this->expectsJson())
    {
      $errors = (new ValidationException($validator))->errors();
      $errors = Arr::flatten($errors);
      throw new HttpResponseException(
          response()->json(['error' => ['code' => 'gen-0001',
          'message' => __("messages.loginValidationError"),
          'data' => $errors,
          ]], 422)
      );
    }
    parent::failedValidation($validator);
  }
}