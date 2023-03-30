<?php

namespace dnj\SimpleContactForm\Database\Factories;

use dnj\SimpleContactForm\Models\FormEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class FormEntryFactory extends Factory
{
    protected $model = FormEntry::class;

    public function definition()
    {
        return [
            'user_ip' => fake()->ipv4,
            'contact_channels' => [
                'email' => fake()->email,
            ],
            'additional_details' => null,
            'message' => fake()->text(400),
        ];
    }

    public function withUserIp(string $ip)
    {
        return $this->state(fn () => [
            'user_ip' => $ip,
        ]);
    }

    /**
     * @param array<string,string> $contactChannels
     */
    public function withContactChannels(array $contactChannels)
    {
        return $this->state(fn () => [
            'contact_channels' => $contactChannels,
        ]);
    }

    /**
     * @param array<string,scalar> $additionalDetails
     */
    public function withAdditionalDetails(array $additionalDetails)
    {
        return $this->state(fn () => [
            'additional_details' => $additionalDetails,
        ]);
    }

    public function withMessage(string $message)
    {
        return $this->state(fn () => [
            'message' => $message,
        ]);
    }
}
