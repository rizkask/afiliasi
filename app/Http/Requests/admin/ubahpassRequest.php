<?php

namespace App\Http\Requests\Admin;

use App\Rules\CurrentPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ubahpassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kata_sandi_lama' => ['required', 'string', new CurrentPassword()],
            'kata_sandi_baru' => ['required', 'string', 'min:8'],
            'konfirmasi_kata_sandi_baru' => 'required|same:kata_sandi_baru',
        ];
    }
}
