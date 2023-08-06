<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }
  public function rules(): array
  {
    return [
      'email' =>'required|email|unique:users|string',
      'first_name' =>'required|max_length:30|min_length:3|string',
      'last_name' =>'required|max_length:30|min_length:3|string',
      'password' =>'required|max_length:30|min_length:6|confirmed',
    ];
  }
}