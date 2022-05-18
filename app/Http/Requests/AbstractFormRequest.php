<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class AbstractFormRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        if($this->wantsJson()){
            $errors = (new ValidationException($validator))->errors();
            throw new HttpResponseException(
                response()->json(['status'=>0, 'code'=>422 ,  'message'=>$validator->errors()->first() , 'data'=>null] , 422)
            );
        }else{
            parent::failedValidation($validator);
        }
    }
}
