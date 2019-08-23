<?php
/**
 * Author: Panigale
 * Date: 2019-08-22
 * Time: 11:40
 */


namespace Panigale\Payment\Service;

include __DIR__.'/../Sdk/AllPay/Somp.php';

use Panigale\Payment\Contract\PaymentContract;
use AllInOne;

class AllPay extends BasePayment implements PaymentContract
{
    //正式網址
    protected $actionUrl = 'https://payment.ecpay.com.tw/Cashier/AioCheckOut/V2';
    //測試網址
//    protected $actionUrl = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V2';
    protected $returnUrl = 'https://www.airsports.com.tw/shop/AllPay/auth';

    public function redirect($user, $amount, $no, $paymentType ,$creditCard)
    {
        $allPay = new AllInOne();
        //服務參數
        $allPay->ServiceURL  = $this->actionUrl;
        $allPay->HashKey     = $this->hashKey();
        $allPay->HashIV      = $this->hashIV();
        $allPay->MerchantID  = $this->merchantId();
        //基本參數(請依系統規劃自行調整)
        $allPay->Send['ReturnURL']         = $this->callbackUrl();    //付款完成通知回傳的網址
        $allPay->Send['MerchantTradeNo']   = $no;            //訂單編號
        $allPay->Send['MerchantTradeDate'] = date('Y/m/d H:i:s'); //交易時間
        $allPay->Send['TotalAmount']       = $amount;             //交易金額
        $allPay->Send['TradeDesc']         = '點數儲值'; //交易描述
        $allPay->Send['ChoosePayment']     = $this->paymentMethod($paymentType);            //付款方式:ATM
        $allPay->Send['PaymentInfoURL']    = $this->callbackUrl();
        //訂單的商品資料
        array_push($allPay->Send['Items'], [
            'Name' => $this->title(),
            'Price' => (int)$amount,
            'Currency' => "元",
            'Quantity' => (int) "1" ,
            'URL' => 'none'
        ]);

        return $allPay->CheckOut();
    }

    public function done()
    {
        $tradeNo = $this->request->MerchantTradeNo;
        $resultCode = $this->request->RtnCode;
        $resultMsg = $this->request->RtnMsg;
        $amount = $this->request->TradeAmt;

        if($this->confirmOrder())
            return (object)[
                'result'        => $resultCode,
                'serverTradeId' => $this->request->TradeNo,
                'amount'        => $amount,
                'tradeNo'       => $tradeNo,
                'response'      => $resultMsg
            ];

        return false;
    }

    public function confirmOrder($resultInfo = null)
    {
        $oPayment = new AllInOne();
        /* 服務參數 */
        $oPayment->HashKey = $this->hashKey();
        $oPayment->HashIV = $this->hashIV();
        $oPayment->MerchantID = $this->merchantID;
        /* 取得回傳參數 */
        $feedback = $oPayment->CheckOutFeedback();
        return count($feedback) > 0;
    }

    private function paymentMethod($tradeType)
    {
        switch ($tradeType){
            case 'stores-code':
                return 'CVS';
            case 'Web-ATM':
                return 'ATM';
            case 'barcode':
                return 'BARCODE';
        }
    }

    private function title()
    {
        return config('payment.allPay.title');
    }

    private function hashKey()
    {
        return config('payment.allPay.hashKay');
    }

    private function hashIV()
    {
        return config('payment.allPay.hashIV');
    }

    private function domain()
    {
        return config('app.url');
    }

    private function callbackUrl()
    {
        return config('payment.allPay.callbackUrl');
    }

    private function merchantId()
    {
        return config('payment.allPay.merchantId');
    }
}