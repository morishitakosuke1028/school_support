<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrowthRequest extends FormRequest
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
        return [
            'child_id' => ['required'],
            'height' => ['nullable', 'numeric', 'between:0,999.99'],
            'weight' => ['nullable', 'numeric', 'between:0,999.99'],
            'chest' => ['nullable', 'numeric', 'between:0,999.99'],
            'abdomen' => ['nullable', 'numeric', 'between:0,999.99'],
            'head' => ['nullable', 'numeric', 'between:0,999.99'],
            'measurement_month' => ['required', 'date_format:Y-m-d'],
        ];
    }
}
