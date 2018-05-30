<?php
/**
 * Author: Panigale
 * Date: 2018/5/28
 * Time: 下午1:19
 */

namespace Panigale\Payment\Service;


use Exception;
use Illuminate\Http\Request;
use Panigale\Payment\Contract\PaymentContract;
use Panigale\Payment\Sdk\Sonet\Somp;

class Sonet extends BasePayment implements PaymentContract
{
    /**
     * 交易傳送方式
     * @var string
     */
    private $method = 'post';

    /**
     * 正式環境 So-net Micropayment的伺服器網址
     * @var string
     */
    private $apiHost = "https://mpapi.so-net.net.tw/";

    /**
     * 小額付款測試環境
     * @var string
     */
    private $devApiHost = "http://mpapi-dev.so-net.net.tw/";

    /**
     * So-net Micropayment的付款中心條款頁面，通常不用更改
     */
    private $devActionUrl = 'http://mpay-dev.so-net.net.tw/paymentRule.php';     //dev

    private $actionUrl = 'http://mpay.so-net.net.tw/paymentRule.php'; //product

    const mpId = 'CITI';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 交易前檢查
     *
     * @param $paymentFlowRepository
     * @param $tradeType
     * @throws Exception
     */
    public function redirect($user, $amount, $no, $creditCard)
    {
        $appName = config('app.name');
        $icpId = $this->icpId();
        $icpProdId = $this->icpProdId();
        $userId = $user->id;

        $requiredField = [
            'icpId'       => $icpId,
            'icpOrderId'  => $no,
            'icpProdId'   => $icpProdId,
            'mpId'        => $this->mpId(), //付款方式
            'memo'        => $appName,
            'icpUserId'   => $userId,
            'icpProdDesc' => $appName . '點數',
            'price'       => $amount,
            'returnUrl'   => $this->callbackUrl(),
            'doAction'    => 'authOrderCredit',
            'actionUrl'   => $this->actionUrl()
        ];

        $authResponse = $this->getAuthCode($requiredField);

        if (isset($authResponse['authCode'])) {
            $authCode = $authResponse['authCode'];
            $requiredField['authCode'] = $authCode;

            return $requiredField;
        } else {
            throw new Exception('取得授權失敗。');
        }
    }

    /**
     * So-net 的 api url
     *
     * @return string
     */
    private function apiUrl()
    {
        if ($this->method == "post") {
            $apiUrl = $this->apiHost() . "microPaymentPost.php";
        } else if ($this->method == "soap") {
            $apiUrl = $this->apiHost() . "xml/microPaymentServiceProdDev.wsdl";
        } else {
            die();
        }

        return $apiUrl;
    }


    /**
     * 驗證交易是否正確
     *
     * @param $orderInfo
     * @return string
     */
    public function confirmOrder($resultInfo)
    {
        $somp = app()->make(Somp::class);

        $data = [
            'icpId'        => $resultInfo->icpId,
            'icpOrderId'   => $resultInfo->icpOrderId,
            'sonetOrderNo' => $resultInfo->sonetOrderNo,
            'doAction'     => 'confirmOrder'
        ];

        $finalAry = $somp->doRequest($this->method, $data, $this->apiUrl());

        return isset($finalAry['resultCode']) ? $finalAry['resultCode'] : false;
    }

    /**
     * @param $data
     * @return array
     */
    public function getAuthCode($data): array
    {
        $somp = app()->make(Somp::class);
        $finalAry = $somp->doRequest($this->method, $data, $this->apiUrl());
        $authResult = [];

        $rtMsg = (string)$finalAry['resultCode'];

        if ($rtMsg == "00000") {
            unset($data['doAction']);
            $authResult['authCode'] = $finalAry['authCode'];

        } else {
            $authResult['resultCode'] = $finalAry['resultCode'];
            $authResult['resultMesg'] = $finalAry['resultMesg'];
        }

        return $authResult;
    }

    /**
     * 擷取交易結果
     *
     * @param $paymentFlowRepository
     * @param $pointRepository
     * @return mixed
     */
    public function done()
    {
        $amount = $this->request->price;
        $resultMsg = $this->request->resultMesg;
        $authCode = $this->request->authCode;
        $icpId = $this->request->icpId;
        $sonetOrderNo = $this->request->sonetOrderNo;
        $icpOrderId = $this->request->icpOrderId;
        $resultCode = $this->request->resultCode;
        $order = $icpOrderId;

        if (is_null($order))
            return view('payment.authFailed');

        //回傳結果檢查需要的參數
        $resultInfo = (object)[
            'icpId'        => $icpId,
            'icpOrderId'   => $icpOrderId,
            'sonetOrderNo' => $sonetOrderNo
        ];

        $serviceResult = $this->confirmOrder($resultInfo) === '00000';

        return (object)[
            'result'        => (boolean)$serviceResult,
            'serverTradeId' => $sonetOrderNo,
            'amount'        => $amount,
            'tradeNo'       => $icpOrderId,
            'response'      => $resultMsg,
            'authCode'      => $authCode
        ];
    }

    public function errorMessage($resultMsg)
    {
        switch ($resultMsg) {
            case '信用卡發卡銀行無3D認證，無法使用!':
                return '信用卡發卡銀行無3D認證';
            case '信用卡非國內卡，無法使用!':
                return '信用卡非國內卡';
            case '使用者按下取消鈕取消訂單':
                return '您取消訂單';
            case '系統錯誤':
                return '連線中斷';
            default:
                return '銀行授權失敗';
        }
    }

    /**
     * @return mixed
     */
    private function isMicroPayment()
    {
        return !is_null($this->request->mircoPayment);
    }

    /**
     * @return mixed|string
     */
    private function mpId()
    {
        return $this->isMicroPayment() ? $this->request->mircoPayment : static::mpId;
    }

    private function icpId()
    {
        return env('SONET_ICPID');
    }

    private function icpProdId()
    {
        return env('SONET_ICPPRODID');
    }

    protected function apiHost()
    {
        return env('SONET_DEBUG') ? $this->devApiHost : $this->apiHost;
    }

    protected function actionUrl()
    {
        return env('SONET_DEBUG') ? $this->devActionUrl : $this->actionUrl;
    }

    private function callbackUrl()
    {
        return env('SONET_CALLBACKURL');
    }
}