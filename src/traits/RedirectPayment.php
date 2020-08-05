<?php
/**
 * Author: Panigale
 * Date: 2018/2/25
 * Time: 下午10:56
 */

namespace Panigale\Payment\Traits;

use Illuminate\Support\Facades\Auth;

trait RedirectPayment
{
    public function redirect($amount ,$no ,$method ,$creditCard)
    {
        $user = is_null($this->paymentUser) ? Auth::user() : $this->paymentUser;

        return $this->paymentServiceProvider->redirect($user ,$amount ,$no ,$method ,$creditCard);
    }
}