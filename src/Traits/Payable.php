<?php
/**
 * Author: Panigale
 * Date: 2018/2/23
 * Time: 下午3:10
 */
namespace Panigale\Payment\Traits;

use Panigale\Payment\Models\Payment;
use Panigale\Payment\PaymentServiceFactory;

trait Payable
{
    use CreatePayment,RedirectPayment;

    protected $paymentMethod = null;

    protected $paymentProvider = null;

    protected $paymentServiceProvider;

    protected $card = [];

    protected $paymentUser = null;

    /**
     * @var
     */
    protected $amount;

    /**
     * @var
     */
    protected $payable;




    /**
     * @return mixed
     */
    public function payments()
    {
        return $this->morphMany(Payment::class ,'payable');
    }

    /**
     * 支付商品
     *
     * @param $payable
     * @param int $amount
     * @return $this
     */
    public function pay($payable ,int $amount)
    {
        $this->amount = $amount;
        $this->payable = $payable;

        return $this;
    }

    /**
     *
     *
     * @return mixed
     */
    public function payment()
    {
        return $this->order;
    }

    /**
     *
     *
     * @param string $method
     * @return $this
     */
    public function payBy(string $method)
    {
        $this->paymentMethod = $method;

        return $this;
    }

    /**
     * set number
     *
     * @param $no
     * @return $this
     */
    public function setUUid($no)
    {
        $this->uuid = $no;
        
        return $this;
    }

    /**
     * set description
     *
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * 選擇付款方式要使用的供應商
     *
     * @param $provider
     * @return $this
     */
    public function formProvider($provider)
    {
        $this->paymentProvider = $provider;

        return $this;
    }

    /**
     * 部分金流可以接受預先提供信用卡號
     *
     * @param $number
     * @param $expired
     * @param $cvv
     * @return $this
     */
    public function card($number ,$expired ,$cvv)
    {
        $this->card = [
            'number' => $number,
            'expiry' => $expired,
            'cvv' => $cvv
        ];

        return $this;
    }

    public function setUser($user)
    {
        $this->paymentUser = $user;

        return $this;
    }

    /**
     * 建立金流付款欄位
     *
     * @return mixed
     */
    public function create()
    {
        $amount = $this->amount;
        $no = $this->uuid ?: uniqid();
        $method = $this->paymentMethod;
        $this->paymentServiceProvider =  PaymentServiceFactory::create($this->paymentProvider);
        $card = $this->card;
        $this->paymentMethodModel = $this->makeMethod($this->paymentMethod);
        $this->paymentServiceModel = $this->makeService($this->paymentProvider);

        $attributes = [
            'user_id'            => auth()->id(),
            'no'                 => $no,
            'amount'             => $this->amount,
            'payment_method_id'  => $this->paymentMethodModel->id,
            'payment_service_id' => $this->paymentServiceModel->id,
        ];



        /**
         * 收到付款要求後，建立付款訂單，並導向到重導向頁面，將金流需要的格式用 form post 方式帶過去
         */
        $payment = $this->createPaymentRecord($attributes);

//        if($this->hasCarrier()){
//            $payment->addInvoice();
//        }

        return $this->redirect($amount ,$no ,$method ,$card);
    }

}