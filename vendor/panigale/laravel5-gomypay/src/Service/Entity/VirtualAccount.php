<?php
/**
 * Author: Panigale
 * Date: 2017/11/19
 * Time: 下午12:37
 */

namespace Panigale\GoMyPay\Service\Entity;


use App\Http\Model\PayAccount;
use App\Http\Model\Payment;
use DB;
use Sportlottery\Repositories\PaymentFlowRepository;

class VirtualAccount extends GoMyPayable
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
        $serverTradeId = $response['OrderID'];
        $tradeNo = $response['CustomerOrderID'];
        $payAccount = $response['e_payaccount'];

        //格式 Y-m
        $limitDate = $response['LimitDate'];

        return [
            'expiredDate'    => $limitDate,
            'serviceTradeId' => $serverTradeId,
            'payAccount'     => $payAccount,
            'tradeNo'        => $tradeNo
        ];
    }
}