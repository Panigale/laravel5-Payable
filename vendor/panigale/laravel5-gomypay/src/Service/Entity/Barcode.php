<?php
/**
 * Author: Panigale
 * Date: 2017/11/19
 * Time: 下午12:37
 */

namespace Panigale\GoMyPay\Service\Entity;


use App\Http\Model\PayBarcode;
use DB;
use Sportlottery\Repositories\PaymentFlowRepository;

class Barcode extends GoMyPayable
{

    /**
     * 傳送交易資訊到 GoMyPay 後，會附帶交易資訊回到 callback url 的處理方法
     *
     * @return array
     */
    public function callback(array $response)
    {
        //當接收到從金流傳回的交易資訊
        //紀錄交易資訊
        //產生條碼 view
        $serverTradeNo = $response['OrderID'];
        $tradeNo = $response['CustomerOrderID'];
        $payAccount = $response['e_payaccount'];

        //格式 Y-m
        $limitDate = $response['LimitDate'];
        $code1 = $response['code1'];
        $code2 = $response['code2'];
        $code3 = $response['code3'];

        return [
            'code1'         => $response['code1'],
            'code2'         => $response['code2'],
            'code3'         => $response['code3'],
            'code'          => $code1 . '-' . $code2 . '-' . $code3,
            'expiredDate'   => $limitDate,
            'serverTradeId' => $serverTradeNo,
            'tradeNo'       => $tradeNo,
            'payAccount'    => $payAccount
        ];
    }
}
