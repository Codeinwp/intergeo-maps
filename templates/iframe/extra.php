<li class="intergeo_tlbr_ul_li">
    <h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Import/Export Markers', 'intergeo-maps' ) ?></h3>
	<ul class="intergeo_tlbr_ul_li_ul">
		<?php if ( ! intergeo_is_agency() ) {
		?>
		<li><a  target="_blank" href="<?php echo INTERGEO_PRO_URL; ?>"   class="intergeo-pro-btn button"><?php _e( 'Available in Agency plan', 'intergeo-maps' ) ?></a></li>
		<?php
} else {

	global $IntergeoMaps_Adv;
	$IntergeoMaps_Adv->addUploadElements( $json );
}
	?>
	</ul>
</li>
