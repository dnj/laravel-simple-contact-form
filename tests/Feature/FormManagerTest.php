<?php

namespace dnj\SimpleContactForm\Tests\Feature;

use dnj\SimpleContactForm\Models\FormEntry;
use dnj\SimpleContactForm\Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FormManagerTest extends TestCase
{
    public function tesGetFormEntryById(): void
    {
        $entry = FormEntry::factory()
            ->withAdditionalDetails(['key' => 'value'])
            ->create();
        $response = $this->getFormManager()->getFormEntryById($entry->getID());
        $this->assertSame($response->getID(), $entry->getID());
        $this->assertSame($response->getMessage(), $entry->getMessage());
        $this->assertSame($response->getContactChannels(), $entry->getContactChannels());
        $this->assertSame($response->getAdditionalDetails(), $entry->getAdditionalDetails());
        $this->assertSame($response->getUserIP(), $entry->getUserIP());

        $this->expectException(ModelNotFoundException::class);
        $this->getFormManager()->getFormEntryById(100);
    }

    public function testStore(): void
    {
        $data = [
            'userIP' => fake()->ipv4(),
            'contactChannels' => ['email' => fake()->email],
            'message' => fake()->text(400),
            'additionalDetails' => [
                'key' => 'value',
            ],
        ];

        $response = $this->getFormManager()->store($data['userIP'], $data['contactChannels'], $data['message'], $data['additionalDetails']);
        $this->assertSame($response->getUserIP(), $data['userIP']);
        $this->assertSame($response->getMessage(), $data['message']);
        $this->assertSame($response->getContactChannels(), $data['contactChannels']);
        $this->assertSame($response->getMessage(), $data['message']);
        $this->assertSame($response->getAdditionalDetails(), $data['additionalDetails']);
    }

    public function testUpdate()
    {
        $entry = FormEntry::factory()->create();
        $data = [
            'userIp' => fake()->ipv6(),
            'contactChannels' => ['mobile' => '+1234567890'],
            'message' => fake()->text(400),
            'additionalDetails' => [
                'key' => 'value2',
            ],
        ];
        $response = $this->getFormManager()->update($entry->getID(), $data);
        $this->assertSame($response->getUserIP(), $data['userIp']);
        $this->assertSame($response->getContactChannels(), $data['contactChannels']);
        $this->assertSame($response->getMessage(), $data['message']);
        $this->assertSame($response->getAdditionalDetails(), $data['additionalDetails']);

        $this->expectException(ModelNotFoundException::class);
        $this->getFormManager()->update(100, []);
    }

    public function testDetele()
    {
        $entry = FormEntry::factory()->create();
        $this->getFormManager()->delete($entry->getID());
        $this->assertModelMissing($entry);

        $this->expectException(ModelNotFoundException::class);
        $this->getFormManager()->delete($entry->getID());
    }
}
