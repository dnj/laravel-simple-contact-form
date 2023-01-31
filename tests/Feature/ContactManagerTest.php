<?php

namespace dnj\SimpleContactForm\Test\Feature;

use dnj\SimpleContactForm\Models\Contact;
use dnj\SimpleContactForm\Test\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactManagerTest extends TestCase
{
    public function tesGetFormEntryById()
    {
        $contact = Contact::factory()->withContactChannels(['email'])
            ->withAdditionalDetails(['key' => 'value'])
            ->create();
        $response = $this->getContactManager()->getFormEntryById($contact->getID());
        $this->assertSame($response->getID(), $contact->getID());
        $this->assertSame($response->getMessage(), $contact->getMessage());
        $this->assertSame($response->getContactChannels(), $contact->getContactChannels());
        $this->assertSame($response->getAdditionalDetails(), $contact->getAdditionalDetails());
        $this->assertSame($response->getUserIP(), $contact->getUserIP());

        $this->expectException(ModelNotFoundException::class);
        $this->getContactManager()->getFormEntryById(100);
    }

    public function testStore()
    {
        $data = [
            'userIP' => '127.0.0.1',
            'contactChannels' => ['email'],
            'message' => 'this is a test',
            'additionalDetails' => [
                'key' => 'value',
            ],
        ];

        $response = $this->getContactManager()->store($data['userIP'], $data['contactChannels'], $data['message'], $data['additionalDetails']);
        $this->assertSame($response->getUserIP(), $data['userIP']);
        $this->assertSame($response->getMessage(), $data['message']);
        $this->assertSame($response->getContactChannels(), $data['contactChannels']);
        $this->assertSame($response->getMessage(), $data['message']);
        $this->assertSame($response->getAdditionalDetails(), $data['additionalDetails']);
    }

    public function testUpdate()
    {
        $contact = Contact::factory()->withContactChannels(['email'])
                          ->withAdditionalDetails(['key' => 'value'])
                          ->create();
        $data = [
            'userIp' => '127.0.0.0',
            'contactChannels' => ['mobile'],
            'message' => 'this is a test',
            'additionalDetails' => [
                'key' => 'value',
            ],
        ];
        $response = $this->getContactManager()->update($contact->getID(), $data);
        $this->assertSame($response->getUserIP(), $data['userIp']);
        $this->assertSame($response->getContactChannels(), $data['contactChannels']);
        $this->assertSame($response->getMessage(), $data['message']);
        $this->assertSame($response->getAdditionalDetails(), $data['additionalDetails']);
        $this->expectException(ModelNotFoundException::class);
        $this->getContactManager()->update(100, $data);
    }

    public function testDetele()
    {
        $contact = Contact::factory()->withContactChannels(['email'])
                          ->withAdditionalDetails(['key' => 'value'])
                          ->create();
        $this->getContactManager()->delete($contact->id);
        $this->assertTrue(true);
        $this->expectException(ModelNotFoundException::class);
        $this->getContactManager()->delete(100);
    }
}
