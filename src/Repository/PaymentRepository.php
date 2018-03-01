<?php
/**
 * Author: Panigale
 * Date: 2018/3/1
 * Time: 下午3:50
 */

namespace Panigale\Payment\Repository;


use Panigale\Payment\Models\Payment;

class PaymentRepository
{
    public function query()
    {
        return Payment::query();
    }

    /**
     * @param array $column
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findWhere(array $column = [])
    {
        $query = $this->query();

        foreach ($column as $key => $value){
            $query->where($key ,$value);
        }

        return $query->get();
    }
}