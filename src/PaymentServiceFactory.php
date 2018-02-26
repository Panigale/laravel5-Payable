<?php
namespace Panigale\Payment;

use Panigale\GoMyPay\GoMyPay;
use Panigale\Payment\Exceptions\PaymentServiceNotSupport;

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
            default:
                throw new PaymentServiceNotSupport($service);
        }
    }
}