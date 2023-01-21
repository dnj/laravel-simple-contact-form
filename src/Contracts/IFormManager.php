<?php
namespace dnj\SimpleContactForm\Contracts;

/**
 * @phpstan-type ContactChannels array<string,string>
 * @phpstan-type AdditionalDetails array<string,scalar>
 */
interface IFormManager {
	public function getFormEntryById(int $entryId): ?IFormEntry;

	/**
	 * @param ContactChannels $contactBackChannels keys maybe 'email', 'cellphone' or any other string key.
	 * @param AdditionalDetails $additionalDetails
	 */
	public function store(string $userIP, array $contactChannels, string $message, array $additionalDetails): IFormEntry;

	/**
	 * @param array{userIP?:string,$contactChannels?:ContactChannels,message?:string,additionalDetails?:AdditionalDetails} $changes
	 */
	public function update(int $entryId, array $changes): IFormEntry;
	public function delete(int $entryId): void;
}
