<?php

namespace PWS\Billingo\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\ScopeInterface;
use PWS\Billingo\lib\PWSBillingo;

class Magic extends AbstractHelper
{
    protected $_conf;
    protected $_store_id;

    public function getConfigVars($scope_code = null)
    {
        if (!$this->_conf || $this->_store_id != $scope_code) {
            $this->_store_id = $scope_code;
            $this->_conf = [
                'api_key' => $this->scopeConfig->getValue('settings/api/api_key', ScopeInterface::SCOPE_STORE, $scope_code),
                'invoice_block' => $this->scopeConfig->getValue('settings/api/invoice_block', ScopeInterface::SCOPE_STORE, $scope_code),

                'trigger' => $this->scopeConfig->getValue('settings/invoice/trigger', ScopeInterface::SCOPE_STORE, $scope_code),
                'trigger_status' => explode(',', $this->scopeConfig->getValue('settings/invoice/trigger_status', ScopeInterface::SCOPE_STORE, $scope_code)),
                'send_email' => $this->scopeConfig->getValue('settings/invoice/send_email', ScopeInterface::SCOPE_STORE, $scope_code),
                'send_enable' => $this->scopeConfig->getValue('settings/invoice/send_enable', ScopeInterface::SCOPE_STORE, $scope_code),
                'electronic' => $this->scopeConfig->getValue('settings/invoice/electronic', ScopeInterface::SCOPE_STORE, $scope_code),
                'invoice_type' => $this->scopeConfig->getValue('settings/invoice/invoice_type', ScopeInterface::SCOPE_STORE, $scope_code),
                'invoice_lang' => $this->scopeConfig->getValue('settings/invoice/invoice_lang', ScopeInterface::SCOPE_STORE, $scope_code),
                'note' => $this->scopeConfig->getValue('settings/invoice/note', ScopeInterface::SCOPE_STORE, $scope_code),
                'unit' => $this->scopeConfig->getValue('settings/invoice/unit', ScopeInterface::SCOPE_STORE, $scope_code),
                'add_sku' => $this->scopeConfig->getValue('settings/invoice/add_sku', ScopeInterface::SCOPE_STORE, $scope_code),

                'tax_override' => $this->scopeConfig->getValue('settings/invoice/tax_override', ScopeInterface::SCOPE_STORE, $scope_code),
                'tax_override_entitlement' => $this->scopeConfig->getValue('settings/invoice/tax_override_entitlement', ScopeInterface::SCOPE_STORE, $scope_code),
                'tax_override_zero' => $this->scopeConfig->getValue('settings/invoice/tax_override_zero', ScopeInterface::SCOPE_STORE, $scope_code),
                'tax_override_zero_entitlement' => $this->scopeConfig->getValue('settings/invoice/tax_override_zero_entitlement', ScopeInterface::SCOPE_STORE, $scope_code),

                'tax_override_eu' => $this->scopeConfig->getValue('settings/invoice/tax_override_eu', ScopeInterface::SCOPE_STORE, $scope_code),
                'tax_override_include_carrier' => $this->scopeConfig->getValue('settings/invoice/tax_override_include_carrier', ScopeInterface::SCOPE_STORE, $scope_code),

                'paymentmap' => $this->scopeConfig->getValue('settings/paymentmap/paymentmap', ScopeInterface::SCOPE_STORE, $scope_code),
            ];
        }

        return $this->_conf;
    }

    /**
     * Returns and initializes Billingo API Connector
     *
     * @return PWSBillingo
     */
    public static function getBillingoConnector($api_key)
    {
        $plugin_version = '3.0.1';

        return new PWSBillingo($api_key, BP . '/var/log/billingo/billingo_' . date('Y-m-d') . '.txt', 'Magento', $plugin_version);
    }

    public static function findPartnerByHash($hash)
    {
        $objectManager = ObjectManager::getInstance();
        $collection = $objectManager->create('PWS\Billingo\Model\BillingoPartnerhash')->getCollection()->getData();// todo filter
        //$item = $collection->getFirstItem();

        //if ($item->getId()) {
        //    return $item;
        //}

        if (is_array($collection)) {
            foreach ($collection as $item) {
                if ($item['hash'] == $hash) {
                    return $item;
                }
            }
        }

        return false;
    }

    protected static function getPartnerData($data)
    {
        $addr = $data['billing_address'];

        $name = $addr['last_name'] . ' ' . $addr['first_name'];

        if ($company = trim($addr['company'])) {
            $name = $company . ' - ' . $name;
        }

        $client_data = [
            'name'     => $name,
            'emails'   => [$data['customer_email']],
            'taxcode'  => ($addr['vatid'] ? $addr['vatid'] : ''),
            'tax_type' => PWSBillingo::getPartnerTaxType($addr['country id'], $addr['vatid']),
        ];
        $address_data = [
            'country_code' => $addr['country id'],
            'post_code'    => $addr['zip'] ?: '00000',
            'city'         => $addr['city'],
            'address'      => $addr['address1'],
        ];

        return [$client_data, $address_data];
    }

