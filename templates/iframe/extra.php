<li class="intergeo_tlbr_ul_li">
    <h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Import/Export Markers', INTERGEO_PLUGIN_NAME ) ?></h3>
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
                            <a href="<?php echo INTERGEO_PRO_URL; ?>" target="_blank"><?php esc_html_e( 'Enabled ( Available in PRO )', INTERGEO_PLUGIN_NAME ) ?></a>
                        </label>
                    </div>
                    <p class="intergeo_tlbr_cntrl_dsc">
                        <?php esc_html_e( 'Allows you to upload marker data to your map.', INTERGEO_PLUGIN_NAME ) ?>
                    </p>

                </div>
            </li>
    <?php
        }
    ?>
    </ul>
</li>
