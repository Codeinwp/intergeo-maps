<h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Overlays', 'intergeo-maps' ) ?></h3>
<ul class="intergeo_tlbr_ul_li_ul">
	<li class="intergeo_tlbr_ul_li_ul_li">
		<script id="intergeo_tlbr_marker_tmpl" type="text/html">
			<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_marker" border="0" cellspacing="0" cellpadding="0" data-table-num="%num%">
				<tr>
					<td class="intergeo_tlbr_marker_title_td">
						#%num% <?php esc_html_e( 'marker', 'intergeo-maps' ) ?>
					</td>
					<td>
						<input type="hidden" class="intergeo_tlbr_marker_location" name="overlays_marker[%pos%][position]" data-position="%pos%">
						<input type="hidden" class="intergeo_tlbr_marker_title" name="overlays_marker[%pos%][title]">
						<input type="hidden" class="intergeo_tlbr_marker_icon" name="overlays_marker[%pos%][icon]">
						<input type="hidden" class="intergeo_tlbr_marker_info" name="overlays_marker[%pos%][info]">
						<input type="hidden" class="intergeo_tlbr_marker_loc" name="overlays_marker[%pos%][loc]">

						<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete marker', 'intergeo-maps' ) ?>"></a>
						<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit marker', 'intergeo-maps' ) ?>"></a>
					</td>
				</tr>
			</table>
		</script>
		
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Markers', 'intergeo-maps' ) ?></span>
		<div class="intergeo_tlbr_cntrl_items"  style="display:block">
		<div id="intergeo_tlbr_markers">
			<?php $markers = 0;
			if ( ! empty( $json['overlays']['marker'] ) ) : ?>
				<?php foreach ( $json['overlays']['marker'] as $i => $overlay ) : ?>
					<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_marker" border="0" cellspacing="0" cellpadding="0" data-table-num="<?php echo $i + 1;?>">
						<tr>
							<td class="intergeo_tlbr_marker_title_td">
								<?php if ( empty( $overlay['title'] ) ) : ?>
									#<?php echo $i + 1 ?> <?php esc_html_e( 'marker', 'intergeo-maps' ) ?>
								<?php else : ?>
									<?php echo esc_html( $overlay['title'] ) ?>
								<?php endif; $markers ++; ?>
							</td>
							<td>
								<input type="hidden" class="intergeo_tlbr_marker_location" name="overlays_marker[<?php echo $i ?>][position]" value="<?php echo esc_attr( implode( ',', $overlay['position'] ) ) ?>" data-position="<?php echo $i ?>">
								<input type="hidden" class="intergeo_tlbr_marker_title" name="overlays_marker[<?php echo $i ?>][title]" value="<?php echo esc_attr( $overlay['title'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_marker_icon" name="overlays_marker[<?php echo $i ?>][icon]" value="<?php echo esc_attr( $overlay['icon'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_marker_info" name="overlays_marker[<?php echo $i ?>][info]" value="<?php echo esc_attr( $overlay['info'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_marker_loc" name="overlays_marker[<?php echo $i ?>][loc]" value="<?php echo esc_attr( isset( $overlay['loc'] ) ? $overlay['loc'] : '' ) ?>">

								<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete marker', 'intergeo-maps' ) ?>"></a>
								<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit marker', 'intergeo-maps' ) ?>"></a>
							</td>
						</tr>
					</table>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>


		<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_marker_add" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td class="intergeo_tlbr_marker_title_td_add">
					<?php
					if ( intergeo_check_markers( $markers ) ) {
					?>
					<input type="button" id="intergeo_add_marker_bttn" class="button button-secondary button-small" value="<?php esc_html_e( 'Add Marker', 'intergeo-maps' );?>">
					<a  target="_blank" href="<?php echo INTERGEO_PRO_URL; ?>" style='display:none' class="intergeo-pro-btn button"><?php _e( 'Buy PRO version to add more markers', 'intergeo-maps' ) ?></a>
					<?php } else { ?>

							<a  target="_blank" href="<?php echo INTERGEO_PRO_URL; ?>" class="intergeo-pro-btn button"><?php _e( 'Buy PRO version to add more markers', 'intergeo-maps' ) ?></a>
					<?php } ?>
				</td>
			</tr>
		</table>

		</div>

	</li>
</ul>
