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
}