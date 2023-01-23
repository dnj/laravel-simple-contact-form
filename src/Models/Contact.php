<?php

namespace dnj\LaravelSimpleContactForm;

use dnj\SimpleContactForm\Contracts\IFormEntry;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model implements IFormEntry
{
    protected $fillable = [
        'user_ip',
        'contact_channels',
        'additional_details',
        'message',
    ];

    protected $table = 'contacts';

    protected $casts = [
        'contact_channels' => 'array',
        'additional_details' => 'array',
    ];

    public function getID(): int
    {
        return $this->id;
    }

    public function getUserIP(): string
    {
        return $this->user_ip;
    }

    public function getContactChannels(): array
    {
        return $this->contact_channels;
    }

    public function getContactChannel(string $key): ?string
    {
        // TODO: Implement getContactChannel() method.
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getAdditionalDetails(): array
    {
        return $this->additional_details;
    }
}
