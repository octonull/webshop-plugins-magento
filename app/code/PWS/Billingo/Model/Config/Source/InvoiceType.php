<?php

namespace PWS\Billingo\Model\Config\Source;
use PWS\Billingo\lib\PWSBillingo;

class InvoiceType implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            ['value' => PWSBillingo::INVOICE_TYPE_DRAFT, 'label' => __('draft')],
            ['value' => PWSBillingo::INVOICE_TYPE_PROFORMA, 'label' => __('proforma')],
            ['value' => PWSBillingo::INVOICE_TYPE_INVOICE, 'label' => __('invoice')]
        ];
    }

    public function toArray()
    {
        return [
            PWSBillingo::INVOICE_TYPE_DRAFT => __('draft'),
            PWSBillingo::INVOICE_TYPE_PROFORMA => __('proforma'),
            PWSBillingo::INVOICE_TYPE_INVOICE => __('invoice')
        ];
    }
}
