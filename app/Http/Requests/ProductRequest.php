<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST': {
                    return [
                        'name' => 'required|string|max:255',
                        'description' => 'required|string',
                        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                    ];
                }
            case 'PUT': {
                    return [
                        'name' => 'sometimes|string|max:255',
                        'description' => 'sometimes|string|email|max:255|unique:users',
                        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    ];
                }
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            default:
                break;
        }
    }
}
