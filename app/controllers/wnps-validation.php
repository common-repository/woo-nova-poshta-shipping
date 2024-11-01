<?php

namespace WooNovaPoshtaShipping\App\Controllers;

if (!defined('ABSPATH')) {
    exit;
}


class WNPS_Validation {

    public function init(){
        add_action('woocommerce_checkout_process', array($this, 'wnps_checkout_field_process'));
        add_action('woocommerce_checkout_update_order_meta',  array($this,  'wnps_checkout_field_update_order_meta'));
    }

    /**
     * Checkout Process
     */
    public function wnps_checkout_field_process()
    {
        // Show an error message if the field is not set.
        if (!$_POST['wnps_area']) wc_add_notice(__(esc_attr__('Будь ласка, виберіть область',WNPS_DOMAIN)) , 'error');
        if (!$_POST['wnps_city']) wc_add_notice(__(esc_attr__('Будь ласка, виберіть місто',WNPS_DOMAIN)) , 'error');
        if (!$_POST['wnps_warehouse']) wc_add_notice(__(esc_attr__('Будь ласка, виберіть відділення',WNPS_DOMAIN)) , 'error');
    }

    /**
     * Update the value given in custom field
    */
    public function wnps_checkout_field_update_order_meta($order_id)
    {
        if (empty($_POST['wnps_area'])) {
            update_post_meta($order_id, 'area',sanitize_text_field($_POST['wnps_area']));
        }
        if (empty($_POST['wnps_city'])) {
            update_post_meta($order_id, 'city',sanitize_text_field($_POST['wnps_city']));
        }
        if (empty($_POST['wnps_warehouse'])) {
            update_post_meta($order_id, 'warehouse',sanitize_text_field($_POST['wnps_warehouse']));
        }
    }
}