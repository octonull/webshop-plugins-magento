<?php
/**
 * Created by PWS Online Kft.
 *
 * @author    Viktor Vizmeg <info@pws-online.com>
 * @copyright 2021 PWS Online Kft.
 * @license   Copyright 2021 PWS Online Kft.
 * @date      2021-04-16
 * @time      14:50
 */

namespace PWS\Billingo\lib; // !namespace modified for magento!

class PWSBillingo
{
    const VERSION = '3.2.0';

    const REMOTE_HOST = 'https://api.billingo.hu/v3/'; // with trailing slash!
    const ALL_COUNTRIES = [
        'AC', 'AD', 'AE', 'AF', 'AG', 'AI', 'AL', 'AM', 'AO', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AW', 'AX', 'AZ', 'BA', 'BB', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BL', 'BM', 'BN', 'BO', 'BQ', 'BR', 'BS', 'BT', 'BW', 'BY', 'BZ',
        'CA', 'CC', 'CD', 'CF', 'CG', 'CH', 'CI', 'CK', 'CL', 'CM', 'CN', 'CO', 'CR', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ', 'DE', 'DG', 'DJ', 'DK', 'DM', 'DO', 'DZ', 'EA', 'EC', 'EE', 'EG', 'EH', 'ER', 'ES', 'ET', 'FI', 'FJ', 'FK', 'FM', 'FO', 'FR',
        'GA', 'GB', 'GD', 'GE', 'GF', 'GG', 'GH', 'GI', 'GL', 'GM', 'GN', 'GP', 'GQ', 'GR', 'GS', 'GT', 'GU', 'GW', 'GY', 'HK', 'HN', 'HR', 'HT', 'HU', 'IC', 'ID', 'IE', 'IL', 'IM', 'IN', 'IO', 'IQ', 'IR', 'IS', 'IT', 'JE', 'JM', 'JO', 'JP',
        'KE', 'KG', 'KH', 'KI', 'KM', 'KN', 'KP', 'KR', 'KW', 'KY', 'KZ', 'LA', 'LB', 'LC', 'LI', 'LK', 'LR', 'LS', 'LT', 'LU', 'LV', 'LY',
        'MA', 'MC', 'MD', 'ME', 'MF', 'MG', 'MH', 'MK', 'ML', 'MM', 'MN', 'MO', 'MP', 'MQ', 'MR', 'MS', 'MT', 'MU', 'MV', 'MW', 'MX', 'MY', 'MZ', 'NA', 'NC', 'NE', 'NF', 'NG', 'NI', 'NL', 'NO', 'NP', 'NR', 'NU', 'NZ',
        'OM', 'PA', 'PE', 'PF', 'PG', 'PH', 'PK', 'PL', 'PM', 'PN', 'PR', 'PS', 'PT', 'PW', 'PY', 'QA', 'RE', 'RO', 'RS', 'RU', 'RW', 'SA', 'SB', 'SC', 'SD', 'SE', 'SG', 'SH', 'SI', 'SJ', 'SK', 'SL', 'SM',
        'SN', 'SO', 'SR', 'SS', 'ST', 'SV', 'SX', 'SY', 'SZ', 'TA', 'TC', 'TD', 'TF', 'TG', 'TH', 'TJ', 'TK', 'TL', 'TM', 'TN', 'TO', 'TR', 'TT', 'TV', 'TW', 'TZ',
        'UA', 'UG', 'UM', 'US', 'UY', 'UZ', 'VA', 'VC', 'VE', 'VG', 'VI', 'VN', 'VU', 'WF', 'WS', 'XA', 'XB', 'XK', 'YE', 'YT', 'ZA', 'ZM', 'ZW',
    ];
    const EU_COUNTRIES = ['AT', 'BE', 'HR', 'BG', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE'];
    const ALL_CURRENCIES = ['AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CNY', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HRK', 'HUF', 'IDR', 'ILS', 'INR', 'ISK', 'JPY', 'KRW', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RSD', 'RUB', 'SEK', 'SGD', 'THB', 'TRY', 'UAH', 'USD', 'ZAR'];
    const ALL_ENTITLEMENTS = ['AAM', 'ANTIQUES', 'ARTWORK', 'ATK', 'EAM', 'EUE', 'EUFAD37', 'EUFADE', 'HO', 'KBAET', 'NAM_1', 'NAM_2', 'SECOND_HAND', 'TAM', 'TRAVEL_AGENCY'];
    const ALL_PARTNERTAXTYPE = ['FOREIGN', 'HAS_TAX_NUMBER', 'NO_TAX_NUMBER'];
    const DEFAULT_PAYMENT = 'cash';
    const ALL_PAYMENTS = [
        'aruhitel'         => 'Áruhitel',
        'bankcard'         => 'Bankkártya',
        'barion'           => 'Barion',
        'barter'           => 'Barter',
        'cash'             => 'Készpénz',
        'cash_on_delivery' => 'Utánvét',
        'coupon'           => 'Kupon',
        'elore_utalas'     => 'Előreutalás',
        'ep_kartya'        => 'Egészségpénztári kártya',
        'kompenzacio'      => 'Kompenzáció',
        'levonas'          => 'Levonás',
        'online_bankcard'  => 'Online bankkártya',
        'paylike'          => 'Paylike',
        'payoneer'         => 'Payoneer',
        'paypal'           => 'PayPal',
        'paypal_utolag'    => 'PayPal – Utólag fizetve',
        'payu'             => 'PayU',
        'pick_pack_pont'   => 'Pick Pack',
        'postai_csekk'     => 'Postai csekk',
        'postautalvany'    => 'Postautalvány',
        'skrill'           => 'Skrill',
        'szep_card'        => 'SZÉP kártya',
        'transferwise'     => 'Transferwise',
        'upwork'           => 'Upwork',
        'utalvany'         => 'Utalvány',
        'valto'            => 'Váltó',
        'wire_transfer'    => 'Átutalás',
    ];
    const UNIT_PRICE_TYPES = ['net', 'gross'];
    const PRICE_TYPE_NET = 'net';
    const PRICE_TYPE_GROSS = 'gross';
    const INVOICE_TYPE_LIST = ['advance', 'cancellation', 'draft', 'invoice', 'modification', 'proforma'];
    const ALL_LANGUAGES = [
        'de' => 'Német',
        'en' => 'Angol',
        'fr' => 'Francia',
        'hr' => 'Horvát',
        'hu' => 'Magyar',
        'it' => 'Olasz',
        'ro' => 'Román',
        'sk' => 'Szlovák',
    ];
    const ALL_ROUNDS = [
        'five' => '5-re',
        'none' => 'Nincs',
        'one'  => '1-re',
        'ten'  => '10-re',
    ];
    const ALL_TAXES = ['0%', '1%', '10%', '11%', '12%', '13%', '14%', '15%', '16%', '17%', '18%', '19%', '2%', '20%', '21%', '22%', '23%', '24%', '25%', '26%', '27%',
        '3%', '4%', '5%', '6%', '7%', '7,7%', '8%', '9%', '9,5%', 'AAM', 'AM', 'EU', 'EUK', 'F.AFA', 'FAD', 'K.AFA', 'MAA', 'TAM', 'ÁKK', 'ÁTHK'];

    const INVOICE_TYPE_DRAFT = 'draft';
    const INVOICE_TYPE_PROFORMA = 'proforma';
    const INVOICE_TYPE_INVOICE = 'invoice';
    const INVOICE_TYPE_STORNO = 'cancellation';


    public static $tax_override = -1; // global override
    public static $tax_override_zero = -1; // override if 0%
    public static $tax_override_eu = false; // EU/EUK override
    public static $tax_override_include_carrier = false; // include carrier in global override
    public static $tax_override_entitlement = '';
    public static $tax_override_zero_entitlement = '';
    public static $country_code = '';

    public $log_file;
    public $log_fp;
    public $api_key;
    public $plugin_name;
    public $plugin_version;

    public $skip_decode = false;
    public $last_response;
    public $last_response_code = 0;

    public function __construct($api_key, $log_file, $plugin_name = 'Billingo X', $plugin_version = '3.0.0')
    {
        $this->api_key = $api_key;
        $this->log_file = $log_file;
        $this->plugin_name = $plugin_name;
        $this->plugin_version = $plugin_version;

        $log_dir = dirname($this->log_file);
        if (!file_exists($log_dir)) {
            mkdir($log_dir, 0755, true);
            static::createHtaccessInDir($log_dir);
        }
        $this->log_fp = fopen($this->log_file, 'a');
    }

    public function logw($msg, ...$params)
    {
        fwrite($this->log_fp, date('Y-m-d H:i:s') . $msg . ((is_array($params) && count($params)) ? print_r($params, true) : '') . PHP_EOL);
    }

    /**
     * Generate URL
     * @param $uri
     * @param array $data
     * @return string
     */
    public function getURL($uri, $data = [])
    {
        $uri = trim($uri, '/');
        $url = static::REMOTE_HOST . $uri;

        if (count($data) > 0) {
            $url .= '?' . http_build_query($data);
        }

        return $url;
    }

    /**
     * Make a request to the Billingo API
     * @param string $method GET|POST|PUT|DELETE
     * @param string $uri
     * @param array $data
     * @return bool|array
     */
    public function request($method, $uri, $data = [])
    {
        if (!$this->api_key) {
            return false;
        }

        $curl = curl_init();
        $headers = [
            'X-API-KEY: ' . $this->api_key,
            'X-Plugin-Name: ' . $this->plugin_name,
            'X-Plugin-Version: ' . $this->plugin_version,
            'Accept: application/json',
        ];

        $method = strtoupper($method);

        // get the key to use for the query
        if ($method != 'GET' && $method != 'DELETE') {
            $json_string = json_encode($data);

            $headers[] = 'Content-type: application/json';
            $headers[] = 'Content-length: ' . strlen($json_string);

            curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);
            $data = [];
        }

        $url = $this->getURL($uri, $data);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $this->last_response = curl_exec($curl);
        $this->last_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $cerror = curl_error($curl);
        $cerrno = curl_errno($curl);
        curl_close($curl);

        // logging
        if ($this->log_file) {
            $log_dir = dirname($this->log_file);
            if (!file_exists($log_dir)) {
                mkdir($log_dir, 0755, true);
                static::createHtaccessInDir($log_dir);
            }

            $fl = fopen($this->log_file, 'a');
            fwrite($fl, date('Y-m-d H:i:s') . PHP_EOL);
            fwrite($fl, 'URL: ' . $url . ' | Method: ' . $method . PHP_EOL);
            fwrite($fl, 'Header: ' . print_r($headers, true) . PHP_EOL);
            if (isset($json_string)) {
                fwrite($fl, 'Post: ' . print_r($json_string, true) . PHP_EOL);
            }
            fwrite($fl, 'Response: ' . $this->last_response_code . ' | ' . $this->last_response . PHP_EOL);
            fwrite($fl, 'cUrlError: ' . $cerrno . ' | ' . $cerror . PHP_EOL . PHP_EOL);
            fclose($fl);
        }

        if ($this->skip_decode) {
            return $this->last_response;
        }

        $json_data = json_decode($this->last_response, true);

        return $json_data ?: $this->last_response;
    }

