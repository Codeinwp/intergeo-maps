<div id="intergeo_address_ppp" class="intergeo_ppp">
	<form class="intergeo_ppp_frm">
		<div class="intergeo_ppp_ttl">
			<a class="intergeo_ppp_cls" href="javascript:;"></a>
			<?php esc_html_e( 'Go To Address', 'intergeo' ) ?>
		</div>
		<table class="intergeo_ppp_tbl" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td>
					<input type="text" class="intergeo_ppp_txt" placeholder="<?php esc_attr_e( 'Type an address you want to go to', 'intergeo' ) ?>">
				</td>
				<td style="width:40px;text-align:right">
					<button type="submit" class="button button-primary"><?php esc_html_e( 'Go', 'intergeo' ) ?></button>
				</td>
			</tr>
		</table>
	</form>
</div>

<div id="intergeo_marker_ppp" class="intergeo_ppp">
	<form class="intergeo_ppp_frm intregeo_ppp_frm_overlay" data-position="" data-target="markers">
		<div class="intergeo_ppp_ttl">
			<a class="intergeo_ppp_cls" href="javascript:;"></a>
			<?php esc_html_e( 'Marker Options', 'intergeo' ) ?>
		</div>
		<table class="intergeo_ppp_tbl" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td>
					<input type="text" 
						   class="intergeo_tlbr_marker_title intergeo_tlbr_cntrl_txt" 
						   placeholder="<?php esc_attr_e( 'Enter title', 'intergeo' ) ?>"
						   title="<?php esc_attr_e( 'Enter title', 'intergeo' ) ?>">
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" 
						   class="intergeo_tlbr_marker_address intergeo_tlbr_cntrl_txt" 
						   placeholder="<?php esc_attr_e( 'Enter address or lat, long', 'intergeo' ) ?>"
						   title="<?php esc_attr_e( 'Enter address or lat, long', 'intergeo' ) ?>">
					<input type="hidden" name="intergeo_tlbr_marker_address_hidden" value="">
				</td>
			</tr>
			<tr>
				<td>
					<select name="intergeo_tlbr_marker_icon_select" id="intergeo_tlbr_marker_icon_select" class="intergeo_tlbr_marker_icon_select intergeo_tlbr_cntrl_txt">
						<option value="//maps.google.com/mapfiles/ms/icons/red-dot.png" data-imagesrc="//maps.google.com/mapfiles/ms/icons/red-dot.png"><?php _e( 'Default', 'intergeo' );?></option>
						<option value="//maps.google.com/mapfiles/ms/icons/blue-dot.png" data-imagesrc="//maps.google.com/mapfiles/ms/icons/blue-dot.png"><?php _e( 'Blue', 'intergeo' );?></option>
						<option value="custom"><?php _e( 'Custom', 'intergeo' );?></option>
					</select>
					<input type="text" style="display: none"
						   class="intergeo_tlbr_marker_icon intergeo_tlbr_cntrl_txt" 
						   placeholder="<?php esc_attr_e( 'Enter icon URL', 'intergeo' ) ?>"
						   title="<?php esc_attr_e( 'Enter icon URL', 'intergeo' ) ?>"
						   value="//maps.google.com/mapfiles/ms/icons/red-dot.png"
					>
				</td>
			</tr>
			<tr>
				<td>
					<?php wp_editor( '', 'intergeo-marker-editor', array( 'media_buttons' => false, 'textarea_rows' => 5, 'teeny' => true, 'editor_class' => 'intergeo_tlbr_marker_info intergeo_tlbr_cntrl_txt', 'quicktags' => false ) );?>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Update', 'intergeo' ) ?>">
				</td>
			</tr>
		</table>
	</form>
</div>

<div id="intergeo_polyline_ppp" class="intergeo_ppp">
	<form class="intergeo_ppp_frm intregeo_ppp_frm_overlay" data-position="" data-target="polyline">
		<div class="intergeo_ppp_ttl">
			<a class="intergeo_ppp_cls" href="javascript:;"></a>
			<?php esc_html_e( 'Polyline Options', 'intergeo' ) ?>
		</div>
		<table class="intergeo_ppp_tbl" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td class="intergeo_tlbr_cntrl_tbl_clmn">
					<input type="text" 
						   class="intergeo_tlbr_polyline_weight intergeo_tlbr_cntrl_txt" 
						   placeholder="<?php esc_attr_e( 'Stroke weight in pixel', 'intergeo' ) ?>"
						   title="<?php esc_attr_e( 'Stroke weight in pixel', 'intergeo' ) ?>">
				</td>
				<td class="intergeo_tlbr_cntrl_tbl_clmn">
					<input type="text" 
						   class="intergeo_tlbr_polyline_opacity intergeo_tlbr_cntrl_txt" 
						   placeholder="<?php esc_attr_e( 'Stroke opacity from 0.0 to 1.0', 'intergeo' ) ?>"
						   title="<?php esc_attr_e( 'Stroke opacity from 0.0 to 1.0', 'intergeo' ) ?>">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="text" class="intergeo_tlbr_polyline_color intergeo_tlbr_clr" maxlength="7" data-default-color="#000000">					
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Update', 'intergeo' ) ?>">
				</td>
			</tr>
		</table>
	</form>
