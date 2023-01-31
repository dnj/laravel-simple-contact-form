<?php

namespace dnj\SimpleContactForm\Test\Feature;

use dnj\SimpleContactForm\Models\Contact;
use dnj\SimpleContactForm\Test\Models\User;
use dnj\SimpleContactForm\Test\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class ContactControllerTest extends TestCase
{

    public function testIndex()
    {
        $contact = Contact::factory()
                          ->withContactChannels(['email'])
                          ->withAdditionalDetails(['key' => 'value'])
                          ->create();
        $this->getJson(route('contacts.index', ['contact' => $contact->getID()]))
             ->assertStatus(200)
             ->assertJson(function (AssertableJson $json) use ($contact) {
                 $json->where('data.user_ip', $contact->getUserIP());
                 $json->where('data.contact_channels', $contact->getContactChannels());
                 $json->where('data.message', $contact->getMessage());
                 $json->where('data.additional_details', $contact->getAdditionalDetails());
             });
    }

    public function testStoreValidation()
    {
        $data = [
            'userIp' => null,
            'contactChannels' => null,
            'message' => null,
            'additionalDetails' => null,
        ];
        $this->postJson(route('contacts.store'), $data)
             ->assertStatus(422)
             ->assertJson(fn (AssertableJson $json) => $json->hasAll([
                                                                          'errors.userIp',
                                                                          'errors.contactChannels',
                                                                          'errors.message',
                                                                          'errors.additionalDetails',
                                                                      ])
                                                             ->etc());
    }

    public function testStore()
    {
        $data = [
            'userIp' => '127.0.0.1',
            'contactChannels' => ['email'],
            'message' => 'this is a test',
            'additionalDetails' => [
                'key' => 'value',
            ],
        ];
        $this->postJson(route('contacts.store'), $data)
             ->assertStatus(201)
             ->assertJson(function (AssertableJson $json) use ($data) {
                 $json->where('data.user_ip', $data['userIp']);
                 $json->where('data.contact_channels', $data['contactChannels']);
                 $json->where('data.message', $data['message']);
                 $json->where('data.additional_details', $data['additionalDetails']);
             });
    }

    public function testUpdateValidation()
    {
        $user = User::factory()
                    ->create();
        $contact = Contact::factory()
                          ->withContactChannels(['email'])
                          ->withAdditionalDetails(['key' => 'value'])
                          ->create();
        $data = [
            'userIp' => null,
            'contactChannels' => null,
            'message' => null,
            'additionalDetails' => null,
        ];
        $this->putJson(route('contacts.update', compact('contact')), $data)
             ->assertStatus(401);
        $this->actingAs($user);
        $this->putJson(route('contacts.update', compact('contact')), $data)
             ->assertStatus(422)
             ->assertJson(fn (AssertableJson $json) => $json->hasAll([
                                                                          'errors.userIp',
                                                                          'errors.contactChannels',
                                                                          'errors.message',
                                                                          'errors.additionalDetails',
                                                                      ])
                                                             ->etc());
    }

    public function testUpdate()
    {
        $user = User::factory()
                    ->create();
        $contact = Contact::factory()
                          ->withContactChannels(['email'])
                          ->withAdditionalDetails(['key' => 'value'])
                          ->create();
        $data = [
            'userIp' => '127.0.0.1',
            'contactChannels' => ['email'],
            'message' => 'this is a test',
            'additionalDetails' => [
                'key' => 'value',
            ],
        ];
        $this->putJson(route('contacts.update', compact('contact')), $data)
             ->assertStatus(401);
        $this->actingAs($user);
        $this->putJson(route('contacts.update', compact('contact')), $data)
             ->assertStatus(200)
             ->assertJson(function (AssertableJson $json) use ($data) {
                 $json->where('data.user_ip', $data['userIp']);
                 $json->where('data.contact_channels', $data['contactChannels']);
                 $json->where('data.message', $data['message']);
                 $json->where('data.additional_details', $data['additionalDetails']);
             });
    }

    public function testDelete()
    {
        $user = User::factory()
                    ->create();
        $contact = Contact::factory()
                          ->withContactChannels(['email'])
                          ->withAdditionalDetails(['key' => 'value'])
                          ->create();
        $this->deleteJson(route('contacts.destroy', compact('contact')))
             ->assertStatus(401);
        $this->actingAs($user);
        $this->deleteJson(route('contacts.destroy', compact('contact')))
             ->assertStatus(204);
    }
}