    /**
     * GET
     * @param $uri
     * @param array $data
     * @return mixed
     */
    public function get($uri, array $data = [])
    {
        return $this->request('GET', $uri, $data);
    }

    /**
     * POST
     * @param $uri
     * @param array $data
     * @return mixed
     */
    public function post($uri, array $data = [])
    {
        return $this->request('POST', $uri, $data);
    }

    /**
     * PUT
     * @param $uri
     * @param array $data
     * @return mixed
     */
    public function put($uri, array $data = [])
    {
        return $this->request('PUT', $uri, $data);
    }


    /**
     * DELETE
     * @param $uri
     * @param array $data
     * @return mixed
     */
    public function delete($uri, array $data = [])
    {
        return $this->request('DELETE', $uri, $data);
    }


    // -----------------------------------------------------------------------------------------------------------------
    // request wrappers

    /**
     * Get ogranization data from billingo API
     * Used for testing API connection. (tax_code)
     *
     * @return mixed
     */
    public function getOrganization()
    {
        $organization = $this->get('/organization');

        if (!is_array($organization)) {
            $this->logw('getOrganization FAILED');
            return false;
        }

        return $organization;
    }

    /**
     * Get currency rate from billingo API
     * @param string $from from currency ISO3 code
     * @param string $to to currency ISO3 code
     * @return float
     */
    public function getCurrencyRate($from, $to)
    {
        $response = $this->get('currencies', ['from' => $from, 'to' => $to]);

        if (is_array($response) && array_key_exists('conversation_rate', $response)) {
            return $response['conversation_rate'];
        }

        $this->logw('getCurrencyRate FAILED');
        return 1.0;
    }

