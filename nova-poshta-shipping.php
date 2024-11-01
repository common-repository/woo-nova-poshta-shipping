<?php

/**
* Plugin Name: Shipping via Nova Poshta for WooCommerce
* Description: Adds a "Nova Poshta" shipping method to Woocommerce
* Author URI:  https://www.extrawest.com/
* Author:      Extrawest
*
* Text Domain: woo-nova-poshta-shipping
* Domain Path: ###
*
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
*
* Version:     1.0.0
*/

if(!(defined('ABSPATH'))){
    die; //Forbidden
}

define("WNPS_PATH", plugin_dir_url( __FILE__ ));
define("WNPS_DOMAIN", 'nova-poshta-shipping');

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

use WooNovaPoshtaShipping\App\DB\WNPS_DB;
use WooNovaPoshtaShipping\App\Loader;

register_activation_hook( __FILE__, "create_base_tables" );
register_deactivation_hook( __FILE__, "remove_base_tables_deactivation" );
register_uninstall_hook( __FILE__, "remove_base_tables_unistall" );

function remove_base_tables_deactivation(){
    WNPS_DB::getInstance()->drop_table("novaposhta_areas")->drop_table("novaposhta_cities")->drop_table("novaposhta_warehouses");
}

function remove_base_tables_unistall(){
    WNPS_DB::getInstance()->drop_table("novaposhta_areas")->drop_table("novaposhta_cities")->drop_table("novaposhta_warehouses");
}

if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
    add_action( "plugins_loaded", "base_init" );
    require_once plugin_dir_path( __FILE__ ) . 'app/woocommerce-extensions/wnps-wc-shipping.php';
}
else{
    add_action( 'admin_notices', 'wnps_without_woo_notice' );

    function wnps_without_woo_notice() {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php echo __("Активируйте или установите Woocommerce чтобы получить способ доставки 'Новая Почта'!", 'nova-poshta-shipping') ?></p>
        </div>
        <?php
    }
}

function base_init(){
    (new Loader())->wnps_load_dependencies();
}

require_once plugin_dir_path( __FILE__ ) . 'app/woocommerce-extensions/wnps-wc-shipping.php';

function create_base_tables(){
    WNPS_DB::getInstance()
    ->create_table(
        "novaposhta_areas",
        "id int(11) AUTO_INCREMENT PRIMARY KEY,
        AreasCenter varchar(255),
        Description varchar(255),
        Ref varchar(255)",
        "IF NOT EXISTS"
    )
    ->create_table(
        "novaposhta_cities",
        "id int(11) AUTO_INCREMENT PRIMARY KEY,
        Area VARCHAR(255),
        CityID VARCHAR(255),
        Description VARCHAR(255),
        DescriptionRu VARCHAR(255),
        IsBranch INT(5),
        PreventEntryNewStreetsUser VARCHAR(255) NULL,
        SpecialCashCheck INT(5),
        SettlementType varchar(255),
        Delivery1 int(5),
        Delivery2 int(5),
        Delivery3 int(5),
        Delivery4 int(5),
        Delivery5 int(5),
        Delivery6 int(5),
        Delivery7 int(5),
        Ref varchar(255),
        Conglomerates varchar(255),
        SettlementTypeDescriptionRu varchar(255),
        SettlementTypeDescription varchar(255)",
        "IF NOT EXISTS"
    )
    ->create_table(
        "novaposhta_warehouses",
        "id int(11) AUTO_INCREMENT PRIMARY KEY,
        SiteKey varchar(255),
        Description varchar(255),
        DescriptionRu varchar(255),
        TypeOfWarehouse varchar(255),
        Number int(5),
        CityRef varchar(255),
        CityDescription varchar(255),
        CityDescriptionRu varchar(255),
        Longitude varchar(255),
        Latitude varchar(255),
        PostFinance int(5),
        POSTerminal int(5),
        InternationalShipping int(5),
        TotalMaxWeightAllowed varchar(255),
        PlaceMaxWeightAllowed varchar(255),
        Reception longtext,
        Delivery longtext,
        Schedule longtext,
        Ref varchar(255),
        BicycleParking INT(1),
        CategoryOfWarehouse VARCHAR(255),
        DistrictCode VARCHAR(255),
        PaymentAccess VARCHAR(255),
        Phone VARCHAR(255),
        ShortAddress VARCHAR(255),
        ShortAddressRu VARCHAR(255),
        WarehouseStatus VARCHAR(255),
        SettlementAreaDescription VARCHAR(255),
        SettlementDescription VARCHAR(255),
        SettlementRef VARCHAR(255),
        SettlementRegionsDescription VARCHAR(255),
        SettlementTypeDescription VARCHAR(255)",
        "IF NOT EXISTS"
    );

}
