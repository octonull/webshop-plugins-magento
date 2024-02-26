<?php

namespace PWS\Billingo\Block\Adminhtml\System\Config\Form\Field;
use PWS\Billingo\lib\PWSBillingo;
use PWS\Billingo\Helper\Magic;

class Paymentmap extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    protected $_magic = null;

    /** @var \Magento\Framework\Data\Form\Element\Factory */
    protected $_elementFactory;

    /** @var \Magento\Payment\Helper\Data */
    protected $paymentHelper;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Data\Form\Element\Factory $elementFactory
     * @param array $data
     */
    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Payment\Helper\Data $paymentHelper, Magic $magic, \Magento\Framework\Data\Form\Element\Factory $elementFactory, array $data = [])
    {
        $this->_elementFactory  = $elementFactory;

        parent::__construct($context,$data);

        $this->paymentHelper = $paymentHelper;
        $this->_magic = $magic;
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareToRender()
    {
        $this->addColumn('field1', ['label' => __('Magento')]);
        $this->addColumn('field2', ['label' => __('Billingo')]);
        $this->addColumn('field3', ['label' => __('Payment deadline')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    public function renderCellTemplate($columnName)
    {
        if ($columnName == 'field1' && isset($this->_columns[$columnName])) {
            $aOptions = $this->paymentHelper->getPaymentMethodList();
        } elseif ($columnName == 'field2' && isset($this->_columns[$columnName])) {
            $aOptions = PWSBillingo::ALL_PAYMENTS;
        }  else {
            return parent::renderCellTemplate($columnName);
        }
        $oElement = $this->_elementFactory->create('select');
        $oElement->setForm($this->getForm());
        $oElement->setName($this->_getCellInputElementName($columnName));
        $oElement->setHtmlId($this->_getCellInputElementId('<%- _id %>', $columnName));
        $oElement->setValues($aOptions);
        return str_replace("\n", '', $oElement->getElementHtml());
    }
}
