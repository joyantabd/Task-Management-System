<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskAssignRequest extends FormRequest
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
            'team_id' => 'required|numeric',
            'task_id' => 'required|numeric',
            'member_id' => 'required|numeric',
            'dead_line' => 'required|date',
            'description' => 'required|min:10|max:200',
            'status' => 'required|numeric',
            'priority' => 'required|numeric',
            ];
    }
}
