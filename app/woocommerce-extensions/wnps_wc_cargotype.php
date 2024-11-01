<?php

namespace WooNovaPoshtaShipping\App\WCEXT;

class WC_WNPS_Cargotype {

    public function init(){
        add_action('woocommerce_product_options_shipping', array($this, 'wnps_add_product_cargotype'));
        add_action('woocommerce_process_product_meta', array($this, 'wnps_save_custom_field'));
    }

    /**
     * Add selector into product for cargo type
     *
     * @return void
     */
    public function wnps_add_product_cargotype(){
        $args = array(
            'id' => 'wnps-shipping-cargotype',
            'label' => __('Cargo Type', WNPS_DOMAIN),
            'class' => 'wnps-shipping-cargotype',
            'desc_tip' => true,
            'description' => __('Select product cargo type', WNPS_DOMAIN),
            'type' => 'select',
            'options' => array(
                'Cargo' => 'Вантаж',
                'Documents' => 'Документи',
                'TiresWheels' => 'Шини-диски',
                'Pallet' => 'Палети',
                'Parcel' => 'Посилка'
            )
        );

        \woocommerce_wp_select($args);
    }

    public function wnps_save_custom_field($post_id){
        $product = wc_get_product($post_id);
        $cargotype = isset($_POST['wnps-shipping-cargotype']) ? sanitize_text_field($_POST['wnps-shipping-cargotype']) : '';
        $product->update_meta_data('wnps-shipping-cargotype', $cargotype);
        $product->save();
    }

}