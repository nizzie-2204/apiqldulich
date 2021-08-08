<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array
     */
    public function rules()
    {
        return [
            //
            'nv_ten' => 'required',
            'nv_namsinh' => 'required',
            'nv_diachi' => 'required',
            'nv_sdt' => 'required',
            'nv_gioitinh' => 'nullable|max:1',
            'nv_password' => 'nullable|min:6|max:20'
        ];
    }
}
