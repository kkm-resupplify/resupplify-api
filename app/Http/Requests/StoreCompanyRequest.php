<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;

class StoreCompanyRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:30|unique:companies',
            'description' => 'string|min:6|max:90',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
      if ($this->expectsJson()) {
        $errors = (new ValidationException($validator))->errors();
        $errors = Arr::flatten($errors);
        throw new HttpResponseException(
          response()->json(['error' => [
            'code' => 'gen-0009',
            'message' => __("messages.company.validationError"),
            'data' => $errors,
          ]], 422)
        );
      }
      parent::failedValidation($validator);
    }
}
