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

#### 1. Usage example to send SMS message

```php
$smsClient = new eSMS\SmsClient('YOUR_USERNAME', 'YOUR_PASSWORD');
try {
    $smsHandler = $smsClient->sms();
    $smsHandler->setFrom('YOUR NAME');
    $smsHandler->addRecipient('RECIPIENT_NUMBER_1');
    $smsHandler->addRecipient('RECIPIENT_NUMBER_2');
    $smsHandler->setMessage('Hello world!');
	
    $data = $smsHandler->sendSimpleSMS();
    $smsHandler->destroy();
} catch (\Exception $e) {
    print( $e->getMessage());
}
```

#### 2. Usage example to receive logs
``SMS logs are available for the last 48 hours!``
```php
$smsClient = new eSMS\SmsClient('YOUR_USERNAME', 'YOUR_PASSWORD');
try {
    $logsHandler = $smsClient->logs();
    $logsHandler->setLimit(10);
    $logsHandler->setMessageId('MESSAGE_ID');
    $logsHandler->setBulkId('BULK_ID');
    $logsHandler->setTo('PHONE_NUMBER');
    $logsHandler->setFrom('SENT_FROM');
    $logsHandler->setSentSince('2022-12-21');
    $logsHandler->setSentUntil('2022-12-25');
    $logsHandler->setGeneralStatus($logsHandler::STATUS_EXPIRED);
} catch (\Exception $e) {
    print( $e->getMessage());
}
```

## Support and Feeback

In case you find any bugs, submit an issue directly here in GitHub.
