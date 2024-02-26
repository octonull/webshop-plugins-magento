<?php

namespace PWS\Billingo\Model\Config\Source;

class Trigger implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [['value' => 'order', 'label' => __('order')],['value' => 'status', 'label' => __('status')]];
    }

    public function toArray()
    {
        return ['order' => __('order'),'status' => __('status')];
    }
}
