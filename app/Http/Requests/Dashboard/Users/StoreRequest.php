<?php

declare(strict_types=1);

namespace App\Http\Requests\Dashboard\Users;

use App\Role;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|in:' . Role::query()->pluck('id')->implode(','),
            'photo' => 'file|mimes:gif,jpeg,jpg,jpe,png',
            'photo_alt' => 'required_with:photo|max:255',
        ];
    }
}
