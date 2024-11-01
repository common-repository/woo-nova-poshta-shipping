<?php

namespace WooNovaPoshtaShipping\App;

use WooNovaPoshtaShipping\App\Controllers\WNPS_Get_Shipping_Fields;
use WooNovaPoshtaShipping\App\Controllers\WNPS_Settings;
use WooNovaPoshtaShipping\App\Controllers\WNPS_Shipping_Details;
use WooNovaPoshtaShipping\App\Controllers\WNPS_Order_Processing;
use WooNovaPoshtaShipping\App\Controllers\WNPS_Validation;
use WooNovaPoshtaShipping\App\WCEXT\WC_WNPS_Woo_Shipping_Details;
use WooNovaPoshtaShipping\App\WCEXT\WC_WNPS_Cargotype;

/**
 * Class for loading scripts, styles and dependencies
 */
class Loader{

    public function __construct(){
        add_action('admin_enqueue_scripts', array($this, 'wnps_load_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'wnps_frontend_load_scripts'));
    }

    public function wnps_frontend_load_scripts(){
        wp_enqueue_style( 'select2css', WNPS_PATH.'assets/js/select2/select2.min.css', false, '1.0', 'all' );
        wp_enqueue_script( 'select2', WNPS_PATH.'assets/js/select2/select2.min.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'wnps_frontend_script', WNPS_PATH . 'assets/js/frontend.js', array(), null, true );
        wp_enqueue_script( 'wnps_gmap_script', WNPS_PATH . 'assets/js/gmap.js', array(), null, true );
        wp_enqueue_style( 'wnps_styles', WNPS_PATH . 'assets/css/style-frontend.css' );
        wp_localize_script('wnps_frontend_script', 'ajaxurl', array(
            'url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('ajax_pp_form_nonce'),
        ));
    }

    /**
     * Loading scripts
     *
     * @return void
     */
    public function wnps_load_scripts(){
        wp_enqueue_style( 'select2css', WNPS_PATH.'assets/js/select2/select2.min.css', false, '1.0', 'all' );
        wp_enqueue_script( 'select2', WNPS_PATH.'assets/js/select2/select2.min.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_style( 'wnps_styles', WNPS_PATH . 'assets/css/style.css' );
        wp_enqueue_script( 'wnps_script', WNPS_PATH . 'assets/js/main.js', array(), null, true );
        wp_localize_script('wnps-ajax', 'ajaxurl', array(
            'url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('ajax_pp_form_nonce'),
        ));
    }

    /**
     * Loading controllers
     *
     * @return void
     */
    public function wnps_load_dependencies(){
        (new WNPS_Settings())->init();
        (new WNPS_Get_Shipping_Fields())->init();
        (new WNPS_Order_Processing())->init();
        (new WNPS_Shipping_Details())->init();
        (new WNPS_Validation())->init();
        (new WC_WNPS_Woo_Shipping_Details())->init();
        (new WC_WNPS_Cargotype())->init();
    }

}