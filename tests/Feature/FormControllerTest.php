<?php

namespace dnj\SimpleContactForm\Tests\Feature;

use dnj\SimpleContactForm\Models\FormEntry;
use dnj\SimpleContactForm\Tests\Models\User;
use dnj\SimpleContactForm\Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class FormControllerTest extends TestCase
{
    public function testIndex()
    {
        $entry = FormEntry::factory()
                          ->withContactChannels(['email'])
                          ->withAdditionalDetails(['key' => 'value'])
                          ->create();
        $this->getJson(route('contacts.index', ['contact' => $entry->getID()]))
             ->assertStatus(200)
             ->assertJson(function (AssertableJson $json) use ($entry) {
                 $json->where('data.user_ip', $entry->getUserIP());
                 $json->where('data.contact_channels', $entry->getContactChannels());
                 $json->where('data.message', $entry->getMessage());
                 $json->where('data.additional_details', $entry->getAdditionalDetails());
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
        $user = User::factory()->create();
        $entry = FormEntry::factory()
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
        $user = User::factory()->create();
        $entry = FormEntry::factory()
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
        $user = User::factory()->create();
        $entry = FormEntry::factory()->create();
        $url = route('contacts.destroy', ['formId' => $entry->getID()]);
    
        $this->deleteJson($url)->assertStatus(401);

        $this->actingAs($user);
        $this->deleteJson($url)->assertStatus(204);
        $this->assertModelMissing($entry);
    }
}
