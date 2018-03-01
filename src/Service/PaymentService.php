<?php
/**
 * Author: Panigale
 * Date: 2018/3/1
 * Time: 上午12:08
 */

namespace Panigale\Payment\Service;


use Panigale\GoMyPay\GoMyPay;
use Panigale\Payment\Repository\PaymentRepository;

class PaymentService
{
    protected $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function success()
    {
        $result = $this->receive();

        return $result->status === 'success';
    }

    /**
     * 取回交易結果
     *
     * @return mixed
     */
    public function receive()
    {
        return GoMyPay::done();
    }
}