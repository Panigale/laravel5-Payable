<?php
/**
 * Author: Panigale
 * Date: 2020/8/4
 * Time: 3:20 下午
 */

namespace Panigale\Payment\Traits;


trait HasInvoice
{

    protected $carrierType;

    protected $carrierId;

    protected $invoiceTitle;

    protected $invoiceAddress;

    protected $invoiceTaxNum;

    protected $customerName;

    protected $customerEmail;

    public function addInvoice()
    {
        return $this->invoice()->create([
            'customer_name'  => $this->customerName,
            'customer_email' => $this->customerEmail,
            'tax_title'      => $this->invoiceTitle,
            'tax_number'     => $this->invoiceTaxNum,
            'address'        => $this->invoiceAddress,
            'carrier_type'   => $this->carrierType,
            'carrier_id'     => $this->carrierId
        ]);
    }

    public function invoiceCarrier($carrierType, $carrierId)
    {
        $this->carrierType = $carrierType;
        $this->carrierId = $carrierId;

        return $this;
    }

    public function invoiceTo(array $to)
    {
        $snakeCase = collect($to)->each(function ($data) {
            return snake_case($data);
        });

        $this->invoiceTitle = $snakeCase['taxTitle'];
        $this->invoiceAddress = $snakeCase['address'];
        $this->invoiceTaxNum = $snakeCase['taxNum'];
        $this->customerName = $snakeCase['customerName'];
        $this->customerEmail = $snakeCase['customerEmail'];

        return $this;
    }

    protected function hasCarrier()
    {
        return ! is_null($this->carrierId) && ! is_null($this->carrierType);
    }

    public function invoiceType($type)
    {
        $this->invoiceType = $type;

        return $this;
    }
}