<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDangKyTourRequest extends FormRequest
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
            'dkt_hoten' => 'required',
            'dkt_sdt' => 'required',
            'dkt_namsinh' => 'required',
            'dkt_gioitinh' => 'required|max:1',
            'dkt_diachi' => 'required',
            't_id' => 'required',
        ];
    }
}
