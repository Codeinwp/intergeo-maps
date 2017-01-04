<h3 class="intergeo_tlbr_ul_li_h3"><?php esc_html_e( 'Directions', 'intergeo' ) ?></h3>
<ul class="intergeo_tlbr_ul_li_ul">
	<?php
	if ( ! intergeo_is_developer() ) {
		?>
		<a  target="_blank" href="<?php echo INTERGEO_PRO_URL; ?>"   class="intergeo-pro-btn button"><?php _e( 'Available in Developer plan', 'intergeo' ) ?></a>
		<?php
	} else {
	?>
	<li class="intergeo_tlbr_ul_li_ul_li">
		<p class="intergeo_tlbr_grp_dsc">
			<?php esc_html_e( 'To add a new direction just click the button below', 'intergeo' ) ?>:
		</p>
		<p class="intergeo_tlbr_grp_dsc">
			<a id="intergeo_tlbr_new_drctn" class="button button-small" href="javascript:;">
				<span id="intergeo_tlbr_drctn_icon"></span>
				<?php esc_html_e( 'Add Direction', 'intergeo' ) ?>
			</a>
		</p>
	</li>
	<li class="intergeo_tlbr_ul_li_ul_li">

		<script id="intergeo_tlbr_drctn_ttl_tmpl" type="text/html">
			#%num% <?php esc_html_e( 'from', 'intergeo' ) ?> %from% <?php esc_html_e( 'to', 'intergeo' ) ?> %to% %mode%
		</script>
		<script id="intergeo_tlbr_drctn_tmpl" type="text/html">
			<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_drctn" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="intergeo_tlbr_direction_title_td">
						#%num% <?php esc_html_e( 'from', 'intergeo' ) ?> %from% <?php esc_html_e( 'to', 'intergeo' ) ?> %to% %mode%
					</td>
					<td>
						<input type="hidden" class="intergeo_tlbr_drctn_from" name="directions[%pos%][from]" data-position="%pos%">
						<input type="hidden" class="intergeo_tlbr_drctn_to" name="directions[%pos%][to]">
						<input type="hidden" class="intergeo_tlbr_drctn_mode" name="directions[%pos%][mode]">

						<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete direction', 'intergeo' ) ?>"></a>
						<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit direction', 'intergeo' ) ?>"></a>
					</td>
				</tr>
			</table>
		</script>		
		<span class="intergeo_tlbr_cntrl_ttl"><?php esc_html_e( 'Created directions', 'intergeo' ) ?></span>
		<div id="intergeo_tlbr_drctns" class="intergeo_tlbr_cntrl_items">
			<?php if ( ! empty( $json['directions'] ) ) : ?>
				<?php foreach ( $json['directions'] as $i => $direction ) : ?>
					<table class="intergeo_tlbr_cntrl_tbl intergeo_tlbr_overlay intergeo_tlbr_drctn" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="intergeo_tlbr_direction_title_td">
								#<?php echo $i + 1 ?> 
								<?php esc_html_e( 'from', 'intergeo' ) ?>
								<?php echo esc_html( $direction['from'] ) ?> 
								<?php esc_html_e( 'to', 'intergeo' ) ?>
								<?php echo esc_html( $direction['to'] ) ?> 
								<?php
								switch ( $direction['mode'] ) :
									case 'BICYCLING':
										esc_html_e( 'via bicycle paths & preferred streets', 'intergeo' );
										break;
									case 'TRANSIT':
										esc_html_e( 'via public transit routes', 'intergeo' );
										break;
									case 'WALKING':
										esc_html_e( 'via pedestrian paths & sidewalks', 'intergeo' );
										break;
									case 'DRIVING':
									default:
										esc_html_e( 'via standard driving directions', 'intergeo' );
										break;
									endswitch;
								?>
							</td>
							<td>
								<input type="hidden" class="intergeo_tlbr_drctn_from" name="directions[<?php echo $i ?>][from]" data-position="<?php echo $i ?>" value="<?php echo esc_attr( $direction['from'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_drctn_to" name="directions[<?php echo $i ?>][to]" value="<?php echo esc_attr( $direction['to'] ) ?>">
								<input type="hidden" class="intergeo_tlbr_drctn_mode" name="directions[<?php echo $i ?>][mode]" value="<?php echo esc_attr( $direction['mode'] ) ?>">

								<a class="intergeo_tlbr_actn_delete intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Delete direction', 'intergeo' ) ?>"></a>
								<a class="intergeo_tlbr_actn_edit intergeo_tlbr_actn" href="javascript:;" title="<?php esc_attr_e( 'Edit direction', 'intergeo' ) ?>"></a>
							</td>
						</tr>
					</table>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</li>
	<?php
	}
	?>
</ul>
