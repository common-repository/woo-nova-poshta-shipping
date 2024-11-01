<?php

namespace WooNovaPoshtaShipping\App\Api;

final class WNPS_API_Connector{

    private $data;
    private $url = "https://api.novaposhta.ua/v2.0/json/";
    
    public function wnps_send($data){
        $result = wp_remote_post($this->url, array(
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'timeout' => 30,
            'body' => json_encode($data)
        ));
        $this->data = $result;
        return $this->data['body'];
    }

}