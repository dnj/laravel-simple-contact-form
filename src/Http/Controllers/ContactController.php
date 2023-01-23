<?php

namespace dnj\SimpleContactForm\Http\Controllers;

use dnj\SimpleContactForm\ContactManager;
use dnj\SimpleContactForm\Http\Requests\ContactRequest;
use dnj\SimpleContactForm\Http\Requests\ContactStoreRequest;
use dnj\SimpleContactForm\Http\Requests\ContactUpdateRequest;
use dnj\SimpleContactForm\Http\Resources\ContactResource;
use dnj\SimpleContactForm\Models\Contact;
use dnj\UserLogger\Contracts\ILogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function __construct(protected ContactManager $contactManager, protected ILogger $userLogger)
    {
    }

    public function index(ContactRequest $request)
    {
        $contact = $this->contactManager->getFormEntryById($request->get('entryId'));

        return ContactResource::make($contact);
    }

    public function store(ContactStoreRequest $request)
    {
        $data = $request->validated();
        $contact = $this->contactManager->store($data['userIp'], $data['contactChannels'], $data['message'], $data['additionalDetails']);
        $changes = $contact->changesForLog();
        $this->userLogger->withRequest($request)
                         ->performedOn($contact)
                         ->withProperties($changes)
                         ->log('create');

        return ContactResource::make($contact);
    }

    public function update(Contact $contact, ContactUpdateRequest $request)
    {
        $data = $request->validated();
        $changes = [];
        foreach ($data as $key => $value) {
            $changes[Str::camel($key)] = $value;
        }
        $contact = $this->contactManager->update($contact->id, $changes);
        $changes = $contact->changesForLog();
        $this->userLogger->withRequest($request)
                         ->performedOn($contact)
                         ->withProperties($changes)
                         ->log('update');

        return ContactResource::make($contact);
    }

    public function delete(Contact $contact, Request $request)
    {
        $changes = $contact->toArray();
        $this->contactManager->delete($contact->id);
        $this->userLogger->withRequest($request)
                         ->performedOn($contact)
                         ->withProperties($changes)
                         ->log('delete');

        return response()->noContent();
    }
}
