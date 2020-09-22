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
use Panigale\Payment\Models\PaymentService;

trait CreatePayment
{
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

    /**
     * @return $this
     */
    protected function createPaymentRecord(array $payment)
    {
        $this->paymentMethodModel = $this->makeMethod($this->paymentMethod);
        $this->paymentServiceModel = $this->makeService($this->paymentProvider);

        $this->order = $this->payments()->create($payment);

        return $this;
    }

    /**
     * @param $method
     * @return mixed
     */
    protected function makeMethod($method)
    {
        $methodModel = PaymentMethod::where('name', $method)->first();

        if (is_null($methodModel)) {
            throw PaymentMethodNotExist::create($method);
        }

        return $methodModel;
    }

    /**
     * @param $service
     * @return mixed
     */
    protected function makeService($service)
    {
        $serviceModel = PaymentService::where('name', $service)->first();

        if (is_null($service)) {
            throw PaymentServiceNotSupport::create($service);
        }

        return $serviceModel;
    }
}