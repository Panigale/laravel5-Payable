<?php
/**
 * Author: Panigale
 * Date: 2018/3/1
 * Time: 上午12:08
 */

namespace Panigale\Payment\Service;


use Exception;
use Panigale\GoMyPay\GoMyPay;
use Panigale\Payment\Exceptions\PaymentMethodNotExist;
use Panigale\Payment\Exceptions\PaymentServiceNotSupport;
use Panigale\Payment\Models\Payment;
use Panigale\Payment\Models\PaymentMethod;
use Panigale\Payment\Repository\PaymentRepository;
use Panigale\Payment\Models\PaymentService as Model;
use Panigale\Payment\Service\Sonet;

class PaymentService
{
    protected $repository;

    public $response;

    protected $payment;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function success($paymentService)
    {
        $response = $this->receive($paymentService);


        $this->response = $response;

        return $response->result;
    }

    /**
     * 取回交易結果
     *
     * @return mixed
     * @throws Exception
     */
    public function receive($paymentService)
    {

        $service = app()->make($this->service($paymentService));

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

    public function getPaymentNo()
    {
        return $this->response->tradeNo;
    }

    public function getPayment()
    {
        $payment = Payment::where('no' ,$this->getPaymentNo())->first();
        $this->payment = $payment;

        return $payment;
    }

    public function done()
    {
        $this->payment->update([
            'has_paid' => true,
            'response' => $this->response->response,
            'service_no' => $this->response->serverTradeId
        ]);
    }

    /**
     * @param $paymentService
     * @return string
     * @throws Exception
     */
    public function service($paymentService)
    {
        switch ($paymentService){
            case 'Sonet':
                return Sonet::class;
            case 'GoMyPay':
                return GoMyPay::class;
            default:
                throw new Exception("payment service {$paymentService} does not exist");
        }
    }
}