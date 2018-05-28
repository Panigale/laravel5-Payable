<?php
namespace Panigale\Payment;

use Panigale\GoMyPay\GoMyPay;
use Panigale\Payment\Exceptions\PaymentServiceNotSupport;
use Panigale\Payment\Service\Sonet;

/**
 * Author: Panigale
 * Date: 2018/2/26
 * Time: 下午2:41
 */

class PaymentServiceFactory
{
    public static function create($service)
    {
        switch ($service){
            case 'GoMyPay':
                return new GoMyPay();
            case 'Sonet':
                return app(Sonet::class);
            default:
                throw new PaymentServiceNotSupport($service);
        }
    }
}