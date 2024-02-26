<?php

namespace PWS\Billingo\Observer\Sales;

use \PWS\Billingo\Helper\Magic;

class OrderSaveAfter implements \Magento\Framework\Event\ObserverInterface
{
    protected $_countryFactory;
    protected $_storeManager;
    protected $_magic = null;

    /** @var \Magento\Framework\Module\Manager */
    protected $_moduleManager;


    public function __construct(\Magento\Directory\Model\CountryFactory $countryFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, Magic $magic, \Magento\Framework\Module\Manager $moduleManager)
    {
        $this->_magic = $magic;
        $this->_countryFactory = $countryFactory;
        $this->_storeManager = $storeManager;
        $this->_moduleManager = $moduleManager;
    }

    /**
     * Retrieves visible products of the order, omitting its children (yes, this is different than Magento's method)
     * from: https://community.magento.com/t5/Magento-2-x-Programming/getAllVisibleItems-shows-both-configurable-and-parent-products/td-p/83184
     * 2020-04-09
     *
     * @param \Magento\Sales\Model\Order $order
     *
     * @return array
     */
    public function getAllVisibleItems($order)
    {
        $items = [];
        foreach ($order->getItems() as $item) {
            if (!$item->isDeleted() && !$item->getParentItem()) {
                $items[] = $item;
            }
        }
        return $items;
    }

    /**
     * Get item options as array
     * from: https://www.rakeshjesadiya.com/how-to-get-order-item-selected-options-in-magento-2/
     * 2020-04-20
     *
     * @param $item
     * @return array
     */
    public function getSelectedOptions($item)
    {
        $result = [];
        $options = $item->getProductOptions();
        if ($options) {
            if (isset($options['options'])) {
                $result = array_merge($result, $options['options']);
            }
            if (isset($options['additional_options'])) {
                $result = array_merge($result, $options['additional_options']);
            }
            if (isset($options['attributes_info'])) {
                $result = array_merge($result, $options['attributes_info']);
            }
        }
        return $result;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $conf = $this->_magic->getConfigVars($this->_storeManager->getStore()->getStoreId());

        $order = $observer->getEvent()->getOrder();
        $addressObj = $order->getBillingAddress();
        $payment = $order->getPayment();
        $payment_method = $payment->getMethodInstance();

        $log_file = BP . '/var/log/billingo/billingo_' . date('Y-m-d') . '.txt';
        $log_dir = dirname($log_file);
        if (!file_exists($log_dir)) {
            mkdir($log_dir, 0755, true);
            \PWS\Billingo\lib\PWSBillingo::createHtaccessInDir($log_dir);
        }

        if (!(($conf['trigger'] == 'status' && in_array($order->getStatus(), $conf['trigger_status'])) || ($conf['trigger'] == 'order' && in_array($order->getState(),  ['new', 'payment_review'])))) {
            $fp = fopen($log_file, 'a');
            fwrite($fp, date('Y-m-d H:i:s') . ' OrderSaveAfter' .  PHP_EOL);
            fwrite($fp, 'SKIP: ' . print_r([
                'state' => $order->getState(),
                'status' => $order->getStatus(),
                'conf_trigger' => $conf['trigger'],
                'conf_stastes' => $conf['trigger_status'],
            ], true));
            fwrite($fp, PHP_EOL . PHP_EOL);
            fclose($fp);
            return;
        }

        $prods = [];
        foreach ($this->getAllVisibleItems($order) as $item) {
            $opts = '';
            if ($options = $this->getSelectedOptions($item)) {
                $opt_strs = [];
                foreach ($options as $_option) {
                    $opt_strs[] = $_option['label'] . ': ' . $_option['value'];
                }
                $opts = ' ' . implode(', ', $opt_strs);
            }

            $prods[] = [
                'name' => $item->getName() . $opts,
                'qty' => $item->getQtyOrdered(),
                'price' => $item->getPriceInclTax(),
                'tax' => $item->getTaxPercent(),
                'sku' => $item->getSku(), //$item->getProductOptions()['simple_sku'],
            ];
        }


        $lang = \Magento\Framework\App\ObjectManager::getInstance()
            ->get('Magento\Framework\App\Config\ScopeConfigInterface')
            ->getValue('general/locale/code', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $order->getStore()->getStoreId());

        $data = [
            'id_store' => $order->getStore()->getStoreId(),
            'id_order' => $order->getId(),
            'id_order_old' => $order->getIncrementId(),
            'lang' => substr($lang, 0, 2),
            'Order realID' => $order->getRealOrderId(),
            'currency' => $order->getOrderCurrencyCode() ?: $this->_storeManager->getStore()->getCurrentCurrencyCode(),
            'note' => $order->getCustomerNote(),
            'state' => $order->getState(),
            'status' => $order->getStatus(),
            'customer_email' => $order->getCustomerEmail(),

            'billing_address' => [
                'company' => $addressObj->getCompany(),
                'first_name' => $addressObj->getFirstname(),
                'last_name' => $addressObj->getLastname(),
                'city' => $addressObj->getCity(),
                'zip' => $addressObj->getPostcode(),
                'address1' => implode(' ', $addressObj->getStreet()),
                'country id' => $addressObj->getCountryId(),
                'country name' => $this->getCountryname($addressObj->getCountryId()),
                'vatid' => $addressObj->getVatId(),
            ],

            'coupon' => $order->getCouponCode(),

            'payment' => $payment_method->getCode(),

            'shipping' => $order->getShippingDescription(),
            'shipping_price' => $order->getShippingInclTax(),
            'shipping_tax' => $order->getShippingTaxAmount(),

            'getDiscountAmount' => $order->getDiscountAmount(),

            'products' => $prods,

            'taxAmount' => $order->getTaxAmount(),
            'grandTotal' => $order->getGrandTotal(),
        ];

        if ($this->_moduleManager->isEnabled('MagestyApps_PaymentFee')) {
            $data['fee'] = $order->getPaymentFeeAmount();
            $data['fee_base'] = $order->getBasePaymentFeeAmount();
            $data['fee_tax'] = $order->getPaymentFeeTaxAmount();
            $data['fee_base_tax'] = $order->getBasePaymentFeeTaxAmount();
        }

        $fp = fopen($log_file, 'a');
        fwrite($fp, date('Y-m-d H:i:s') . ' OrderSaveAfter' . PHP_EOL);
        fwrite($fp, 'Config: ' . print_r($conf, true) . PHP_EOL);
        fwrite($fp, 'Data: ' . json_encode($data, JSON_PRETTY_PRINT));
        fwrite($fp, PHP_EOL . PHP_EOL);
        fclose($fp);


        $r = $this->_magic->generate_invoice($data);

        if (!is_array($r)) {
            $order->addStatusHistoryComment($r)->setIsCustomerNotified(false)->save();
        }
    }

    public function getCountryname($countryCode)
    {
        $country = $this->_countryFactory->create()->loadByCode($countryCode);
        return $country->getName();
    }
}