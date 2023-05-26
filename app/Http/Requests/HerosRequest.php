<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HerosRequest extends FormRequest
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
        $userId = Auth::id();

        return [
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'phone_number' => 'required|string',
            'street' => 'required|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
            'incidents' => [
                'required',
                'array',
                'between:1,3',
                Rule::exists('incidents', 'id')
            ],
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where(function ($query) use ($userId) {
                    $query->where('id', $userId);
                })
            ],
        ];
    }
}