    /**
     * Create billingo partner
     * @param array $client_data
     * @param array $address_data
     * @return mixed
     */
    public function createPartner(array $client_data, array $address_data)
    {
        if (!array_key_exists('tax_type', $client_data)) {
            $client_data['tax_type'] = static::getPartnerTaxType($address_data['country_code'], $client_data['taxcode']);
        }

        $client_data['address'] = $address_data;

        $partner = $this->post('partners', $client_data);


        if (!is_array($partner) || !array_key_exists('id', $partner)) {
            $this->logw('createPartner FAILED');
            return false;
        }

        return $partner;
    }

    /**
     * Create billingo partner and only return ID
     * @param array $client_data
     * @param array $address_data
     * @return bool|int
     */
    public function createPartnerAndGetId(array $client_data, array $address_data)
    {
        $partner = $this->createPartner($client_data, $address_data);
        if (is_array($partner) && array_key_exists('id', $partner)) {
            return $partner['id'];
        }

        return false;
    }

    /**
     * Create new invoice (draft/proforma/invoice)
     * @param array $invoice_data
     * @return mixed
     */
    public function createInvoice(array $invoice_data)
    {
        $this->setCurrencyRate($invoice_data);

        $document = $this->post('documents', $invoice_data);

        if (!is_array($document) || !array_key_exists('id', $document)) {
            $this->logw('createInvoice FAILED');
            return false;
        }

        return $document;
    }

