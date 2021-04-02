# SendsmsLaravel
[![Total Downloads][ico-downloads]][link-downloads]

## Installation

Via Composer

``` bash
$ composer require sendsms/sendsms
```

## Usage

If you do not have an account, you can register [here](https://hub.sendsms.ro/register).
If you need to see a full list of examples of our package, please go to our [API Documentation](https://www.sendsms.ro/api/).
To call a specifica function, include the namespace of that coresponding function.
The functions are placed under the corresponding namespace, as in the API documentation, with one exception, you can call the execute_multiple function from any namespace

| Namespace |
| --------- |
[SendSMS\API\AddressBook](https://www.sendsms.ro/api/#address-book) 
[SendSMS\API\Batch](https://www.sendsms.ro/api/#batch) 
[SendSMS\API\Blocklist](https://www.sendsms.ro/api/#blocklist) 
[SendSMS\API\HLR](https://www.sendsms.ro/api/#hlr) 
[SendSMS\API\Message](https://www.sendsms.ro/api/#message) 
[SendSMS\API\MNP](https://www.sendsms.ro/api/#mnp) 
[SendSMS\API\User](https://www.sendsms.ro/api/#user) 
[SendSMS\API\Other](https://www.sendsms.ro/api/#other) 
[SendSMS\API\ApiKey](https://www.sendsms.ro/api/#api-key-2) 

### How to send a message

Include the Message namespace at the beggining of your php file

``` php
use SendSMS\API\Message;
```

to call the function, run:

``` php
$api = new Message();
$api->setUsername('username');
$api->setPassword('password');
$api->message_send('40727363767', 'This is a message', '1898');
```

## Credits

- Radu Vasile Catalin

[ico-downloads]: https://img.shields.io/packagist/dt/sendsms/sendsms.svg?style=flat-square

[link-downloads]: https://packagist.org/packages/sendsms/sendsms