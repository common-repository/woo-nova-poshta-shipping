<?php

namespace WooNovaPoshtaShipping\App\Controllers;

if (!defined('ABSPATH')) {
    exit;
}

class WNPS_Order_Processing {

    public $cost;

    public function init(){
        add_action('woocommerce_checkout_update_order_meta', array($this, 'wnps_custom_checkout_field_update_order_meta'));
    }

    public function wnps_custom_checkout_field_update_order_meta($order_id){
        if (!empty($_POST['wnps_area'])) {
            update_post_meta($order_id, 'area' , sanitize_text_field($_POST['wnps_area'] ));
        }
        if (!empty($_POST['wnps_city'])) {
            update_post_meta($order_id, 'city' , sanitize_text_field($_POST['wnps_city'] ));
        }
        if (!empty($_POST['wnps_warehouse'])) {
            update_post_meta($order_id, 'warehouse' , sanitize_text_field($_POST['wnps_warehouse'] ));
        }
        if (!empty($_POST['wnps_shippingtype'])){
            update_post_meta($order_id, 'shippingType', sanitize_text_field($_POST['wnps_shippingtype']));
        }
    }

}