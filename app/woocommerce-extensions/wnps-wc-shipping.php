<?php

use WooNovaPoshtaShipping\App\Controllers\WNPS_Order_Processing;
use WooNovaPoshtaShipping\App\DB\WNPS_DB;

add_action( "woocommerce_shipping_init", "wnps_wc_shipping_init" );
add_filter( "woocommerce_shipping_methods", "wnps_wc_shipping_method" );

function wnps_wc_shipping_init(){
    if(!class_exists('WC_WNPS_Woo_Shipping')){
        class WC_WNPS_Woo_Shipping extends WC_Shipping_Method{

            public function __construct()
            {
                $this->id = 'nova_poshta_shipping';
                $this->method_title = __('Nova Poshta', WNPS_DOMAIN);
                $this->method_description = __('Nova Poshta shipping', WNPS_DOMAIN);

                $this->availability = 'including';
                $this->countries = array(
                    'UA'
                );
                $this->init();

                $this->title = $this->settings['title'];
                $this->subtitle = $this->settings['subtitle'];
                $this->enabled = $this->settings['enabled'];
                $this->myarea = $this->settings['myarea'];
                $this->mycity = $this->settings['mycity'];
                $this->mywarehouse = $this->settings['mywarehouse'];
            }

            public function init(){
                $this->init_form_fields();
                $this->init_settings();
                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }

            public function init_form_fields(){

                $npdb = WNPS_DB::getInstance();

                $areas = $npdb->get_data("*", "novaposhta_areas");
                $areas_keys = [];
                $areas_values = [];

                $cities = $npdb->get_data("*", "novaposhta_cities");
                $cities_keys = [];
                $cities_values = [];

                $warehouses = $npdb->get_data("*", "novaposhta_warehouses");
                $warehouses_keys = [];
                $warehouses_values = [];

                foreach($cities as $city){
                    array_push($cities_keys, $city['Ref']);
                    array_push($cities_values, $city['Description']);
                }

                foreach($areas as $area){
                    array_push($areas_keys, $area['Ref']);
                    array_push($areas_values, $area['Description']);
                }

                foreach($warehouses as $warehouse){
                    array_push($warehouses_keys, $warehouse['Ref']);
                    array_push($warehouses_values, $warehouse['Description']);
                }

                $filled_areas = array_combine($areas_keys, $areas_values);
                $filled_cities = array_combine($cities_keys, $cities_values);
                $filled_warehouses = array_combine($warehouses_keys, $warehouses_values);

                $this->form_fields = array(
                    'enabled' => array(
                        'title' => __('Підключити', WNPS_DOMAIN),
                        'label' => __('Підключити Нову Пошту', WNPS_DOMAIN),
                        'type' => 'checkbox',
                        'description' => '',
                        'default' => 'no'
                    ),
                    'title' => array(
                        'title' => __('Нова Пошта', WNPS_DOMAIN),
                        'type' => 'text',
                        'description' => __('Назва способу доставки на сторінці чекауту', WNPS_DOMAIN),
                        'default' => __('Nova Poshta', WNPS_DOMAIN)
                    ),
                    'subtitle' => array(
                        'title' => __('Nova Poshta', WNPS_DOMAIN),
                        'type' => 'text',
                        'description' => __('Опис способу доставки на сторінці чекауту', WNPS_DOMAIN),
                        'default' => __('Nova Poshta ', WNPS_DOMAIN)
                    ),
                    'myarea' => array(
                        'title' => __('Область', WNPS_DOMAIN),
                        'description' => __('Замініть на сторінці налаштувань плагіну', WNPS_DOMAIN),
                        'default' => '0',
                        'type' => 'text'

                    ),
                    'mycity' => array(
                        'title' => __('Місто', WNPS_DOMAIN),
                        'type' => 'text',
                        'description' => __('Замініть на сторінці налаштувань плагіну', WNPS_DOMAIN),
                        'default' => '1',
                    ),
                    'mywarehouse' => array(
                        'title' => __('Відділення', WNPS_DOMAIN),
                        'type' => 'text',
                        'description' => __('Замініть на сторінці налаштувань плагіну', WNPS_DOMAIN),
                        'default' => '0'
                    ),
                    'api' => array(
                        'title' => __( 'API ключ', WNPS_DOMAIN ),
                        'type' => 'text',
                        'description' => __( 'API ключ з особистого кабінету НП', WNPS_DOMAIN ),
                        'default' => '18yfhia8rdh12o13418fdsd'
                    ),
                );
            }

            public function calculate_shipping($package = array()){
                global $woocommerce;

                $order_processing = new WNPS_Order_Processing();
                $weight = $woocommerce->cart->cart_contents_weight;                
                $cost = $order_processing;
               
                $rate = array(
                    'id' => $this->id,
                    'label' => $this->title,
                    'cost' => WC()->session->get('new_shipping_cost'),
                    'calc_tax' => 'per_item'
                );

                $this->add_rate( $rate ); 
            }

        }
    }
}

function wnps_wc_shipping_method($methods){
    $methods['nova_poshta_shipping'] = 'WC_WNPS_Woo_Shipping';
    return $methods;
}