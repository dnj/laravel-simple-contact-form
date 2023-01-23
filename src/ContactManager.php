<?php

namespace dnj\SimpleContactForm;

use dnj\SimpleContactForm\Contracts\IFormEntry;
use dnj\SimpleContactForm\Contracts\IFormManager;
use dnj\SimpleContactForm\Models\Contact;

class ContactManager implements IFormManager
{
    public function getFormEntryById(int $entryId): ?IFormEntry
    {
        return Contact::query()
                      ->findOrFail($entryId);
    }

    public function store(string $userIP, array $contactChannels, string $message, array $additionalDetails): IFormEntry
    {
        $contact = new Contact();
        $contact->user_ip = $userIP;
        $contact->contact_channels = $contactChannels;
        $contact->message = $message;
        $contact->additional_details = $additionalDetails;
        $contact->save();

        return $contact;
    }

    public function update(int $entryId, array $changes): IFormEntry
    {
        return \DB::transaction(function () use ($entryId, $changes) {
            $contact = $this->getFormEntryById($entryId);
            if (isset($changes['userIp'])) {
                $contact->user_ip = $changes['userIp'];
            }
            if (isset($changes['contactChannels'])) {
                $contact->contact_channels = $changes['contactChannels'];
            }
            if (isset($changes['message'])) {
                $contact->message = $changes['message'];
            }
            if (isset($changes['additionalDetails'])) {
                $contact->additional_details = $changes['additionalDetails'];
            }
            $contact->save();

            return $contact;
        });
    }

    public function delete(int $entryId): void
    {
        $contact = $this->getFormEntryById($entryId);
        if ($contact) {
            $contact->delete();
        }
    }
}
