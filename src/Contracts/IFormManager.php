<?php

namespace dnj\SimpleContactForm\Contracts;

interface IFormManager
{
    public function getFormEntryById(int $entryId): IFormEntry;

    /**
     * @param array<string,string> $contactBackChannels keys maybe 'email', 'cellphone' or any other string key
     * @param array<string,scalar> $additionalDetails
     */
    public function store(string $userIP, array $contactChannels, string $message, array $additionalDetails): IFormEntry;

    /**
     * @param array{userIP?:string,$contactChannels?:ContactChannels,message?:string,additionalDetails?:AdditionalDetails} $changes
     */
    public function update(int $entryId, array $changes, bool $userActivityLog = false): IFormEntry;

    public function delete(int $entryId, bool $userActivityLog = false): void;
}
