<?php
/**
 * Author: Panigale
 * Date: 2018/1/16
 * Time: 上午11:11
 */

namespace Panigale\GoMyPay;


class GoMyPay
{
    /**
     * create GoMyPay payment method.
     *
     * @param $paymentType
     * @return Service\GoMyPayEntity|Service\GoMyPayOnline
     */
    public static function payBy($paymentType)
    {
        return PaymentFactory::create($paymentType)->setPayBy($paymentType);
    }
}