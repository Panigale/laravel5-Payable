## Laravel5-GoMyPay

Laravel5-GoMyPay is a laravel package for you to simple use GoMyPay payment system.

## Installation

```
composer require Panigale/laravel5-GoMyPay
```

In .env add, you can register on

```
GOMYPAY_STORECODE=your store code
GOMYPAY_TRADECODE=your trade code
GOMYPAY_CALLBACK=custom callback url
GOMYPAY_BACKEND=custom backend recevice url

```

Publish config.

```
php artisan vendor:publish --provider="Panigale\GoMyPay\GoMyPayServiceProvider"
```

## Basic Usage

### Create payment:

```
GoMyPay::payBy($paymentType)
       ->withAmount($amount)
       ->withUser($name ,$email ,$phone)
       ->create()
```

Then it well return an array include every fields for GoMyPay required. And you need to do is post this fields to GoMyPay. 


### Get payment result:

if payment type is entity. it should have options

$paymentType 1: Web-ATM 2: 虛擬帳號繳費 3: 超商條碼代收
```
$response = GoMyPay::done($paymentType = null)
```

GoMyPayTradeId
```
$response->serverTradeId
```

tradeNo 

```
$response->tradeNo
```

payAccount

```
$response->payAccount
```

amount
```
$response->amount
```

expiredDate
```
$response->expiredDate
```


if payment type is Web-ATM, you can get pay date.
```
$response->payDate
```



## License

The Laravel5-GoMyPay is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
