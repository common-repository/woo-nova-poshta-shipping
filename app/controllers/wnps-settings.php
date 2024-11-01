<?php

namespace WooNovaPoshtaShipping\App\Controllers;

use WooNovaPoshtaShipping\App\Renders\WNPS_Settings_Render;
use WooNovaPoshtaShipping\App\BaseController;
use WooNovaPoshtaShipping\App\Helpers\WNPS_Helper_Request_Json;
use WooNovaPoshtaShipping\App\DB\WNPS_DB;


class WNPS_Settings extends BaseController{

    private $wnps_settings_render;
    private $wnps_request_json;

    public function __construct(){
        $this->wnps_settings_render = new WNPS_Settings_Render();
        $this->wnps_request_json = new WNPS_Helper_Request_Json();
    }

    /**
     * Init options
     *
     * @return void
     */
    public function init(){
        add_action( "admin_menu", array($this, 'wnps_show_menu') );
        add_action( "wp_ajax_wnps_save_settings", array($this, 'wnps_save_settings') );
        add_action( "wp_ajax_wnps_load_addresses", array($this, 'wnps_load_addresses') );
        add_action( "wp_ajax_wnps_preload_addresses", array($this, 'wnps_preload_addresses') );
        add_action( "wp_ajax_wnps_preload_cities", array($this, 'wnps_preload_cities') );
        add_action( "wp_ajax_wnps_preload_warehouses", array($this, 'wnps_preload_warehouses') );
    }

    /**
     * Create menu
     *
     * @return void
     */
    public function wnps_show_menu(){
        add_menu_page(
            "Nova Poshta", 
            "Nova Poshta", 
            "manage_options", 
            "nova_poshta", 
            array($this, "wnps_add_atributes_to_render"),
            WNPS_PATH . "assets/images/novaposhta-logo.png", 
            4 
        );
    }

    /**
     * Adding attributes to render
     *
     * @return void
     */
    public function wnps_add_atributes_to_render(){
        $npdb = WNPS_DB::getInstance();
        $data = get_option("woocommerce_nova_poshta_shipping_settings");
        if(empty($data)){
            $data = array(
                'enabled' => 'no',
                'title' => '0',
                'subtitle' => '0',
                'api' => '0',
                'myarea' => '0',
                'mycity' => '0',
                'mywarehouse' => '0',
                'attr' => '0',
                'warehouse_ref' => '0',
            );
        }
        else{
            $warehouse_desc = $data['mywarehouse'];
            $warehouse_info = $npdb->get_data("*", "novaposhta_warehouses", "WHERE `Description` = '$warehouse_desc'");
            @$warehouse_ref = $warehouse_info[0]['Ref'];
            $data += array("warehouse_ref" => $warehouse_ref);
        }
        $this->wnps_settings_render->wnps_render($data);
    }

    public function wnps_save_settings(){
        global $wpdb;

        $idArea =  sanitize_text_field($_POST['myarea']);
        $idCity =  sanitize_text_field($_POST['mycity']);
        $idWarehouse =  sanitize_text_field($_POST['mywerehouse']);

        $npArea = $wpdb->get_results("SELECT Description FROM  wp_novaposhta_areas WHERE Ref = '" .$idArea. "'", ARRAY_A);
        $npCity = $wpdb->get_results("SELECT Description FROM  wp_novaposhta_cities WHERE Ref = '" . $idCity . "'", ARRAY_A);
        $npWarehouse = $wpdb->get_results("SELECT Description FROM  wp_novaposhta_warehouses WHERE Ref = '" . $idWarehouse . "'", ARRAY_A);

        $areaOutput = $npArea[0]['Description'];
        $cityOutput = $npCity[0]['Description'];
        $warehouseOutput = $npWarehouse[0]['Description'];

        $data = array(
            'enabled' => ($_POST['enabled'] == 1) ? "yes" : "no",
            'title' => sanitize_text_field($_POST['title']),
            'subtitle' => sanitize_text_field($_POST['subtitle']),
            'api' => sanitize_text_field($_POST['api']),
            'myarea' => $areaOutput,
            'mycity' => $cityOutput,
            'mywarehouse' => $warehouseOutput,
            'attr' => $idArea
        );

        update_option( "woocommerce_nova_poshta_shipping_settings", $data );
        echo "success";

        wp_die();
    }

    /**
     * Ajax callback for taking statements
     *
     * @return void
     */
    public function wnps_ajax_take_areas(){
        $result = get_option("woocommerce_nova_poshta_shipping_method_settings");

        echo $this->wnps_settings->wnps_save_settings($result, $this->db);

        wp_die();
    }

    public function wnps_load_addresses(){
        $npdb = WNPS_DB::getInstance();
        // $obj = new \ReflectionObject($this->wnps_request_json);
        // var_dump($obj->getMethods());
        // wp_die();
        $areas = $this->wnps_request_json->wnps_getAreas();
        $cities = $this->wnps_request_json->wnps_getCities();
        $warehouses = $this->wnps_request_json->wnps_getWarehouses();
        
        

        $npdb->clear_table("novaposhta_areas");

        foreach($areas['data'] as $area){
            $npdb->insert_data("novaposhta_areas", $area, array());
        }

        $npdb->clear_table("novaposhta_cities");

        foreach($cities['data'] as $city){
            $npdb->insert_data("novaposhta_cities", $city, array());
        }
        
        $npdb->clear_table("novaposhta_warehouses");
        foreach($warehouses['data'] as $warehouse){
            $npdb->insert_data("novaposhta_warehouses", $warehouse, array());
        }

        echo json_encode($warehouses);

        wp_die();
    }

    public function wnps_preload_addresses(){
        $data = WNPS_DB::getInstance()->get_data("*", "novaposhta_areas");

        echo json_encode($data);
        
        wp_die();
    }

    public function wnps_preload_cities(){
        $area_ref = sanitize_text_field($_GET['area']);

        $cities = WNPS_DB::getInstance()->get_data("*", "novaposhta_cities", "WHERE `Area` = '$area_ref'");

        echo json_encode($cities);

        wp_die();
    }

    public function wnps_preload_warehouses(){
        $city_ref = sanitize_text_field($_GET['city']);

        $warehouses = WNPS_DB::getInstance()->get_data("*", "novaposhta_warehouses", "WHERE `CityDescription` = '$city_ref'");
        
        echo json_encode($warehouses);

        wp_die();
    }

}