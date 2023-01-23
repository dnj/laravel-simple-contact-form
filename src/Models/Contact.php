<?php

namespace dnj\SimpleContactForm\Models;

use dnj\SimpleContactForm\Contracts\IFormEntry;
use dnj\SimpleContactForm\Database\Factories\ContactFactory;
use dnj\UserLogger\Concerns\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model implements IFormEntry
{
    use HasFactory;
    use Loggable;
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

    protected static function newFactory()
    {
        return ContactFactory::new();
    }
}
