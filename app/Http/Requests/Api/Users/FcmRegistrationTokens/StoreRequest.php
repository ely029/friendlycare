<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Users\FcmRegistrationTokens;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Supplements 'auth.once' middleware.
        return $this->route('user')->id === Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'registration_id' => [
                'required',
                'string',
                Rule::unique('fcm_registration_tokens', 'registration_id')
                    ->where(function ($query) {
                        return $query->where('user_id', Auth::id());
                    }),
            ],
        ];
    }
}
