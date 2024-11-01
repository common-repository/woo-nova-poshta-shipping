<?php

namespace WooNovaPoshtaShipping\App\Renders;

use WooNovaPoshtaShipping\App\BaseRender;


class WNPS_Order_Details_Render_Frontend extends BaseRender{

    public function wnps_render($data = array()){
        ?>
        <h2 class="woocommerce-column__title"><?php esc_html_e('Доставка Нова Пошта', WNPS_DOMAIN)?></h2>
            <section class="wnps_checkout_details">
                <div class="woocommerce-column woocommerce-column--1 ">
                    <div class="detail_item">
                        <span class="wnps_checkout_areа"><strong><?php esc_html_e('Область:', WNPS_DOMAIN)?></strong></span><span> <?php echo  '&nbsp ' . $data['areaOutput']?></span>
                    </div>
                    <div class="detail_item">
                        <span class="wnps_checkout_areа"><strong><?php esc_html_e('Місто:', WNPS_DOMAIN)?></strong></span><span> <?php echo '&nbsp ' . $data['cityOutput'];?></span>
                    </div>
                    <div class="detail_item">
                        <span class="wnps_checkout_areа"><strong><?php esc_html_e('Відділення:', WNPS_DOMAIN)?></strong></span><span> <?php echo '&nbsp' . $data['warehouseOutput'];?></span>
                    </div>
                    <div class="detail_item">
                        <span class="wnps_checkout_areа"><strong><?php esc_html_e('Тип доставки:', WNPS_DOMAIN)?></strong></span><span> <?php echo '&nbsp' . $data['shippingType'];?></span>
                    </div>
                </div>
            </section>
        <?php
    }

}


