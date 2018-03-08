<h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Layers', 'intergeo-maps' ); ?></h3>
<ul class="intergeo_tlbr_ul_li_ul">
	<?php
	if ( ! intergeo_is_developer() ) {
		?>
		<a  target="_blank" href="<?php echo INTERGEO_PRO_URL; ?>"   class="intergeo-pro-btn button"><?php _e( 'Available in Developer plan', 'intergeo-maps' ); ?></a>
		<?php
	} else {
	?>

		<li class="intergeo_tlbr_ul_li_ul_li">
			<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Traffic layer', 'intergeo-maps' ); ?></span>
			<div class="intergeo_tlbr_cntrl_items">
				<div class="intergeo_tlbr_cntrl_item">
				  <a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				  <label>
					  <input type="hidden" name="layer_traffic" value="0">
					  <input type="checkbox" name="layer_traffic"
							 value="1" <?php checked( isset( $json['layer']['traffic'] ) ? $json['layer']['traffic'] == 1 : false ); ?>>
						<?php esc_html_e( 'Enabled', 'intergeo-maps' ); ?>
				  </label>
				</div>
				<p class="intergeo_tlbr_cntrl_dsc">
					<?php printf( esc_html__( 'Allows you to add real-time traffic information (where supported) to your map. Traffic information is provided for the time at which the request is made. Consult %1$s this spreadsheet %2$s to determine traffic coverage support.', 'intergeo-maps' ), '<a href="http://gmaps-samples.googlecode.com/svn/trunk/mapcoverage_filtered.html" target="_blank">', '</a>' ); ?>
				</p>
			</div>
		</li>
		<li class="intergeo_tlbr_ul_li_ul_li">
			<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Bicycling layer', 'intergeo-maps' ); ?></span>
			<div class="intergeo_tlbr_cntrl_items">
				<div class="intergeo_tlbr_cntrl_item">
				  <a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				  <label>
					  <input type="hidden" name="layer_bicycling" value="0">
					  <input type="checkbox" name="layer_bicycling"
							 value="1" <?php checked( isset( $json['layer']['bicycling'] ) ? $json['layer']['bicycling'] == 1 : false ); ?>>
						<?php esc_html_e( 'Enabled', 'intergeo-maps' ); ?>
				  </label>
				</div>
				<p class="intergeo_tlbr_cntrl_dsc">
					<?php esc_html_e( 'Allows you to add bicycle information to your map. It renders a layer of bike paths, suggested bike routes and other overlays specific to bicycling usage on top of the given map. Additionally, the layer alters the style of the base map itself to emphasize streets supporting bicycle routes and de-emphasize streets inappropriate for bicycles.', 'intergeo-maps' ); ?>
				</p>
			</div>
		</li>
		<?php
		do_action( 'intergeo_add_layers', 'layers', $json );
	}
?>
</ul>
