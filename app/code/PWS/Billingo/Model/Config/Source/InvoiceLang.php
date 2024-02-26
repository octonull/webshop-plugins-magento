<?php

namespace PWS\Billingo\Model\Config\Source;
use PWS\Billingo\lib\PWSBillingo;


class InvoiceLang implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        $list = [
            ['value' => 'invoice_address_based', 'label' => __('Számlázási cím alapján')]
        ];

        foreach (PWSBillingo::ALL_LANGUAGES as $iso => $name) {
            $list[] = ['value' => $iso, 'label' => __($name)];
        }

        return $list;
    }

    public function toArray()
    {
        $list = [__('invoice_address_based')];

        foreach (PWSBillingo::ALL_LANGUAGES as $iso => $name) {
            $list[] = [__($iso)];
        }
    }
}
