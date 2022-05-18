<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends AbstractFormRequest
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
                        'email' => 'required|string|email|max:255|unique:users',
                        'password' => 'required|string|min:6|confirmed',
                        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    ];
                }
            case 'PUT': {
                    return [
                        'name' => 'sometimes|string|max:255',
                        'email' => 'sometimes|string|email|max:255|unique:users',
                        'password' => 'sometimes|string|min:6|confirmed',
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
