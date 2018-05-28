<?php
/**
 * Author: Panigale
 * Date: 2018/5/28
 * Time: 下午1:25
 */

namespace Panigale\Payment\Service;


class BasePayment
{
    protected $no;

    protected $request;

    public function setNo($no)
    {
        $this->no = $no;

        return $this;
    }
}