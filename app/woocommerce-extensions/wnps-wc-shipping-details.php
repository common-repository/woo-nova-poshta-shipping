<?php

namespace WooNovaPoshtaShipping\App\WCEXT;

use WooNovaPoshtaShipping\App\Renders\WNPS_Checkout_Select_Render;
use WooNovaPoshtaShipping\App\Renders\WNPS_Checkout_Gmap_Render;

class WC_WNPS_Woo_Shipping_Details{
    
    private $checkout_render;
    private $map_render;
    private $wnps_package_area;

    public function __construct(){
        $this->checkout_render = new WNPS_Checkout_Select_Render();
        $this->map_render = new WNPS_Checkout_Gmap_Render();
    }

    public function init(){
        add_action('woocommerce_after_checkout_billing_form', array($this,'wnps_checkout_forms'));
        add_action('woocommerce_checkout_after_customer_details', array($this,'wnps_checkout_map'));
    }

    /**
     * Add np select boxes to checkout
     *
     * @return void
     */
    public function wnps_checkout_forms($checkout){
        $this->checkout_render->wnps_render($checkout);
    }

    /**
     * Add np googlemap
     *
     * @return void
     */
    public function wnps_checkout_map(){
        $this->map_render->wnps_render();
    }

}