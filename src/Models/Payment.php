<?php


namespace Panigale\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Panigale\Point\Models\PointEvent;

/**
 * Author: Panigale
 * Date: 2018/2/23
 * Time: 下午3:09
 */

class Payment extends Model
{
    protected $guarded = ['id'];

    public function pointEvent()
    {
        return $this->morphMany(PointEvent::class ,'pointable');
    }

    public function payable()
    {
        return $this->morphTo();
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class ,'payment_method_id');
    }

    public function service()
    {
        return $this->belongsTo(PaymentService::class ,'payment_service_id');
    }
}