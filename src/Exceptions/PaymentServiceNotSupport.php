<?php
/**
 * Author: Panigale
 * Date: 2018/2/26
 * Time: 下午2:44
 */

namespace Panigale\Payment\Exceptions;

use InvalidArgumentException;

class PaymentServiceNotSupport extends InvalidArgumentException
{
    public static function create($name)
    {
        return new static("Payment service {$name} does not support.");
    }
}