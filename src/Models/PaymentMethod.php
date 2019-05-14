<?php
namespace Panigale\Payment\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Author: Panigale
 * Date: 2018/2/23
 * Time: 下午3:10
 */

class PaymentMethod extends Model
{
    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(PaymentService::class ,'payment_service_id');
    }
}