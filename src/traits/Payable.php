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

    protected $service = null;

    /**
     * @var
     */
    protected $amount;

    /**
     * @return mixed
     */
    public function payments()
    {
        return $this->morphMany(Payment::class ,'payable');
    }

    public function pay(int $amount ,$method ,$service ,$card = [])
    {
        $this->amount = $amount;
        $this->paymentMethod = $method;
        $this->paymentService = $service;
        $this->service = PaymentServiceFactory::create($service);
        /**
         * 收到付款要求後，建立付款訂單，並導向到重導向頁面，將金流需要的格式用 form post 方式帶過去
         */
        $this->createPaymentRecord();

        return $this->redirect($amount ,$this->order->no ,$method ,$card);
    }

    public function payment()
    {
        return $this->order;
    }

    public function payBy(string $method)
    {
        $this->paymentMethod = $this->make($method);

        return $this;
    }

    /**
     * set number
     *
     * @param $no
     * @return $this
     */
    public function setNumber($no)
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
}