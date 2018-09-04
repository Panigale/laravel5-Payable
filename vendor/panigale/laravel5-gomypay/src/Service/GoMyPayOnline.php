<?php
/**
 * Author: Panigale
 * Date: 2018/1/15
 * Time: 下午4:01
 */

namespace Panigale\GoMyPay\Service;


use Illuminate\Http\Request;

class GoMyPayOnline extends BaseSetting implements GoMyPayContract
{
    /**
     * backend notification url.
     *
     * @var
     */
    protected $backendUrl;

    /**
     * credit card number.
     *
     * @var null
     */
    private $cardNumber = null;

    /**
     * credit card expiry.
     *
     * @var null
     */
    private $cardExpiry = null;

    /**
     * credit card cvv.
     *
     * @var null
     */
    private $cardCVV = null;

    /**
     * 如果有附帶卡號的話，需將 e_mode 設定為 9
     *
     * @var null
     */
    private $e_mode = null;

    /**
     * GoMyPayOnline constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * init
     */
    private function init()
    {
        $this->loadConfig();
    }

    /**
     * 取回交易結果
     *
     * @return array|mixed
     */
    public function done($paymentType = null)
    {
        $request = app()->make(Request::class);
        $response = $request->all();
        $status = $response['str_ok'];
        $goMyPayNo = $response['str_no'];
        $amount = (int)$response['e_money'];
        $orderNo = $response['e_orderno'];
        $bankResponse = $response['bstr_msg'];

        return (object)[
            'result'        => (boolean)$status,
            'serverTradeId' => $goMyPayNo,
            'amount'        => $amount,
            'tradeNo'       => $orderNo,
            'response'      => $bankResponse
        ];
    }

    /**
     * create payment.
     *
     * @return mixed
     */
    public function create()
    {
        $fields = [
            'e_orderno'     => $this->paymentNo ?: uniqid(),
            'e_url'         => $this->callbackUrl,
            'e_no'          => $this->storeCode,
            'e_storename'   => config('gomypay.storeName'),
            'e_money'       => $this->amount,
            'str_check'     => $this->getCheckValue($this->paymentNo, $this->storeCode, $this->amount, $this->tradeCode),
            'e_name'        => $this->username,
            'e_telm'        => $this->phone,
            'e_email'       => $this->email,
            'e_info'        => config('gomypay.title'),
            'e_backend_url' => $this->backendUrl
        ];

        /**
         * 如果開啟 e_mode，就需要附帶卡號資訊
         */
        if (!is_null($this->e_mode)) {
            $fields['e_mode'] = $this->e_mode;
            $fields['e_cardno'] = $this->getHashCardNo();
        }

        return $fields;
    }

    /**
     * 組合交易檢查碼
     *
     * @param $tradeCode
     * @param $tradeNo
     * @param $storeCode
     * @param $amount
     * @return string
     */
    private function getCheckValue($tradeCode, $orderNo, $storeCode, $amount)
    {
        return md5($orderNo . $storeCode . $amount . $tradeCode);
    }

    /**
     * base64編碼信用卡資訊
     *
     * @param string $cvv
     * @param string $expiry
     * @param string $cardNo
     * @return string
     */
    private function getHashCardNo()
    {
        return base64_encode($this->cardCVV . $this->cardExpiry . $this->cardNumber);
    }

    /**
     * set trade credit information.
     *
     * @param $cardNumber
     * @param $expiry
     * @param $cvv
     * @return $this
     */
    public function withCard($cardNumber, $expiry, $cvv)
    {
        $this->setCardNumber($cardNumber)
            ->setCardExpiry($expiry)
            ->setCardCVV($cvv);

        $this->enabledEMode();

        return $this;
    }

    /**
     * set credit card number
     *
     * @param $cardNumber
     * @return $this
     */
    private function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * set credit card expiry.
     *
     * @param $expiry
     * @return $this
     */
    private function setCardExpiry($expiry)
    {
        $this->cardExpiry = $expiry;

        return $this;
    }

    /**
     * set credit card cvv.
     *
     * @param $cvv
     * @return $this
     */
    private function setCardCVV($cvv)
    {
        $this->cardCVV = $cvv;

        return $this;
    }

    /**
     * 開啟 e_mode 模式
     *
     * @return $this
     */
    private function enabledEMode()
    {
        $this->e_mode = 9;

        return $this;
    }
}