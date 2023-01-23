<?php

namespace dnj\SimpleContactForm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'userIp' => ['required', 'ipv4'],
            'contactChannels' => ['required', 'array'],
            'message' => ['required'],
            'additionalDetails' => ['required', 'array'],
        ];
    }
}
