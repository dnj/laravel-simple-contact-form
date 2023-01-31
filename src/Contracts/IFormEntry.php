<?php

namespace dnj\SimpleContactForm\Contracts;

/**
 * @phpstan-import-type ContactChannels from IFormManager
 * @phpstan-import-type AdditionalDetails from IFormManager
 */
interface IFormEntry
{
    public function getID(): int;

    public function getUserIP(): string;

    /**
     * @return ContactChannels $contactBackChannels keys maybe 'email', 'cellphone' or any other string key
     */
    public function getContactChannels(): array;

    public function getContactChannel(string $key): ?string;

    public function getMessage(): string;

    /**
     * @return AdditionalDetails
     */
    public function getAdditionalDetails(): array;
}
