<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginPost extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'a'=>'bail|required',
            'b'=>'bail|required'
        ];
    }
    function messages(){
    return [
         'a.required'=>'登录失败',
         'b.required'=>'登录失败',
        ];
    }
}
