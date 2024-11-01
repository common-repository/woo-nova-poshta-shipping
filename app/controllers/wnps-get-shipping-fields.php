<?php

namespace WooNovaPoshtaShipping\App\Controllers;

use WooNovaPoshtaShipping\App\Renders\WNPS_Settings_Render;
use WooNovaPoshtaShipping\App\BaseController;
use WooNovaPoshtaShipping\App\Helpers\WNPS_Helper_Request_Json;


class WNPS_Get_Shipping_Fields extends BaseController
{
    private $wnps_settings_render;
    private $wnps_request_json;
    private $wnps_request_areas;

    public function __construct(){
        $this->wnps_settings_render = new WNPS_Settings_Render();
        $this->wnps_request_json = new WNPS_Helper_Request_Json();
        $this->wnps_request_areas = new WNPS_Settings();
    }


    /**
     * Init options
     *
     * @return void
     */
    public function init(){
        add_action( "wp_ajax_wnps_get_areas", array($this, 'wnps_get_areas') );
        add_action( "wp_ajax_wnps_get_cities", array($this, 'wnps_get_cities') );
        add_action( "wp_ajax_wnps_get_warehouses", array($this, 'wnps_get_warehouses') );
        add_action( "wp_ajax_nopriv_wnps_get_areas", array($this, 'wnps_get_areas') );
        add_action( "wp_ajax_nopriv_wnps_get_cities", array($this, 'wnps_get_cities') );
        add_action( "wp_ajax_nopriv_wnps_get_warehouses", array($this, 'wnps_get_warehouses') );
        add_action( "wp_ajax_wnps_get_city_recepient", array($this, 'wnps_get_city_recepient') );
        add_action( "wp_ajax_nopriv_wnps_get_city_recepient", array($this, 'wnps_get_city_recepient') );
    }

    public function wnps_get_city_recepient(){
        global $wpdb;
        $city = sanitize_text_field($_GET['city']);
        $result = $wpdb->get_row("SELECT * FROM wp_novaposhta_cities WHERE Description = '$city'", OBJECT);
        echo json_encode($result->Ref);
        wp_die();
    }

    public function wnps_get_areas(){
        $areas = $this->wnps_request_areas->wnps_preload_addresses();

        echo json_encode($areas);

        wp_die();
    }

    public function wnps_get_cities(){
        $cities = $this->wnps_request_areas->wnps_preload_cities();

        echo json_encode($cities);

        wp_die();
    }

    public function wnps_get_warehouses(){
        $warehouses = $this->wnps_request_areas->wnps_preload_warehouses();

        echo json_encode($warehouses);

        wp_die();
    }

}
