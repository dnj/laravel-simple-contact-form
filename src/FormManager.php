<?php

namespace dnj\SimpleContactForm;

use dnj\SimpleContactForm\Contracts\IFormManager;
use dnj\SimpleContactForm\Models\FormEntry;
use dnj\UserLogger\Contracts\ILogger;
use Illuminate\Support\Facades\DB;

class FormManager implements IFormManager
{
    public function __construct(protected ILogger $userLogger)
    {
    }

    public function getFormEntryById(int $entryId): FormEntry
    {
        return FormEntry::query()->findOrFail($entryId);
    }

    public function store(string $userIP, array $contactChannels, string $message, array $additionalDetails): FormEntry
    {
        $entry = new FormEntry();
        $entry->user_ip = $userIP;
        $entry->contact_channels = $contactChannels;
        $entry->message = $message;
        $entry->additional_details = $additionalDetails;
        $entry->save();

        return $entry;
    }

    public function update(int $entryId, array $changes, bool $userActivityLog = false): FormEntry
    {
        return DB::transaction(function () use ($entryId, $changes, $userActivityLog) {
            $entry = FormEntry::query()
                ->lockForUpdate()
                ->findOrFail($entryId);

            if (isset($changes['userIp'])) {
                $entry->user_ip = $changes['userIp'];
            }
            if (isset($changes['contactChannels'])) {
                $entry->contact_channels = $changes['contactChannels'];
            }
            if (isset($changes['message'])) {
                $entry->message = $changes['message'];
            }
            if (isset($changes['additionalDetails'])) {
                $entry->additional_details = $changes['additionalDetails'];
            }
            $changes = $entry->changesForLog();
            $entry->save();

            if ($userActivityLog) {
                $this->userLogger
                    ->withRequest(request())
                    ->performedOn($entry)
                    ->withProperties($changes)
                    ->log('updated');
            }

            return $entry;
        });
    }

    public function delete(int $entryId, bool $userActivityLog = false): void
    {
        $entry = FormEntry::query()
            ->lockForUpdate()
            ->findOrFail($entryId);
        $entry->delete();

        if ($userActivityLog) {
            $this->userLogger
                ->withRequest(request())
                ->performedOn($entry)
                ->log('deleted');
        }
    }
}
