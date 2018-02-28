<?php
/**
 * Author: Panigale
 * Date: 2018/2/23
 * Time: 下午3:24
 */
namespace Panigale\Payment\Traits;

use Panigale\Payment\Exceptions\PaymentMethodNotExist;
use Panigale\Payment\Models\Payment;
use Panigale\Payment\Models\PaymentMethod;

trait CreatePayment
{
    protected $payment = null;

    protected $paymentMethodModel = null;

    protected $paymentService = null;

    protected $uuid = null;

    protected $description = null;

    protected function createPaymentRecord()
    {
        if(is_null($this->payment))
            $this->payment = $this->make($this->paymentService);

        $this->order = Payment::create([
            'user_id' => $this->id,
            'no' => $this->uuid ?: uniqid(),
            'amount' => $this->amount,
            'payment_method_id' => $this->paymentMethod->id,
            'payment_service_id' => $this->paymentService->id,
            'description' => $this->description,
        ]);

        return $this;
    }

    protected function make($method)
    {
        $method = PaymentMethod::where('name' ,$method)->first();

        if(is_null($method)){
            throw PaymentMethodNotExist::create();
        }

        return $method;
    }
}