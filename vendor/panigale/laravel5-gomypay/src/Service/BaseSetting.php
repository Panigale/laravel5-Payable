<?php
/**
 * Author: Panigale
 * Date: 2018/1/15
 * Time: 下午4:18
 */

namespace Panigale\GoMyPay\Service;


class BaseSetting
{
    /**
     * trade amount.
     *
     * @var int
     */
    protected $amount;

    /**
     * payment no.
     *
     * @var null
     */
    protected $paymentNo = null;

    /**
     * user name.
     *
     * @var null
     */
    protected $username = null;

    /**
     * user email
     *
     * @var null
     */
    protected $email = null;

    /**
     * user phone
     *
     * @var null
     */
    protected $phone = null;

    /**
     * your gomypay trade code.
     *
     * @var
     */
    protected $tradeCode;

    /**
     * your gomypay store code
     *
     * @var
     */
    protected $storeCode;

    /**
     * return url
     *
     * @var
     */
    protected $callbackUrl;

    /**
     * backend notification url
     *
     * @var
     */
    protected $backendUrl;

    /**
     * which pay
     *
     * @var
     */
    protected $payBy;

    /**
     * load config
     */
    protected function loadConfig()
    {
        $this->storeCode = config('gomypay.storeCode') ?: env('GOMYPAY_STORECODE');
        $this->tradeCode = config('gomypay.tradeCode') ?: env('GOMYPAY_TRADECODE');
        $this->callbackUrl = config('gomypay.callbackUrl') ?: env('GOMYPAY_CALLBACK');
        $this->backendUrl = config('gomypay.backendUrl') ?: env('GOMYPAY_BACKEND');
    }

    /**
     * set trade code.
     *
     * @param string $tradeCode
     * @return $this
     */
    public function setTradeCode(string $tradeCode)
    {
        $this->tradeCode = $tradeCode;

        return $this;
    }

    /**
     * set store code.
     *
     * @param string $storeCode
     * @return $this
     */
    public function setStoreCode(string $storeCode)
    {
        $this->storeCode = $storeCode;

        return $this;
    }

    /**
     * get gomypay do action url.
     *
     * @return string
     */
    public function getActionUrl()
    {
        return "https://gomypay.asia/Shopping/creditpay.asp";
    }

    /**
     * get gomypay confirm payment status url.
     *
     * @return string
     */
    public function getConfirmUrl()
    {
        return "https://gomypay.asia/Shopping/creditpay_query.asp";
    }

    /**
     * set trade amount.
     *
     * @param int $amount
     * @return $this
     */
    public function withAmount(int $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * set user
     *
     * @param string $name
     * @param $email
     * @param $phone
     * @return $this
     */
    public function withUser($name, $email, $phone)
    {
        $this->setUserName($name)
             ->setEmail($email)
             ->setPhoneNumber($phone);

        return $this;
    }

    /**
     * set user name.
     *
     * @param string $name
     * @return $this
     */
    public function setUserName(string $name)
    {
        $this->username = $name;

        return $this;
    }

    /**
     * set user email.
     *
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * set payment no.
     *
     * @param $uuid
     * @return $this
     */
    public function withPaymentNo($uuid)
    {
        $this->paymentNo = $uuid;

        return $this;
    }

    /**
     * set user phone.
     *
     * @param $phone
     * @return $this
     */
    public function setPhoneNumber($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * set payment type
     *
     * @param $type
     * @return $this
     */
    public function setPayBy($type)
    {
        $this->payBy = $type;

        return $this;
    }
}