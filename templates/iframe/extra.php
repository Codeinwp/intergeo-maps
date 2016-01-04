<li class="intergeo_tlbr_ul_li">
    <h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Import Markers', INTERGEO_PLUGIN_NAME ) ?></h3>
    <ul class="intergeo_tlbr_ul_li_ul">
    <?php
        if( defined( 'IntergeoMaps_Pro' ) ){
            global $IntergeoMaps_Pro;
            $IntergeoMaps_Pro->addUploadElements($json);
        }else{
    ?>

            <li class="intergeo_tlbr_ul_li_ul_li">
                <div class="intergeo_tlbr_cntrl_items" style="display:block">
                    <div class="intergeo_tlbr_cntrl_item">
                        <a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
                        <label>
                            <input type="hidden" name="layer_importcsv" value="0">
                            <input type="checkbox" name="layer_importcsv" value="1" disabled>
                            <?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
                        </label>
                    </div>
                    <p class="intergeo_tlbr_cntrl_dsc">
                        <?php esc_html_e( 'Allows you to upload marker data to your map.', INTERGEO_PLUGIN_NAME ) ?>
                    </p>
                    <div class="form-inline">
                        <div class="button button-primary file-wrapper computer-btn">
                            <input type="file" id="file" class="file" name="file" disabled>
                            <?php esc_attr_e( 'From Computer', INTERGEO_PLUGIN_NAME ) ?>
                        </div>
                    </div>
                </div>
            </li>
    <?php
        }
    ?>
    </ul>
</li>
