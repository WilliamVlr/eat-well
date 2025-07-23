<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nameInput' => [
                'required',
                'string',
                'max:255',
                'not_regex:/<[^>]*>/'
            ],

            'dateOfBirth' => 'nullable|date|before:today',
            'gender' => 'required|in:male,female',
            'profilePicInput' => 'nullable|image|mimes:jpg,jpeg,png',
            'nameInput.not_regex' => 'Name must not contain HTML or script tags.',

        ];
    }

    public function messages()
    {
        return [
            'nameInput.required' => 'Name is required.',
            'nameInput.string' => 'Name must be a string.',
            'nameInput.max' => 'Name must not be more than 255 characters.',

            'dateOfBirth.date' => 'Date of Birth must be a valid date.',
            'dateOfBirth.before' => 'Date of Birth must be before today.',

            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be either male or female.',

            'profilePicInput.image' => 'Profile picture must be an image.',
            'profilePicInput.mimes' => 'Profile picture must be a file of type: jpg, jpeg, png.',
            'profilePicInput.max' => 'Profile picture must not be larger than 2MB.',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        logActivity('Failed', 'Updated', "Profile due to validation errors : " . implode($validator->errors()->all()));

        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }
}