    /**
     * Storno existing invoice
     * @param int $id_invoice
     * @return mixed
     */
    public function cancelInvoice($id_invoice)
    {
        $document = $this->post('documents/' . $id_invoice . '/cancel');

        if (!is_array($document) || !array_key_exists('id', $document)) {
            $this->logw('cancelInvoice FAILED');
            return false;
        }

        return $document;
    }

    /**
     * Create invoice from existing proforma invoice
     * @param int $id_proforma
     * @return mixed
     */
    public function createInvoiceFromProforma($id_proforma)
    {
        $document = $this->post('/documents/' . $id_proforma . '/create-from-proforma');

        if (!is_array($document) || !array_key_exists('id', $document)) {
            $this->logw('createInvoiceFromProforma FAILED');
            return false;
        }

        return $document;
    }

    /**
     * Get invoice by ID
     * @param int $id_invoice
     * @return mixed
     */
    public function getInvoiceById($id_invoice)
    {
        $document = $this->get('documents/' . $id_invoice);

        if (!is_array($document) || !array_key_exists('id', $document)) {
            $this->logw('getInvoiceById FAILED');
            return false;
        }

        return $document;
    }

    /**
     * Get invoice number by invoice ID
     * @param int $id_invoice
     * @return bool|string
     */
    public function getInvoiceNumberById($id_invoice)
    {
        $document = $this->getInvoiceById($id_invoice);
        if (is_array($document) && array_key_exists('invoice_number', $document)) {
            return $document['invoice_number'];
        }

        return false;
    }