    public static function findOrCreatePartnerId(PWSBillingo $connector, $data)
    {
        list($client_data, $address_data) = static::getPartnerData($data);

        // check if hash found
        $hash = PWSBillingo::hashPartnerData($connector->api_key, $client_data, $address_data);
        $probably_partner_id = static::findPartnerByHash($hash);
        if ($probably_partner_id && $probably_partner_id['partner_id']) {
            return $probably_partner_id['partner_id'];
        }

        $partner_id = $connector->createPartnerAndGetId($client_data, $address_data);

        // save hash+id
        if ($partner_id) {
            $objectManager = ObjectManager::getInstance();
            $partner_hash = $objectManager->create('PWS\Billingo\Model\BillingoPartnerhash');
            $partner_hash->setPartnerId($partner_id);
            $partner_hash->setHash($hash);
            $partner_hash->save();
        }

        return $partner_id;
    }

    public function generate_invoice($data)
    {
        $bdata = $this->getBillingoData($data['id_order_old']); // originally used increment id; kept to access previously generated invoices
        if ($bdata && $bdata['link']) {
            return 'https://www.billingo.hu/access/c:' . $bdata['link'];
        }

        $bdata = $this->getBillingoData($data['id_order']);
        if ($bdata && $bdata['link']) {
            return 'https://www.billingo.hu/access/c:' . $bdata['link'];
        }

        $settings = $this->getConfigVars($data['id_store']);
        $addr = $data['billing_address'];

        $connector = static::getBillingoConnector($settings['api_key']);

        $invoice_block = (int)$settings['invoice_block'];
        $add_sku = (bool)$settings['add_sku'];

        if (!($partner_id = static::findOrCreatePartnerId($connector, $data))) {
            return [
                'error' => true,
                'messages' => [__('Nem sikerült létrehozni az ügyfelet.', 'billingo')],
            ];
        }

        $lang = $settings['invoice_lang'];
        if ($lang == 'invoice_address_based') {
            $lang = strtolower($addr['country id']);
        }

        if (!array_key_exists($lang, PWSBillingo::ALL_LANGUAGES)) {
            $lang = 'hu';
        }

        PWSBillingo::setCountryCodeForVat($addr['country id']);
        PWSBillingo::setEntitlements($settings['tax_override_entitlement'], $settings['tax_override_zero_entitlement']);
        PWSBillingo::setTaxOverrides(
            $settings['tax_override'] ? ($settings['tax_override_eu'] ? -1 : $settings['tax_override']) : -1,
            $settings['tax_override_zero'] ?: -1,
            $settings['tax_override_eu'],
            $settings['tax_override_include_carrier']
        );

        //Create invoice data array
        $invoice_data = [
            'fulfillment_date' => date('Y-m-d'),
            'due_date' => date('Y-m-d', strtotime('+' . (int)$this->_paydlmap($data['payment']) . ' days')),
            'payment_method' => $this->_paymap($data['payment']),
            'comment' =>  $data['note'] . ($settings['note'] ? ('; ' . $settings['note']) : ''),
            'language' => $lang,
            'electronic' => (int)$settings['electronic'],
            'currency' => $data['currency'],
            'partner_id' => $partner_id,
            'block_id' => $invoice_block,
            'type' => $settings['invoice_type'],
            'settings' => [
                'round' => 'none',
                'should_send_email' => $settings['send_enable'] ? 1 : 0
            ],
        ];

        //Add products
        $product_items = [];
        foreach ($data['products'] as $row) {
            $vat_rule = PWSBillingo::applyVatRule(round($row['tax']), false);
            $product_item = [
                'name' => $row['name'],
                'unit' => $settings['unit'],
                'quantity' => (int)$row['qty'],
                'vat' => $vat_rule['vat'],
                'entitlement' => $vat_rule['entitlement'],
                'unit_price_type' => PWSBillingo::PRICE_TYPE_GROSS,
                'unit_price' => (float)$row['price']
            ];

            if ($add_sku) {
                $product_item['comment'] = 'Cikkszám/SKU: ' . $row['sku'];
            }

            $product_items[] = $product_item;
        }

        // Add shipping
        if ($data['shipping_price']) {
            $vat_rule = PWSBillingo::applyVatRule($row['tax'], true);
            $product_item = [
                'unit' => $settings['unit'],
                'name' => $data['shipping'],
                'quantity' => 1,
                'vat' => $vat_rule['vat'],
                'entitlement' => $vat_rule['entitlement'],
                'unit_price_type' => PWSBillingo::PRICE_TYPE_GROSS,
                'unit_price' => (float)$data['shipping_price']
            ];

            $product_items[] = $product_item;
        }

        // Add discount
        $absdsc = abs($data['getDiscountAmount']);
        if ($absdsc > 0.0) {
            //$taxfulltotal = round($data['taxAmount'] / $data['grandTotal'] * 100.0);

            $vat_rule = PWSBillingo::applyVatRule($row['tax'], false);
            $product_item = [
                'name' => 'Kedvezmény/Discount' . ($data['coupon'] ? (': ' . $data['coupon']) : ''),
                'unit' => $settings['unit'],
                'quantity' => 1,
                'vat' => $vat_rule['vat'],
                'entitlement' => $vat_rule['entitlement'],
                'unit_price_type' => PWSBillingo::PRICE_TYPE_GROSS,
                'unit_price' => (float)($absdsc * -1.0)
            ];

            $product_items[] = $product_item;
        }

        // Add fee (CoD)
        if (isset($data['fee']) && $data['fee']) {
            $tax = $data['fee_tax'] / $data['fee'] * 100.0;
            $vat_rule = PWSBillingo::applyVatRule($tax, false);
            $product_item = [
                'name' => 'Fizetési mód Díj/Payment Fee',
                'unit' => $settings['unit'],
                'quantity' => 1,
                'vat' => $vat_rule['vat'],
                'entitlement' => $vat_rule['entitlement'],
                'unit_price_type' => PWSBillingo::PRICE_TYPE_GROSS,
                'unit_price' => (float)$data['fee']
            ];

            $product_items[] = $product_item;
        }

        $invoice_data['items'] = $product_items;



        //Create invoice
        $invoice = $connector->createInvoice($invoice_data);

        //Get ID
        if (!$invoice['id']) {
            return [
                'error' => true,
                'messages' => [__('Nem sikerült létrehozni a számlát.', 'billingo')],
            ];
        }

        //Create download link
        if (!($doc_public_url = $connector->getDownloadLinkById($invoice['id']))) {
            //$response['messages'][] = 'Hiba: Nem sikerült létrehozni a letöltési linket a számlához.';
            $doc_public_url = '';
        }

        $inv_nr = $invoice['invoice_number'] ?: $invoice['id'];

        $this->saveBillingoData($data['id_order'], $doc_public_url, $inv_nr, $invoice['id']);

        //Send via email if needed
        if ($settings['send_email'] && !$settings['send_enable'] && $invoice_data['type'] != PWSBillingo::INVOICE_TYPE_DRAFT) {
            if (!$connector->sendInvoice($invoice['id'])) {
                //$response['messages'][] = 'Error: billingo invoice email failed';
            }
        }

        return $doc_public_url;
    }

