<?php
namespace Panigale\Payment;

use Panigale\GoMyPay\GoMyPay;
use Panigale\GoMyPay\Service\GoMyPayEntity;
use Panigale\Payment\Exceptions\PaymentServiceNotSupport;
use Panigale\Payment\Service\AllPay;
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
            case 'GoMyPayEntity':
                return new GoMyPayEntity();
            case 'AllPay':
                return new AllPay();
            default:
                throw new PaymentServiceNotSupport($service);
        }
    }
}