<?php
/**
 * Author: Panigale
 * Date: 2020/8/4
 * Time: 3:20 下午
 */

namespace Panigale\Payment\traits;


trait HasInvoice
{

    protected $carrierType;

    protected $carrierId;

    protected $invoiceTitle;

    protected $invoiceAddress;

    protected $invoiceTaxNum;

    public function invoiceDevice($carrierType ,$carrierId)
    {
        $this->carrierType = $carrierType;
        $this->carrierId = $carrierId;

        return $this;
    }

    public function invoiceTo(array $to)
    {
        $snakeCase = collect($to)->each(function($data){
            return snake_case($data);
        });

        $this->invoiceTitle = $snakeCase['taxTitle'];
        $this->invoiceAddress = $snakeCase['address'];
        $this->invoiceTaxNum = $snakeCase['taxNum'];

        return $this;
    }

    protected function hasCarrier()
    {
        return !is_null($this->carrierId) && !is_null($this->carrierType);
    }
}