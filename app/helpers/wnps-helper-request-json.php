<?php

namespace WooNovaPoshtaShipping\App\Helpers;

use WooNovaPoshtaShipping\App\Api\WNPS_API_Connector;

if (!defined('ABSPATH')) {
    exit;
}

class WNPS_Helper_Request_Json
{
    public function __construct()
    {
        $key = get_option('woocommerce_novaposhta_settings');
        $this->apiKey = $key['api'];

    }

    public function wnps_getAreas()
    {
        $data['modelName'] = 'Address';
        $data['calledMethod'] = 'getAreas';
        $data['apiKey'] = $this->apiKey;

        return $this->wnps_sendRequest($data);
    }

    public function wnps_getCities()
    {
        $data['modelName'] = 'Address';
        $data['calledMethod'] = 'getCities';
        $data['apiKey'] = $this->apiKey;

        return $this->wnps_sendRequest($data);
    }

    public function wnps_getWarehouses()
    {
        $data['modelName'] = 'AddressGeneral';
        $data['calledMethod'] = 'getWarehouses';
        $data['apiKey'] = $this->apiKey;

        return $this->wnps_sendRequest($data);
    }

    public function wnps_sendRequest($data)
    {
        return json_decode((new WNPS_API_Connector())->wnps_send($data), true);
    }
}