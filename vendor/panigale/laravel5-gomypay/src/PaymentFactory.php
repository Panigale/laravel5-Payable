<?php
/**
 * Author: Panigale
 * Date: 2018/1/15
 * Time: 下午9:20
 */

namespace Panigale\GoMyPay;


use Panigale\GoMyPay\Service\GoMyPayOnline;
use Panigale\GoMyPay\Service\GoMyPayEntity;

class PaymentFactory
{
    public static function create(string $paymentType)
    {
        if($paymentType === 'creditcard')
            return new GoMyPayOnline();
        else
            return new GoMyPayEntity();
    }
}