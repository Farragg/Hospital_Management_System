<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorsRequest extends FormRequest
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
            "email" => 'required|email|unique:doctors,email,' . $this->id,
            "password" => 'required|sometimes',
            "phone" => 'required|numeric|unique:doctors,phone,' . $this->id,
            "name" => 'required|regex:/^[A-Za-z0-9-أ-ي-pL\s\-]+$/u',
            "appointments" => 'required',
            "section_id" => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('Dashboard\validation.required'),
            'email.email' => trans('Dashboard\validation.email'),
            'email.unique' => trans('Dashboard\validation.unique'),
            'password.required' => trans('Dashboard\validation.required'),
            'phone.required' => trans('Dashboard\validation.required'),
            'phone.numeric' => trans('Dashboard\validation.numeric'),
            'phone.unique' => trans('Dashboard\validation.unique'),
            'name.required' => trans('Dashboard\validation.required'),
            'name.regex' => trans('Dashboard\validation.regex'),
            'section_id.required' => trans('Dashboard\validation.required'),
        ];
    }

}
