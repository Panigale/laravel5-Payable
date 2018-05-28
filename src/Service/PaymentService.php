<?php
/**
 * Author: Panigale
 * Date: 2018/3/1
 * Time: 上午12:08
 */

namespace Panigale\Payment\Service;


use Panigale\GoMyPay\GoMyPay;
use Panigale\Payment\Exceptions\PaymentMethodNotExist;
use Panigale\Payment\Exceptions\PaymentServiceNotSupport;
use Panigale\Payment\Models\PaymentMethod;
use Panigale\Payment\Repository\PaymentRepository;
use Panigale\Payment\Models\PaymentService as Model;

class PaymentService
{
    protected $repository;

    public $response;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function success()
    {
        $response = $this->receive();

        $this->response = $response;

        return $response->result;
    }

    /**
     * 取回交易結果
     *
     * @return mixed
     */
    public function receive()
    {
        $service = new GoMyPay();

        return $service->done();
    }

    public function swap($paymentMethod ,$paymentService)
    {
        $paymentMethod = PaymentMethod::where('name' ,$paymentMethod)->first();

        if(is_null($paymentMethod)){
            throw new PaymentMethodNotExist($paymentMethod);
        }

        $paymentService = Model::where('name' ,$paymentService)->first();

        if(is_null($paymentService)){
            throw new PaymentServiceNotSupport($paymentService);
        }


        return $paymentMethod->update([
            'payment_service_id' => $paymentService
        ]);
    }

    public function getAmount()
    {
        return $this->response->amount;
    }
}