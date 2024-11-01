<?php

namespace WooNovaPoshtaShipping\App\Renders;

use WooNovaPoshtaShipping\App\BaseRender;

class WNPS_Checkout_Select_Render extends BaseRender{

    public function wnps_render($checkout){
        ?>
        <h4 id=""><?php
            $result =  get_option('woocommerce_novaposhta_settings');
            if(!empty($result['title'])){
                echo esc_html_e($result['title'], WNPS_DOMAIN);
            }
            ?></h4>
            <h5>
                <?php
                if(!empty($result['subtitle'])){
                    echo esc_html_e($result['subtitle'], WNPS_DOMAIN);
                }
                ?>
            </h5>
        <p class="form-row form-row-wide">
            <span class="woocommerce-input-wrapper">
                <label for="wnps_area" class=""><?php esc_html_e('Область', WNPS_DOMAIN) ?><abbr class="required" title="required">*</abbr></label>
                <select name="wnps_area" id="wnps_area" class="wnps_fields wnps_area select " autocomplete="off" placeholder="Select your area">
                </select>
            </span>
        </p>
        <p class="form-row form-row-wide">
            <span class="woocommerce-input-wrapper">
                <label for="wnps_city" class=""><?php esc_html_e('Місто', WNPS_DOMAIN) ?><abbr class="required" title="required">*</abbr></label>
                <select name="wnps_city" id="wnps_city" class="wnps_fields wnps_city  select" autocomplete="off" >
                </select>
            </span>
        </p>
        <p class="form-row form-row-wide">
            <span class="woocommerce-input-wrapper">
                <label for="wnps_warehouse" class=""><?php esc_html_e('Відділення', WNPS_DOMAIN) ?><abbr class="required" title="required">*</abbr></label>
                <select name="wnps_warehouse" id="wnps_warehouse" class="wnps_fields wnps_warehouse  select" autocomplete="off" >
                </select>
            </span>
        </p>
        <p class="form-row form-row-wide">
            <span class="woocommerce-input-wrapper">
                <label for="wnps_shippingtype" class=""><?php esc_html_e('Тип доставки', WNPS_DOMAIN) ?><abbr class="required" title="required">*</abbr></label>
                <select name="wnps_shippingtype" id="wnps_shippingtype" class="wnps_fields wnps_shippingtype  select" autocomplete="off" >
                    <option value="0" selected="selected">Выберите тип доставки</option>
                    <option value="DoorsDoors">Двері-Двері</option>
                    <option value="DoorsWarehouse">Двері-Склад</option>
                    <option value="WarehouseWarehouse">Склад-Склад</option>
                    <option value="WarehouseDoors">Склад-Двері</option>
                </select>
            </span>
        </p>
        <?php 
        $pdt_id = [];
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $pdt_id = $cart_item['product_id'];
        }
        ?>
        <input type="hidden" name="cargotype" id="cargotype" value="<?php echo get_post_meta($pdt_id, "wnps-shipping-cargotype", true)?>">
         <?php
            global $woocommerce;
            echo '<div id="checkout_weight" class="cart-extra-info">';
            echo '<p class="total-weight">' . __('Загальна Вага:', 'woocommerce');
            echo '<span id="total_int"><strong> <span id="weight">' . $woocommerce->cart->cart_contents_weight . '</span><span id="unit"> ' . get_option('woocommerce_weight_unit') . '</span></strong></span>';
            echo '</p>';
            echo '</div>';
    }
    
}


