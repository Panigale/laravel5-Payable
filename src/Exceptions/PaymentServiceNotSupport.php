<?php
/**
 * Author: Panigale
 * Date: 2018/2/26
 * Time: 下午2:44
 */

class PaymentServiceNotSupport extends InvalidArgumentException
{
    public function create($name)
    {
        return new static("Payment service {$name} does not support.");
    }
}