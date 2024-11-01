<?php

namespace WooNovaPoshtaShipping\App;

class BaseRender{

    /**
     * Render content
     *
     * @param string $content
     * @return void
     */
    public static function render($content = ""){
        if(!empty($content)){
            echo $content;
        }
    }

}