<?php
/**
 * Author: Panigale
 * Date: 2018/1/15
 * Time: 下午4:50
 */

namespace Panigale\GoMyPay\Service;


interface GoMyPayContract
{
    /**
     * create payment.
     *
     * @return mixed
     */
    public function create();

    /**
     * get payment result.
     *
     * @return mixed
     */
    public function done($paymentType = null);

    /**
     * get action url.
     *
     * @return mixed
     */
     public function getActionUrl();

    /**
     * set trade amount
     *
     * @return mixed
     */
    public function withAmount(int $amount);

    /**
     * set trade user.
     *
     * @param $name
     * @param $email
     * @param $phone
     * @return mixed
     */
    public function withUser($name ,$email ,$phone);

}