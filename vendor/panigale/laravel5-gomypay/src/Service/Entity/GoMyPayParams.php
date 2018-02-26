<?php
/**
 * Author: Panigale
 * Date: 2017/11/20
 * Time: 下午10:20
 */

namespace Panigale\GoMyPay\Service\Entity;


trait GoMyPayParams
{
    public function getParams($response)
    {
        return [
            'paymentType'   => $response['OrderType'],
            'serverOrderId' => $response['OrderID'],
            'tradeNo'       => $response['CustomerOrderID'],
            'payAccount'    => $response['PayAccount'],
            'status'        => $response['Status'],
            'amount'        => $response['PayAmount'],
            'payDate'       => $response['PayDate']
        ];
    }
}