# Management Contact Form

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]][link-license]
[![Testing status][ico-workflow-test]][link-workflow-test]
[![Open API][ico-open-api]][link-open-api]

## Introduction

The  dnj/laravel-simple-contact-form Public package provides easy way to manage  contact of your app. The Package stores all data in the contacts table.
* Latest versions of PHP and PHPUnit and PHPCsFixer
* Best practices applied:
    * [`README.md`][link-readme] (badges included)
    * [`LICENSE`][link-license]
    * [`composer.json`][link-composer-json]
    * [`phpunit.xml`][link-phpunit]
    * [`.gitignore`][link-gitignore]
    * [`.php-cs-fixer.php`][link-phpcsfixer]
    * [`openAPI`][link-phpcsfixer]
* Some useful resources to start coding

## Installation
You can install the package via composer:
```bash
composer require dnj/laravel-simple-contact-form
```

The package will automatically register itself.


After this you can create the `contacts` table by running the migrations:

```bash
php artisan migrate
```

You can optionally publish the config file with:

```bash
php artisan vendor:publish --provider="dnj\SimpleContactForm\SimpleContactFormServiceProvider" --tag="config"
```
## Config file
```php
 [
    // If set True we will access to route api else we will not access
   'route_enable' => true,
   
    // To set the prefix for route api
   'route_prefix' => 'api',
]

```
## Usage
To use and management [CRUD][link-crud] contact package, the first thing you need to do is creating an object of then ContactManager class. which is accessed in the name space below.
```bash
use dnj\SimpleContactForm\ContactManager;

$contactManager = new ContactManager();
```

To create a contact, you can use the store function in the ContactManager class. This function includes parameters that include:

### params
1.  userIp :  It is to save the IP address of the client who wants to register a contact. To get the client's IP, we use the current `\request()->ip()` command.
2. contactChannels: It is for saving the type of contact. which is an array. This array contains a key. for example: `array('mobile') or array('email') or etc`
3. message: It is for saving contact text.
4. additionalDetails: This parameter is used to save more information. which is in the form of an array. for example: `array('priority' => 'high')`


### Create new contact:
```php
<?php
use dnj\SimpleContactForm\ContactManager;

$contactManager = new ContactManager();

$data = [
        'userIp' => '127.0.0.1',
        'contactChannels' => array ('email'),
        'message' => 'this is a first contact',
        'additionalDetails' => array('priority' => 'high')
];

$contactManager->store($data['userIp'], 
      $data['contactChannels'], 
      $data['message'], 
      $data['additionalDetails']
);
```
To update a contact, you can use the update function in the ContactManager class. This function includes two parameters that include

### params
1.  contactId :  ID of the contact we want to edit
2.  changes: This parameter, which is in the form of an array, contains the information that we want to edit a specific contact.

### update Contact:
```php
<?php
use dnj\SimpleContactForm\ContactManager;
use dnj\SimpleContactForm\Models\Contact;

$contactManager = new ContactManager();

$data = [
        'userIp' => '127.0.0.1',
        'contactChannels' => array ('email'),
        'message' => 'this is a first contact',
        'additionalDetails' => array('priority' => 'high')
];
$contact = Contact::query()
                      ->findOrFail(1);

$contactManager->update($contact->id, $data);
```
### Notes:
The return value type of the function is store and update of contact model type.

## Route Api

| name    | Method | route name         | path                    | Description                | 
|---------|--------|--------------------|-------------------------|----------------------------|
| Index   | GET    | `contacts.index`   | `/contacts/{contacts}`  | Display a specific contact |
| Store   | POST   | `contacts.store`   | `/contacts`             | Store a contact            |
| Update  | PUT    | `contacts.update`  | `/contacts/{contacts}`  | Update a specific contact  |
| Destroy | Delete | `contacts.destroy` | `/contacts/{contacts}`  | Destroy a specific contact |

### Notes:
1. In order to edit and delete a contact, the user needs to be `authenticated` beforehand, otherwise she will be faced with an error `unauthenticated`.

2. In the `config/contact.php` file, you can define a desired prefix for your route api by giving a `route_prefix` value. for example `route_prefix: 'api'`.

## How to use package API

A document in YAML format has been prepared for better familiarization and use of package web services. which is placed in the [`docs`][link-open-api] folder.

To use this file, you can import it on the [stoplight.io](https://stoplight.io) site and see all available web services.


## Contribution

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are greatly appreciated.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement". Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request


## Testing
```bash
./vendor/bin/phpunit 
```
## About
We'll try to maintain this project as simple as possible, but Pull Requests are welcomed!

## License

The MIT License (MIT). Please see [License File][link-license] for more information.

[ico-version]: https://img.shields.io/packagist/v/dnj/laravel-simple-contact-form.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/dnj/laravel-simple-contact-form.svg?style=flat-square
[ico-workflow-test]: https://github.com//dnj/laravel-simple-contact-form/actions/workflows/test.yaml/badge.svg
[ico-open-api]: https://img.shields.io/endpoint?color=blue&label=openAPI&logo=%22%236BA539%22&logoColor=blue&style=for-the-badge&url=https%3A%2F%2Fimg.shields.io%2Fendpoint%3Furl%3Dhttps%3A%2F%2Fgithub.com%2Fdnj%2Flaravel-account%2Fblob%2Fmaster%2FapiDocs%2Faccount.json

[link-open-api]: https://github.com/dnj/laravel-simple-contact-form/blob/master/apiDocs/account.json
[link-workflow-test]: https://github.com/dnj/laravel-simple-contact-form/actions/workflows/test.yaml
[link-packagist]: https://packagist.org/packages/dnj/laravel-simple-contact-form
[link-license]: https://github.com/dnj/laravel-simple-contact-form/blob/master/LICENSE
[link-downloads]: https://packagist.org/packages/dnj/laravel-simple-contact-form
[link-readme]: https://github.com/dnj/laravel-simple-contact-form/blob/master/README.md
[link-composer-json]: https://github.com/dnj/laravel-simple-contact-form/blob/master/composer.json
[link-phpunit]: https://github.com/dnj/laravel-simple-contact-form/blob/master/phpunit.xml
[link-gitignore]: https://github.com/dnj/laravel-simple-contact-form/blob/master/.gitignore
[link-phpcsfixer]: https://github.com/dnj/laravel-simple-contact-form/blob/master/.php-cs-fixer.php
[link-author]: https://github.com/dnj
[link-crud]: https://en.wikipedia.org/wiki/Create,_read,_update_and_delete
