<?php

/**
 * Created by PhpStorm.
 * User: rakib
 * Date: 7/10/2019
 * Time: 2:45 AM
 */

namespace App\Http\Requests\Backend\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $rules = [
            'name'  => 'required|max:190',
        ];
        return $rules;
    }
}
