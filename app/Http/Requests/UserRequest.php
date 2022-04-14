<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Actions\Fortify\PasswordValidationRules;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;
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
            'nama' => ['required', 'string', 'max:255'],
            'noHp' => ['required', 'string', 'max:15', 'unique:users'],
            'password' => $this->passwordRules(),
            'roles' => ['required', 'string', 'max:255', 'in:PLAIN,USER,ADMIN'],
            'divisi' => ['required', 'string', 'max:255'],
        ];
    }
}
