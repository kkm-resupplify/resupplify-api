<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;

class UserDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:30|min:3|string',
            'last_name' => 'required|max:30|min:3|string',
            'phone_number' => 'required|numeric|regex:"^\+[1-9]\d{1,14}$"',
            'birth_date' => 'required|date_format:Y-m-d|before:-18 years',
            'sex' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
      if ($this->expectsJson()) {
        $errors = (new ValidationException($validator))->errors();
        $errors = Arr::flatten($errors);
        throw new HttpResponseException(
          response()->json(['error' => [
            'code' => 'gen-0010',
            'message' => __("messages.userDetailsRequest.validationError"),
            'data' => $errors,
          ]], 422)
        );
      }
      parent::failedValidation($validator);
    }
}
