# lutex.lt API v1 PHP SDK (not official)

## Getting started

In order to use this library you need to have at least PHP 5.5 version. You can use it for lutex.lt API.

There are two ways to use lutex PHP SDK:

##### Use [Composer](https://getcomposer.org/)

If you are not familiar with Composer, learn about it [here](https://getcomposer.org/doc/01-basic-usage.md).

Then you will need to run this simple command using CLI:

```
composer require weboxlt/lutex-api-v1-php-sdk
```

##### Manual

Download [this archive](https://github.com/WeBoxlt/lutex-api-v1-php-sdk/archive/master.zip), extract it and place its contents in your project. The next step is the same as using Composer, you will need to require `vendor/autoload.php` file in your index.php!

#### Usage example

```php
$smsClient = new eSMS\SmsClient('YOUR_USERNAME', 'YOUR_PASSWORD');
try {
    $sms = $smsClient->sms();
    $sms->setFrom('YOUR NAME');
    $sms->addRecipient('RECIPIENT_NUMBER_1');
    $sms->addRecipient('RECIPIENT_NUMBER_2');
    $sms->setMessage('Hello world!');
	
    $data = $sms->sendSimpleSMS();
    $sms->destroy();
} catch (\Exception $e) {
    print( $e->getMessage());
}
```

## Support and Feeback

In case you find any bugs, submit an issue directly here in GitHub.
