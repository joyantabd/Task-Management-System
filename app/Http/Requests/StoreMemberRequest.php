<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|string|max:11|unique:members',
            'email' => 'required|email|unique:members',
            'status' => 'required|numeric',
            'team_id' => 'required|numeric',
            'photo' =>  'required',
            'password' =>  'required|min:6|max:18',
            ];
    }
}