    /**
     * Convert old V2 API ID to V3 API ID
     * @param int $id_v2
     * @return bool|int
     */
    public function convertV2IdToV3($id_v2)
    {
        $result = $this->get('/utils/convert-legacy-id/' . $id_v2);
        if (is_array($result) && array_key_exists('id', $result)) {
            return $result['id'];
        }

        $this->logw('convertV2IdToV3 FAILED');
        return false;
    }

    /**
     * Get public url (download link)
     * @param int $id_invoice
     * @return bool|string
     */
    public function getDownloadLinkById($id_invoice)
    {
        $result = $this->get('/documents/' . $id_invoice . '/public-url');
        if (is_array($result) && array_key_exists('public_url', $result)) {
            return $result['public_url'];
        }

        $this->logw('getDownloadLinkById FAILED');
        return false;
    }

    /**
     * Trigger billingo invoice e-mail sending
     * @param int $id_invoice
     * @return bool
     */
    public function sendInvoice($id_invoice)
    {
        $response = $this->post('/documents/' . $id_invoice . '/send');

        if (!is_array($response) || !array_key_exists('emails', $response)) {
            $this->logw('sendInvoice FAILED');
            return false;
        }

        return true;
    }

    public function getBankAccounts()
    {
        $response = $this->get('/bank-accounts');

        if (!is_array($response) || !array_key_exists('data', $response)) {
            $this->logw('getBankAccounts FAILED');
            return ['' => 'API Error, is the API Key set?'];
        }

        $list = ['' => ''];
        foreach ($response['data'] as $account) {
            $list[$account['id']] = $account['name'] . ' (' . $account['currency'] . ')';
        }

        return $list;
    }

    public function getDocumentBlocks()
    {
        $response = $this->get('/document-blocks');

        if (!is_array($response) || !array_key_exists('data', $response)) {
            $this->logw('getBlocks FAILED');
            return ['' => 'API Error, is the API Key set?'];
        }

        $list = ['' => ''];
        foreach ($response['data'] as $account) {
            $list[$account['id']] = $account['name'] . ' (' . $account['prefix'] . ')';
        }

        return $list;
    }

    public function downloadPDF($id_invoice, $target_file)
    {
        $this->skip_decode = true;
        $response = $this->get('/documents/' . $id_invoice . '/download');
        $this->skip_decode = false;

        if ($this->last_response_code !== 200) {
            return false;
        }

        $dir = dirname($target_file);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
            static::createHtaccessInDir($dir);
        }

