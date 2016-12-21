<li class="intergeo_tlbr_ul_li">
    <h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Import/Export Markers', INTERGEO_PLUGIN_NAME ) ?></h3>
    <ul class="intergeo_tlbr_ul_li_ul">
    <?php
        global $IntergeoMaps_Adv;
        $IntergeoMaps_Adv->addUploadElements($json);
    ?>
    </ul>
</li>
