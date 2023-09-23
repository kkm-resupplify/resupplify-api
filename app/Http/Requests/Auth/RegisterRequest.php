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
      'first_name' =>'required|max:30|min:3|string',
      'last_name' =>'required|max:30|min:3|string',
      'password' =>'required|max:30|min:6|confirmed',
    ];
  }
}