    public function saveBillingoData($id_order, $doc_public_url, $inv_nr, $invoice_id)
    {
        $objectManager = ObjectManager::getInstance();
        $billingodata = $objectManager->create('PWS\Billingo\Model\Billingo');
        $billingodata->setIdOrder($id_order);
        $billingodata->setLink($doc_public_url);
        $billingodata->setInvoiceId($invoice_id);
        $billingodata->setInvoiceNr($inv_nr);
        $billingodata->setDateAdd(date('Y-m-d H:i:s'));
        $billingodata->save();
    }

    public function getBillingoData($id_order)
    {
        $objectManager = ObjectManager::getInstance();
        $collection = $objectManager->create('PWS\Billingo\Model\Billingo')->getCollection()->getData(); // todo filter

        if (is_array($collection)) {
            foreach ($collection as $itm) {
                if ($itm['id_order'] == $id_order) {
                    return $itm;
                }
            }
        }

        return false;
    }

    public function _paymap($c)
    {
        $settings = $this->getConfigVars($this->_store_id);

        $paylist = [];

        $pm = json_decode($settings['paymentmap'], true) ?: [];

        foreach ($pm as $row) {
            $paylist[$row['field1']] = $row['field2'];
        }

        if (isset($paylist[$c])) {
            return $paylist[$c];
        }

        return PWSBillingo::DEFAULT_PAYMENT;
    }

    public function _paydlmap($c)
    {
        $settings = $this->getConfigVars($this->_store_id);

        $paylist = [];

        $pm = json_decode($settings['paymentmap'], true) ?: [];

        foreach ($pm as $row) {
            $paylist[$row['field1']] = $row['field3'];
        }

        if (isset($paylist[$c])) {
            return $paylist[$c];
        }

        return 14;
    }
}
