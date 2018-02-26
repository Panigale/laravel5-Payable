<?php
/**
 * Author: Panigale
 * Date: 2018/1/18
 * Time: 下午2:11
 */

namespace Panigale\GoMyPay\Service\Entity;



use Exception;

class EntityFactory
{
    /**
     * @param $paymentType
     * @return Barcode|VirtualAccount|WebATM
     * @throws Exception
     */
    public static function create($paymentType)
    {
        switch ($paymentType){
            case '1':
                return new WebATM();
                break;
            case '2':
                return new VirtualAccount();
                break;
            case '3':
                return new Barcode();
                break;
            default:
                throw new Exception('這不是一個有效的交易方式。');
                break;
        }
    }
}