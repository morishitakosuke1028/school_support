<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateChildRequest extends FormRequest
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
        $childId = $this->child;
        return [
            'name' => 'required|string|max:255',
            'kana' => 'required|string|max:255|regex:/^[\p{Hiragana}\s]+$/u',
            'email' => 'required|string|email|max:255|'.Rule::unique('children')->ignore($childId),
            'zip' => 'nullable|digits:7',
            'address' => 'nullable|string|max:255',
            'tel' => 'required|string|max:13',
            'gender' => 'required|in:1,2',
            'admission_date' => 'required|date_format:Y-m-d',
            'birthday' => 'nullable|date_format:Y-m-d',
            'movein_date' => 'nullable|date_format:Y-m-d',
            'graduation_date' => 'nullable|date_format:Y-m-d',
            'pin_code' => 'required|string|max:255',
            'session_id' => 'required|string|max:255',
        ];
    }
}
