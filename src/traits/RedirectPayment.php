<?php
/**
 * Author: Panigale
 * Date: 2018/2/25
 * Time: 下午10:56
 */

namespace Panigale\Payment\Traits;

trait RedirectPayment
{
    public function redirect($user ,$amount ,$no ,$creditCard)
    {
        return $this->payment->redirect($user ,$amount ,$no ,$creditCard);
    }
}