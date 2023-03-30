<?php

namespace dnj\SimpleContactForm\Http\Requests;

use dnj\SimpleContactForm\Rules\Scalar;
use Illuminate\Foundation\Http\FormRequest;

class FormStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contactChannels' => ['required', 'array'],
            'contactChannels.*' => ['string', 'required'],
            'message' => ['required', 'string'],
            'additionalDetails' => ['required', 'array'],
            'contactChannels.*' => ['required', new Scalar()],
        ];
    }
}
