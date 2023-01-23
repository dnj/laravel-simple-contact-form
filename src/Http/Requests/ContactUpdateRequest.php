<?php

namespace dnj\SimpleContactForm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'userIp' => ['sometimes', 'required'],
            'contactChannels' => ['sometimes', 'required', 'array'],
            'message' => ['sometimes', 'required'],
            'additionalDetails' => ['sometimes', 'required', 'array'],
        ];
    }
}
