<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $userId = $this->user;
        return [
            'name' => 'required|string|max:255',
            'kana' => 'required|string|max:255|regex:/^[\p{Hiragana}\s]+$/u',
            'email' => 'required|string|email|max:255|'.Rule::unique('users')->ignore($userId),
            'tel' => 'required|string|max:13',
            'role' => 'required|in:1,2',
            'retirement_date' => 'nullable|date_format:Y-m-d',
            'session_id' => 'required|string|max:255|'.Rule::unique('users')->ignore($userId),
        ];
    }
}
