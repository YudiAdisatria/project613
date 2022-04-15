<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsetRequest extends FormRequest
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
            'id_aset' => ['required', 'string', 'max:15'], 
            'id_kategori' => ['required', 'string', 'max:15'], 
            'nama_aset' => ['required', 'string', 'max:50'], 
            'gedung' => ['required', 'string', 'max:50'],
            'ruangan' => ['required', 'string', 'max:50'], 
            'kondisi' => ['required', 'string', 'max:15'], 
            'harga_beli' => ['required'], 
        ];
    }
}
