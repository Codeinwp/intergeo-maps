<li class="intergeo_tlbr_ul_li_ul_li">
    <p class="intergeo_tlbr_grp_dsc">
        <?php esc_html_e( 'To import data, please import a CSV file. Here is a sample', INTERGEO_PLUGIN_NAME ) ?>
        : <a href="<?php echo INTERGEO_ABSURL . "samples/default.csv" ?>" target="_blank"><?php esc_html_e("Click here", INTERGEO_PLUGIN_NAME); ?></a>
    </p>
</li>

<li class="intergeo_tlbr_ul_li_ul_li">
    <div class="intergeo_tlbr_cntrl_items" style="display:block">
        <div class="intergeo_tlbr_cntrl_item">
            <a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
            <label>
                <input type="hidden" name="layer_importcsv" value="0">
                <input type="checkbox" name="layer_importcsv" value="1" <?php checked( isset( $json['layer']['importcsv'] ) ? $json['layer']['importcsv'] == 1 : false ) ?>>
                <?php esc_html_e( 'Enabled', INTERGEO_PLUGIN_NAME ) ?>
            </label>
        </div>
        <p class="intergeo_tlbr_cntrl_dsc">
            <?php esc_html_e( 'Allows you to upload marker data to your map.', INTERGEO_PLUGIN_NAME ) ?>
        </p>
        <div class="form-inline">
            <div class="button button-primary file-wrapper computer-btn">
                <input type="hidden" name="csvfileorig" value="<?php echo (isset($json["xml"]) ? $json["xml"] : "") ?>">
                <input type="file" id="csvfile" class="file" name="import_csv">
                <?php esc_attr_e( 'From Computer', INTERGEO_PLUGIN_NAME ) ?>
            </div>
        </div>
    </div>
</li>

<li class="intergeo_tlbr_ul_li_ul_li">
    <p class="intergeo_tlbr_grp_dsc">
        <?php esc_html_e( 'To export data, click on the button below', INTERGEO_PLUGIN_NAME ) ?>
    </p>
</li>

<li class="intergeo_tlbr_ul_li_ul_li">
    <div class="intergeo_tlbr_cntrl_items" style="display:block">
        <div class="form-inline">
            <div class="button button-primary file-wrapper computer-btn" id="intergeo_export_csv">
                <input type="button" class="file">
                <?php esc_attr_e( 'Export markers as CSV', INTERGEO_PLUGIN_NAME ) ?>
            </div>
        </div>
    </div>
</li>
