<?php
/**
 * Author: Panigale
 * Date: 2017/11/19
 * Time: 下午12:36
 */

namespace Panigale\GoMyPay\Service\Entity;


use App\Events\PaymentFlows\CatchResultEvent;
use App\Http\Model\PayAccount;
use Event;
use Panigale\GoMyPay\Service\Entity\GoMyPayable;
use Sportlottery\Repositories\PaymentFlowRepository;

class WebATM extends GoMyPayable
{
    /**
     * 傳送交易資訊到 GoMyPay 後，會附帶交易資訊回到 callback url 的處理方法
     *
     * @return array
     */
    public function callback(array $response)
    {
        //當接收到從金流傳回的交易結束
        //如果狀態為 1 繳費成功
        //紀錄付款匯入的帳戶，補充點數
        //如果狀態為 0 繳費未完成
        $serverTradeId = $response['OrderID'];
        $tradeNo = $response['CustomerOrderID'];
        $payAccount = $response['e_payaccount'];
        $status = $response['Status'];
        $amount = $response['PayAmount'];
        $payDate = $response['PayDate'];

        return [
            'status'        => $status,
            'amount'        => $amount,
            'tradeNo'       => $tradeNo,
            'payDate'       => $payDate,
            'payAccount'    => $payAccount,
            'serverTradeId' => $serverTradeId
        ];
    }
}