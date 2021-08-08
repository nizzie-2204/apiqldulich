<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
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
            't_ten' => 'required',
            't_soluong' => 'required',
            't_mota' => 'required',
            't_tgbatdaudk' => 'required',
            't_tgketthucdk' => 'required',
            't_ngaybatdau' => 'required',
            't_ngayketthuc' => 'required',
            't_gia' => 'required',
            'dv_id' => 'nullable',
            'images' => 'nullable',

        ];
    }
}
