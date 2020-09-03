<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmployeeRequest extends Request
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
            'employeename' => 'required|unique:employee',
            'position' => 'required',
            'address' => 'required',
            'contactno' => 'required',
            'username' => 'required|max:255',
            'password' => 'required|confirmed|min:6',
        ];
    }
}
