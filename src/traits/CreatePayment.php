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

    /**
     *
     *
     * @var PaymentMethod
     */
    protected $paymentMethodModel = null;

    /**
     * @var \Panigale\Payment\Models\PaymentService
     */
    protected $paymentServiceModel;

    protected $paymentService = null;

    protected $uuid = null;

    protected $description = null;

    protected $order;

    protected function createPaymentRecord()
    {
        $this->paymentMethodModel = $this->makeMethod($this->paymentMethod);
        $this->paymentServiceModel = $this->makeService($this->paymentService);

        $no = $this->uuid ?: uniqid();

        $this->order = Payment::create([
            'user_id' => $this->id,
            'no' => $no,
            'amount' => $this->amount,
            'payment_method_id' => $this->paymentMethodModel->id,
            'payment_service_id' => $this->paymentServiceModel->id,
//            'payment_service' => $this->paymentService,
//            'payment_method' => $this->paymentMethod,
//            'description' => $this->description,
        ]);

        return $this;
    }

    protected function makeMethod($method)
    {
        $methodModel = PaymentMethod::where('name' ,$method)->first();

        if(is_null($method)){
            throw PaymentMethodNotExist::create();
        }

        $this->paymentMethodModel = $methodModel;



        return $method;
    }

    protected function makeService($service)
    {
        $serviceModel = PaymentService::where('name' ,$service)->first();

        if(is_null($service)){
            throw PaymentServiceNotSupport::create($service);
        }

        $this->paymentServiceModel = $serviceModel;

        return $service;
    }
}