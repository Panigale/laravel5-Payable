<?php
/**
 * Author: Panigale
 * Date: 2018/2/23
 * Time: 下午3:24
 */
namespace Panigale\Payment\Traits;

use Panigale\Payment\Exceptions\PaymentMethodNotExist;
use Panigale\Payment\Exceptions\PaymentServiceNotSupport;
use Panigale\Payment\Models\Payment;
use Panigale\Payment\Models\PaymentMethod;
use Panigale\Payment\Service\PaymentService;

trait CreatePayment
{
    protected $payment = null;

    protected $paymentMethodModel = null;

    protected $paymentService = null;

    protected $uuid = null;

    protected $description = null;

    protected $order;

    protected function createPaymentRecord()
    {
        if(is_null($this->payment))
            $this->payment = $this->make($this->paymentService);

        $no = $this->uuid ?: uniqid();

        $this->order = Payment::create([
            'user_id' => $this->id,
            'no' => $no,
            'amount' => $this->amount,
//            'payment_method_id' => $this->paymentMethod->id,
//            'payment_service_id' => $this->paymentService->id,
            'payment_service' => $this->paymentService,
            'payment_method' => $this->paymentMethod,
            'description' => $this->description,
        ]);

        return $this;
    }

    protected function makeMethod($method)
    {
        $methodModel = PaymentMethod::where('name' ,$method)->first();

        if(is_null($method)){
            throw PaymentMethodNotExist::create();
        }



        return $method;
    }

    protected function makeService($service)
    {
        $serviceModel = PaymentService::where('name' ,$service)->first();

        if(is_null($service)){
            throw PaymentServiceNotSupport::create($service);
        }

        return $service;
    }
}