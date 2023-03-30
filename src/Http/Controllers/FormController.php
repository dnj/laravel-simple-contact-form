<?php

namespace dnj\SimpleContactForm\Http\Controllers;

use dnj\SimpleContactForm\Contracts\IFormManager;
use dnj\SimpleContactForm\Http\Requests\FormStoreRequest;
use dnj\SimpleContactForm\Http\Requests\FormUpdateRequest;
use dnj\SimpleContactForm\Http\Resources\FormEntryResource;
use dnj\UserLogger\Contracts\ILogger;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function __construct(
        protected IFormManager $formManager,
        protected ILogger $userLogger
    ) {
    }

    public function show(int $formId)
    {
        $entry = $this->formManager->getFormEntryById($formId);

        return FormEntryResource::make($entry);
    }

    public function store(FormStoreRequest $request)
    {
        $data = $request->validated();
        $entry = $this->formManager->store(
            $request->ip(),
            $data['contactChannels'],
            $data['message'],
            $data['additionalDetails']
        );

        return FormEntryResource::make($entry);
    }

    public function update(int $formId, FormUpdateRequest $request)
    {
        $changes = [];
        foreach ($request->validated() as $key => $value) {
            $changes[Str::camel($key)] = $value;
        }
        $contact = $this->formManager->update($formId, $changes);

        return FormEntryResource::make($contact);
    }

    public function delete(int $formId)
    {
        $this->formManager->delete($formId);

        return response()->noContent();
    }
}
