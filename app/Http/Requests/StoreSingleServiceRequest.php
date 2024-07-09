<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSingleServiceRequest extends FormRequest
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
            // check name = name && serviceId = ServiceId
            "name" => 'required|unique:service_translations,name,'.$this->id.',Service_id',
            'price' => 'numeric|required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('Dashboard\validation.required'),
            'name.unique' => trans('Dashboard\validation.unique'),
            'price.required' => trans('Dashboard\validation.required'),
            'price.numeric' => trans('Dashboard\validation.numeric'),
        ];
    }
}
