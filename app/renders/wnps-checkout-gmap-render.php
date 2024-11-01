<?php

namespace WooNovaPoshtaShipping\App\Renders;

use WooNovaPoshtaShipping\App\BaseRender;

class WNPS_Checkout_Gmap_Render extends BaseRender{

    public function wnps_render(){
    ?>
        <div id="map_wrapper">
            <div id="map_canvas" class="mapping"></div>
        </div>
    <?php
    }
    
}