        return file_put_contents($target_file, $response);
    }

    // -----------------------------------------------------------------------------------------------------------------
    // helper functions

    /**
     * Get tax type for partner
     *
     * @param string $billing_country Billing country of the partner (iso2)
     * @param string $tax_number Tax number of the partner
     *
     * @return string
     */
    public static function getPartnerTaxType($billing_country, $tax_number)
    {
        if ($billing_country == 'HU') {
            return empty(trim($tax_number)) ? 'NO_TAX_NUMBER' : 'HAS_TAX_NUMBER';
        }

        return 'FOREIGN';
    }

    /**
     * Sets conversion_rate for invoice
     * @param array $invoice_data
     */
    public function setCurrencyRate(array &$invoice_data)
    {
        if ($invoice_data['currency'] == 'HUF') {
            $invoice_data['conversion_rate'] = 1;
        }

        $invoice_data['conversion_rate'] = $this->getCurrencyRate($invoice_data['currency'], 'HUF');
    }


    /**
     * Return translatable payment method name from lib-enum key
     * @param string $payment_method
     * @return string
     */
    public static function getTranslatablePaymentMethodName($payment_method)
    {
        if (array_key_exists($payment_method, static::ALL_PAYMENTS)) {
            return static::ALL_PAYMENTS[$payment_method];
        }

        return 'Ismeretlen';
    }

    /**
     * Create debug string and encode it.
     * @param array $data data to add to the debug string (recommended: plugin version, shop system version)
     * @return array array with normal and encoded debug string
     */
    public static function getDebugData(array $data)
    {
        $debug_data = [
            'date' => date('Y-m-d H:i:s'),
            'PHP_version' => phpversion(),
            'PHP_memory_limit' => ini_get('memory_limit'),
            'PHP_cURL' => function_exists('curl_version') ? (curl_version()['version']) : 'no',
            'server' => $_SERVER['SERVER_SOFTWARE'],
            'host' => $_SERVER['SERVER_NAME'],
        ];
        $debug_data = array_merge($debug_data, $data);

        $debug_normal = '';
        foreach ($debug_data as $key => $val) {
            $debug_normal .= $key . ': ' . $val . PHP_EOL;
        }
        $debug = base64_encode($debug_normal);

        return [$debug_normal, $debug];
    }

    /**
     * Return partner hash for partner ID storage/search
     * @param string $api_key
     * @param array $client_data
     * @param array $address_data
     * @return string
     */
    public static function hashPartnerData($api_key, array $client_data, array $address_data)
    {
        return md5($api_key . serialize(array_merge($client_data, $address_data)));
    }

    /**
     * Return partner hash for partner ID storage/search
     * @deprecated since 3.1
     * @param array $client_data
     * @param array $address_data
     * @return string
     */
    public static function hashPartnerDataOld(array $client_data, array $address_data)
    {
        return md5(serialize(array_merge($client_data, $address_data)));
    }

    /**
     * Fix URLs stored from V2 API
     * @param string $url
     * @return string
     */
    public static function getV2FixedUrl($url)
    {
        if (strpos($url, 'http') !== false) {
            return $url; // v3 links: full url
        } else {
            return 'https://www.billingo.hu/access/c:' . $url; // v2 links: only the document id was stored
        }
    }

    /**
     * Set tax overrides
     * @param int $tax_override
     * @param int $tax_override_zero
     * @param bool $tax_override_eu
     * @param bool $tax_override_include_carrier
     */
    public static function setTaxOverrides($tax_override = -1, $tax_override_zero = -1, $tax_override_eu = false, $tax_override_include_carrier = false)
    {
        static::$tax_override = $tax_override;
        static::$tax_override_zero = $tax_override_zero;
        static::$tax_override_eu = $tax_override_eu;
        static::$tax_override_include_carrier = $tax_override_include_carrier;
    }

    /**
     * Set country for isEuCountry check
     * @param string $country_code country code (iso2)
     */
    public static function setCountryCodeForVat($country_code)
    {
        static::$country_code = $country_code;
    }

    /**
     * Set entitelment values to be used with TAX overrides
     * @param string $tax_override_entitlement
     * @param string $tax_override_zero_entitlement
     */
    public static function setEntitlements($tax_override_entitlement = '', $tax_override_zero_entitlement = '')
    {
        static::$tax_override_entitlement = $tax_override_entitlement;
        static::$tax_override_zero_entitlement = $tax_override_zero_entitlement;
    }

    /**
     * Decide if country is EU country, excluding hungary
     * @param string $country_code (iso2)
     * @return int -1 for hungary, 1 if EU country, 0 otherwise
     */
    public static function isEuCountry($country_code)
    {
        return $country_code == 'HU' ? -1 : (in_array($country_code, static::EU_COUNTRIES) ? 1 : 0);
    }

    /**
     * Round to specified (one or zero) decimal, replace dot with comma and add % sign
     * @param float $value
     * @param int $round
     * @return string
     */
    public static function convertNumberToPercentage($value, $round = 0)
    {
        return str_replace('.', ',', round($value, $round) . '%');
    }

    /**
     * Returns the VAT rule and entitlement to be used
     *
     * @param int $percentage vat rate (example: 27)
     * @param bool $is_shipping
     *
     * @return array
     */
    public static function applyVatRule($percentage, $is_shipping = false)
    {
        $percentage_decimal = static::convertNumberToPercentage($percentage, 1);
        if (in_array($percentage_decimal, static::ALL_TAXES)) {
            $percentage = $percentage_decimal;
        } else {
            $percentage = static::convertNumberToPercentage($percentage, 0);
        }

        if (static::$tax_override_eu && (static::$tax_override_include_carrier || !$is_shipping)) {
            $is_eu_country = static::isEuCountry(static::$country_code);
            if ($is_eu_country !== -1) { // -1 means Hungary, skip
                return $is_eu_country ? ['vat' => 'EU',  'entitlement' => 'KBAET'] : ['vat' => 'EUK', 'entitlement' => 'EAM'];
            }
        }

        if (static::$tax_override_zero != -1 && $percentage == '0%' && (static::$tax_override_include_carrier || !$is_shipping)) {
            return ['vat' => static::$tax_override_zero, 'entitlement' => static::$tax_override_zero_entitlement];
        }

        if (static::$tax_override != -1 && (static::$tax_override_include_carrier || !$is_shipping)) {
            return ['vat' => static::$tax_override, 'entitlement' => static::$tax_override_entitlement];
        }

        return ['vat' => $percentage, 'entitlement' => ''];
    }

    /**
     * Index the array with it's values. (Used for old lib untranslated enum lists)
     * @param array $array
     * @return array
     */
    public static function indexArray(array $array)
    {
        $indexed_array = [];
        foreach ($array as $e) {
            $indexed_array[$e] = $e;
        }
        return $indexed_array;
    }

    /**
     * Write to specified log. Will auto-prefix filename with date.
     * @param string $dir
     * @param string $filename
     * @param string $message
     * @param null|mixed $value
     */
    public static function log($dir, $filename, $message, $value = null)
    {
        $dir = rtrim($dir, '/') . '/';
        $log_file = $dir . date('Y-m-d') . '_' . $filename;

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
            static::createHtaccessInDir($dir);
        }

        $fp = fopen($log_file, 'a');
        fwrite($fp, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL);
        if (isset($value)) {
            if (is_array($value)) {
                foreach($value as $k => $v) {
                    fwrite($fp, $k . ': [type: ' . gettype($v) . '] ' . serialize($v) . PHP_EOL);
                }
            } else {
                fwrite($fp, '[type: ' . gettype($value) . '] ' . serialize($value) . PHP_EOL);
            }
        }
        fwrite($fp, PHP_EOL);
        fclose($fp);
    }

    public static function createHtaccessInDir($dir)
    {
        $dir = rtrim($dir, '/') . '/';
        $fp = fopen($dir . '.htaccess', 'w');
        fwrite($fp, <<<STR
# Apache 2.2
<IfModule !mod_authz_core.c>
    Order deny,allow
    Deny from all
</IfModule>

# Apache 2.4
<IfModule mod_authz_core.c>
    Require all denied
</IfModule>
STR
        );
        fclose($fp);
    }
}

/*
 * Changelog
 * - 3.2.0 - 2022-07-08
 *   - Added function to download PDF
 *
 * - 3.1.5 - 2022-03-12
 *   - Added directory check before log fopen
 *
 * - 3.1.4 - 2021-10-20
 *   - Added getters for bank accounts and invoice blocks
 *
 * - 3.1.3 - 2021-09-24
 *   - Fix slash for .htaccess creation
 *
 * - 3.1.2 - 2021-09-??
 *   - Only allow 1-decimal tax value is exists in enum list
 *
 * - 3.1.1 - 2021-08-04
 *   - Added 9,5% tax value
 *   - Allow 1-decimal tax values
 *
 * - 3.1.0 - 2021-04-21
 *   - Expose last http response and response code
 *   - New partnerhash, includes api_key
 *   - Added consts for net/gross
 *
 * - 3.0.0 - 2021-04-16
 *   - Reborn from the ashes
 */
