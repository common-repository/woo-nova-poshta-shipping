<?php

namespace WooNovaPoshtaShipping\App\Renders;

use WooNovaPoshtaShipping\App\BaseRender;

class WNPS_Settings_Render extends BaseRender{

    /**
     * Render settings page
     *
     * @param array $params
     * @return void
     */
    public function wnps_render($params = array()){

        $image = WNPS_PATH . 'assets/images/novaposhta-logo.png';
        $ajaxloader = WNPS_PATH . 'assets/images/ajax-loader.gif';
        $enabled = ($params['enabled'] == 'yes') ? 1 : 0;
        $title = $params['title'];
        $subtitle = $params['subtitle'];
        $api = $params['api'];
        $area = $params['myarea'];
        $city = $params['mycity'];
        $warehouse = $params['mywarehouse'];
        $attr = $params['attr'];
        $warehouse_ref = $params['warehouse_ref'];

        ?>
        <div class="wnps-base-block">
            <div class="wnps-preloader">
                <img src="<?php echo $ajaxloader ?>" alt="">
            </div>
            <div class="wnps-wrapper">
                <div class="wnps-header">
                    <div class="wnps-wrapper">
                        <div class="wnps-image">
                            <img src="<?php echo $image ?>" alt="">
                        </div>
                        <div class="wnps-title">
                            <h1><?php echo esc_html_e('Нова пошта', WNPS_DOMAIN) ?></h1>
                        </div>
                    </div>
                </div>

                <div class="wnps-body">
                    <div class="wnps-wrapper">
                        <div class="wnps-form">
                            <form method="post" class="wnps-settings-form" id="wnps-settings-form">
                                <div class="wnps-form-row">
                                    <div class="input-label">
                                        <p><?php echo esc_html_e('Підключити:', WNPS_DOMAIN) ?></p>
                                    </div>
                                    <div class="input-box">
                                        <input type="checkbox" autocomplete="off" value="1" name="enabled" id="enabled" <?php 
                                        if($enabled == 1): ?>  checked="checked" <?php endif; ?>>
                                    </div>
                                </div>
                                <div class="wnps-form-row">
                                    <div class="input-label">
                                        <p><?php echo esc_html_e('Назва:', WNPS_DOMAIN) ?></p>
                                    </div>
                                    <div class="input-box">
                                        <input type="text" autocomplete="off" name="title" id="title" value="<?php echo esc_html_e($title, WNPS_DOMAIN) ?>" placeholder="Nova Poshta">
                                    </div>

                                </div>
                                <div class="info-text"><?php echo esc_html_e('Назва способу доставки на сторінці чекауту', WNPS_DOMAIN) ?></div>
                                <div class="wnps-form-row">
                                    <div class="input-label">
                                        <p><?php echo esc_html_e('Опис:', WNPS_DOMAIN) ?></p>
                                    </div>
                                    <div class="input-box">
                                        <input type="text" autocomplete="off" name="subtitle" id="subtitle" value="<?php echo esc_html_e($subtitle, WNPS_DOMAIN) ?>" placeholder="Payment method">
                                    </div>
                                </div>
                                <div class="info-text"><?php echo esc_html_e('Опис способу доставки на сторінці чекауту', WNPS_DOMAIN) ?></div>
                                <div class="wnps-form-row">
                                    <div class="input-label">
                                        <p><?php echo esc_html_e('API ключ:', WNPS_DOMAIN) ?></p>
                                    </div>
                                    <div class="input-box">
                                        <input type="text" autocomplete="off" name="api" id="api" value="<?php echo esc_html_e($api, WNPS_DOMAIN) ?>" placeholder="API key">
                                    </div>
                                </div>
                                <div class="info-text"><?php echo esc_html_e('API ключ з особистого кабінету НП', WNPS_DOMAIN) ?></div>

                                <div class="wnps-form-row">
                                    <div class="input-label">
                                        <p><?php echo esc_html_e('Область:', WNPS_DOMAIN) ?></p>
                                    </div>
                                    <div class="input-box">
                                        <select type="text" class="area ls " autocomplete="off" name="myarea" id="myarea" value="" placeholder="Select your area">
                                            <?php if(isset($area)){?>
                                                <option value="<?php echo $attr ?>" selected class="selected" ><?php esc_html_e($area, WNPS_DOMAIN) ?></option>
                                            <?php }?>
                                        </select>
                                        <div class="valid-notice-area"><?php esc_html_e('Будь ласка, виберіть область',WNPS_DOMAIN) ?></div>
                                    </div>
                                </div>
                                <div class="info-text"><?php echo esc_html_e('Вкажіть область відправника для розрахунку вартості доставки', WNPS_DOMAIN) ?></div>
                                <div class="wnps-form-row">
                                    <div class="input-label">
                                        <p><?php echo esc_html_e('Місто:', WNPS_DOMAIN) ?>

                                        </p>
                                    </div>
                                    <div id="city-block" class="input-box">
                                        <select type="text" class="city ls" autocomplete="off" name="mycity" id="mycity" value="" placeholder="Select your city">

                                        </select>
                                        <?php if(isset($city)){?>
                                            <input type="hidden"  value="<?php echo esc_html_e($city, WNPS_DOMAIN) ?>" selected id="select" class="checked">
                                        <? } else{?>
                                            <input type="hidden" value="<?php echo esc_html__('Оберіть Місто', WNPS_DOMAIN) ?>" selected id="select">
                                        <?php } ?>

                                        <div class="valid-notice-city"><?php esc_html_e('Будь ласка, виберіть місто',WNPS_DOMAIN) ?></div>
                                    </div>


                                </div>
                                <div class="info-text"><?php echo esc_html_e('Вкажіть місто відправника для розрахунку вартості доставки', WNPS_DOMAIN) ?></div>
                                <div class="wnps-form-row">
                                    <div class="input-label">
                                        <p><?php echo esc_html_e('Відділення:', WNPS_DOMAIN) ?></p>
                                    </div>
                                    <div id="werehouse-block"  class="input-box">
                                        <select type="text" class="werehouse" autocomplete="off" name="mywerehouse" id="mywerehouse" value="" placeholder="Select your werehouse">
                                            <?php 
                                            if(isset($warehouse)){
                                                ?>
                                                <option value="<?php echo $warehouse_ref?>" selected >
                                                <?php
                                                 esc_html_e($warehouse, WNPS_DOMAIN) 
                                                 ?>
                                                 </option>
                                            <?php 
                                        } 
                                        ?>
                                        </select>
                                        <?php if(isset($warehouse)){?>
                                            <input type="hidden"  value="<?php echo esc_html_e($warehouse, WNPS_DOMAIN) ?>" selected id="select_werehouse" class="checked">
                                        <? } else{?>
                                            <input type="hidden" value="<?php echo esc_html__('Оберіть Відділення', WNPS_DOMAIN) ?>" selected id="select_werehouse">
                                        <?php } ?>
                                        <div class="valid-notice-warehouse"><?php esc_html_e('Будь ласка, виберіть відділення',WNPS_DOMAIN) ?></div>
                                    </div>
                                </div>
                                <div class="info-text"><?php echo esc_html_e('Вкажіть відділення відправника для розрахунку вартості доставки', WNPS_DOMAIN) ?></div>
                                <div class="wnps-form-row">
                                    <div class="input-box">
                                        <button type="submit" id="wnps-submit"><?php esc_html_e('Зберегти', WNPS_DOMAIN) ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="wnps-wrapper">
                        <div class="wnps-load-box">
                            <form method="POST" class="load_addresses" id="load_addresses">
                                <div class="wnps-form-row">
                                    <div class="input-box">
                                        <button type="submit"  id="submit" ><?php esc_html_e('Синхронізувати Довідник Адрес НП', WNPS_DOMAIN) ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}
