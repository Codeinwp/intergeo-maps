    <li class="intergeo_tlbr_ul_li_ul_li">
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Custom layer', 'intergeo-maps' ) ?></span>
		<div class="intergeo_tlbr_cntrl_items">
			<?php
			if ( ! intergeo_is_agency() ) {
				?>
				<a  target="_blank" href="<?php echo INTERGEO_PRO_URL; ?>"   class="intergeo-pro-btn button"><?php _e( 'Available in Agency plan', 'intergeo-maps' ) ?></a>
				<?php
			} else { ?>

			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<label>
					<input type="hidden" name="layer_custom" value="0">
					<input type="checkbox" name="layer_custom" value="1" <?php checked( isset( $json['layer']['custom'] ) ? $json['layer']['custom'] == 1 : false ) ?>>
					<?php esc_html_e( 'Enabled', 'intergeo-maps' ) ?>
				</label>
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php printf( esc_html__( 'Allows you to add custom images to your map.', 'intergeo-maps' ), '<a href="http://gmaps-samples.googlecode.com/svn/trunk/mapcoverage_filtered.html" target="_blank">', '</a>' ) ?>
			</p>
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<?php esc_html_e( 'Image URL', 'intergeo-maps' ) ?>
				<input type="text" name="custom_url" class="intergeo_tlbr_cntrl_txt intergeo_tlbr_cntrl_onkeyup" value="<?php echo isset( $json['custom']['url'] ) ? esc_attr( $json['custom']['url'] ) : ''  ?>">
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The URL of the image that will be used for the custom layer.', 'intergeo-maps' ) ?>
			</p>
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<?php esc_html_e( 'South-west Latitude/Longitude', 'intergeo-maps' ) ?>
				<input type="text" name="custom_latsw" class="intergeo_tlbr_cntrl_txt intergeo_tlbr_cntrl_onkeyup" value="<?php echo isset( $json['custom']['latsw'] ) ? esc_attr( $json['custom']['latsw'] ) : ''  ?>" placeholder="<?php esc_html_e( 'Latitude', 'intergeo-maps' )?>" >
				<input type="text" name="custom_lonsw" class="intergeo_tlbr_cntrl_txt intergeo_tlbr_cntrl_onkeyup" value="<?php echo isset( $json['custom']['lonsw'] ) ? esc_attr( $json['custom']['lonsw'] ) : ''  ?>" placeholder="<?php esc_html_e( 'Longitude', 'intergeo-maps' )?>" >
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The latitude/longitude of the south-west (bottom-left) edge of the map to position the image.', 'intergeo-maps' ) ?>
			</p>
			<div class="intergeo_tlbr_cntrl_item">
				<a class="intergeo_tlbr_cntrl_more_info" href="javascript:;">[?]</a>
				<?php esc_html_e( 'North-east Latitude/Longitude', 'intergeo-maps' ) ?>
				<input type="text" name="custom_latne" class="intergeo_tlbr_cntrl_txt intergeo_tlbr_cntrl_onkeyup" value="<?php echo isset( $json['custom']['latne'] ) ? esc_attr( $json['custom']['latne'] ) : ''  ?>" placeholder="<?php esc_html_e( 'Latitude', 'intergeo-maps' )?>" >
				<input type="text" name="custom_lonne" class="intergeo_tlbr_cntrl_txt intergeo_tlbr_cntrl_onkeyup" value="<?php echo isset( $json['custom']['lonne'] ) ? esc_attr( $json['custom']['lonne'] ) : ''  ?>" placeholder="<?php esc_html_e( 'Longitude', 'intergeo-maps' )?>" >
			</div>
			<p class="intergeo_tlbr_cntrl_dsc">
				<?php esc_html_e( 'The latitude/longitude of the north-east (top-right) edge of the map to position the image.', 'intergeo-maps' ) ?>

			<?php } ?>
		</div>
	</li>
