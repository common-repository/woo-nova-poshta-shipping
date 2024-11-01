<?php

namespace WooNovaPoshtaShipping\App\Renders;

use WooNovaPoshtaShipping\App\BaseRender;
use WooNovaPoshtaShipping\App\Controllers\WNPS_Shipping_Details;

class WNPS_Order_Details_Render_Admin extends BaseRender{

    public function wnps_render($data = array()){
        $shippingTypeRu = "";
        switch($data['shippingType']){
            case "DoorsDoors":
                $shippingTypeRu = "Двері-Двері";
            break;
            case "DoorsWarehouse":
                $shippingTypeRu = "Двері-Склад";
            break;
            case "WarehouseWarehouse":
                $shippingTypeRu = "Склад-Склад";
            break;
            case "WarehouseDoors":
                $shippingTypeRu = "Склад-Двері";
            break;
            default: 
                $shippingTypeRu = "Склад-Склад";
            break;  
        }
        ?>
        <h3><?php esc_html_e('Доставка Нова Пошта', WNPS_DOMAIN)?></h3>
        <p>
            <div class="detail_item">
                <span class="wnps_checkout_areа"><strong><?php esc_html_e('Область:', WNPS_DOMAIN)?></strong></span><span> <?php echo  '&nbsp ' . $data['areaOutput']?></span>
            </div>
            <div class="detail_item">
                <span class="wnps_checkout_areа"><strong><?php esc_html_e('Місто:', WNPS_DOMAIN)?></strong></span><span> <?php echo '&nbsp ' . $data['cityOutput'];?></span>
            </div>
            <div class="detail_item">
                <span class="wnps_checkout_areа"><strong><?php esc_html_e('Відділення:', WNPS_DOMAIN)?></strong></span><span> <?php echo '&nbsp' . $data['warehouseOutput'];?></span>
            </div>
            <div class="detail_item"><span class="wnps_checkout_areа"><strong><?php esc_html_e('Тип доставки:', WNPS_DOMAIN)?></strong></span>
                <span><?php echo '&nbsp' . $shippingTypeRu;?></span>
            </div>
        </p>
<?php
    }

}


