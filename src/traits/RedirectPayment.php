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
    public function redirect($amount ,$no ,$creditCard)
    {
        $user = Auth::user();
        return $this->payment->redirect($amount ,$no ,$creditCard);
    }
}