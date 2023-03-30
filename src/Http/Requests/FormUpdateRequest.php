<?php

namespace dnj\SimpleContactForm\Http\Requests;

use dnj\SimpleContactForm\Rules\Scalar;
use Illuminate\Foundation\Http\FormRequest;

class FormUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contactChannels' => ['sometimes', 'required', 'array'],
            'contactChannels.*' => ['string', 'required'],
            'message' => ['sometimes', 'required', 'string'],
            'additionalDetails' => ['sometimes', 'required', 'array'],
            'additionalDetails.*' => ['required', new Scalar()],
        ];
    }
}
