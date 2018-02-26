<?php
/**
 * Author: Panigale
 * Date: 2018/2/25
 * Time: 下午11:34
 */

class PaymentMethodNotExist extends InvalidArgumentException
{
    /**
     * rules already exists exception.
     *
     * @param string $roleName
     * @return static
     */
    public static function create()
    {
        return new static("Payment Method Not Exist.");
    }
}