</div>

<div id="intergeo_polyoverlay_ppp" class="intergeo_ppp">
	<form class="intergeo_ppp_frm intregeo_ppp_frm_overlay" data-position="" data-target="">
		<div class="intergeo_ppp_ttl">
			<a class="intergeo_ppp_cls" href="javascript:;"></a>
			<?php esc_html_e( 'Polygon Options', 'intergeo' ) ?>
		</div>
		<table class="intergeo_ppp_tbl" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td colspan="2">
					<b><?php esc_html_e( 'Stroke options', 'intergeo' ) ?></b>
				</td>
			</tr>
			<tr>
				<td class="intergeo_tlbr_cntrl_tbl_clmn">
					<input type="text" 
						   class="intergeo_tlbr_polyoverlay_weight intergeo_tlbr_cntrl_txt" 
						   placeholder="<?php esc_attr_e( 'Stroke weight in pixel', 'intergeo' ) ?>"
						   title="<?php esc_attr_e( 'Stroke weight in pixel', 'intergeo' ) ?>">
				</td>
				<td class="intergeo_tlbr_cntrl_tbl_clmn">
					<input type="text" 
						   class="intergeo_tlbr_polyoverlay_stroke_opacity intergeo_tlbr_cntrl_txt" 
						   placeholder="<?php esc_attr_e( 'Stroke opacity from 0.0 to 1.0', 'intergeo' ) ?>"
						   title="<?php esc_attr_e( 'Stroke opacity from 0.0 to 1.0', 'intergeo' ) ?>">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<select class="intergeo_tlbr_polyoverlay_position intergeo_tlbr_cntrl_slct">
						<option value=""><?php esc_html_e( 'stroke position', 'intergeo' ) ?></option>
						<option value="CENTER"><?php esc_html_e( 'center', 'intergeo' ) ?></option>
						<option value="INSIDE"><?php esc_html_e( 'inside the object', 'intergeo' ) ?></option>
						<option value="OUTSIDE"><?php esc_html_e( 'outside the object', 'intergeo' ) ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="text" class="intergeo_tlbr_polyoverlay_stroke_color intergeo_tlbr_clr" maxlength="7" data-default-color="#000000">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<b><?php esc_html_e( 'Fill options', 'intergeo' ) ?></b>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="text" 
						   class="intergeo_tlbr_polyoverlay_fill_opacity intergeo_tlbr_cntrl_txt" 
						   placeholder="<?php esc_attr_e( 'Fill opacity from 0.0 to 1.0', 'intergeo' ) ?>"
						   title="<?php esc_attr_e( 'Fill opacity from 0.0 to 1.0', 'intergeo' ) ?>">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="text" class="intergeo_tlbr_polyoverlay_fill_color intergeo_tlbr_clr" maxlength="7" data-default-color="#000000">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Update', 'intergeo' ) ?>">
				</td>
			</tr>
		</table>
	</form>
</div>

<div id="intergeo_drctn_ppp" class="intergeo_ppp">
	<form class="intergeo_ppp_frm intregeo_ppp_frm_overlay" data-position="" data-target="direction">
		<div class="intergeo_ppp_ttl">
			<a class="intergeo_ppp_cls" href="javascript:;"></a>
			<?php esc_html_e( 'Direction Options', 'intergeo' ) ?>
		</div>
		<table class="intergeo_ppp_tbl" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td>
					<input type="text" 
						   id="intergeo_ppp_drctn_from" class="intergeo_tlbr_cntrl_txt"
						   title="<?php esc_attr_e( 'The start location from which to calculate directions', 'intergeo' ) ?>"
						   placeholder="<?php esc_attr_e( 'The start location from which to calculate directions', 'intergeo' ) ?>">
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" 
						   id="intergeo_ppp_drctn_to" class="intergeo_tlbr_cntrl_txt"
						   title="<?php esc_attr_e( 'The end location to which to calculate directions', 'intergeo' ) ?>"
						   placeholder="<?php esc_attr_e( 'The end location to which to calculate directions', 'intergeo' ) ?>">
				</td>
			</tr>
			<tr>
				<td>
					<select id="intergeo_ppp_drctn_mode" class="intergeo_tlbr_cntrl_slct">
						<option value="DRIVING"><?php esc_html_e( 'via standard driving directions', 'intergeo' ) ?></option>
						<option value="BICYCLING"><?php esc_html_e( 'via bicycle paths & preferred streets', 'intergeo' ) ?></option>
						<option value="TRANSIT"><?php esc_html_e( 'via public transit routes', 'intergeo' ) ?></option>
						<option value="WALKING"><?php esc_html_e( 'via pedestrian paths & sidewalks', 'intergeo' ) ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Save', 'intergeo' ) ?>">
				</td>
			</tr>
		</table>
	</form>
</div>
