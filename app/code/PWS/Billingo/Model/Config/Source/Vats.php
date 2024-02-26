<?php

namespace PWS\Billingo\Model\Config\Source;
use PWS\Billingo\lib\PWSBillingo;

class Vats implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        $vats = [];
        array_push($vats, ['value' => '', 'label' => __('---')]);
        foreach (PWSBillingo::ALL_TAXES as $vat) {
            array_push($vats, ['value' => $vat, 'label' => __($vat)]);
        }

        return $vats;
    }

    public function toArray()
    {
        $vats = [];
        $vats[''] = __('---');
        foreach (PWSBillingo::ALL_TAXES as $vat) {
            $vats[$vat] = __($vat);
        }

        return $vats;
    }
}
