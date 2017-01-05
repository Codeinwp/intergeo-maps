<li class="intergeo_tlbr_ul_li_ul_li">
    <p class="intergeo_tlbr_grp_dsc">
        <?php esc_html_e( 'To import data, please import a CSV file. Here is a sample', 'intergeo-maps' ) ?>
		: <a href="<?php echo INTERGEO_ABSURL . 'samples/default.csv' ?>" target="_blank"><?php esc_html_e( 'Click here', 'intergeo-maps' ); ?></a>
	</p>
</li>

<li class="intergeo_tlbr_ul_li_ul_li">
	<div class="intergeo_tlbr_cntrl_items" style="display:block">
		<div class="form-inline">
			<div class="button button-primary file-wrapper computer-btn">
				<input type="hidden" name="csvfileorig" value="<?php echo (isset( $json['xml'] ) ? $json['xml'] : '') ?>">
				<input type="hidden" name="layer_importcsv" id="layer_importcsv" value="<?php echo isset( $json['layer']['importcsv'] ) ? 1 : 0?>">
				<input type="file" id="csvfile" class="file" name="import_csv">
				<?php esc_attr_e( 'From Computer', 'intergeo-maps' ) ?>
			</div>
		</div>
	</div>
</li>

<li class="intergeo_tlbr_ul_li_ul_li">
	<p class="intergeo_tlbr_grp_dsc">
		<?php esc_html_e( 'To export data, click on the button below', 'intergeo-maps' ) ?>
	</p>
</li>

<li class="intergeo_tlbr_ul_li_ul_li">
	<div class="intergeo_tlbr_cntrl_items" style="display:block">
		<div class="form-inline">
			<div class="button button-primary file-wrapper computer-btn" id="intergeo_export_csv">
				<input type="button" class="file">
				<?php esc_attr_e( 'Export markers as CSV', 'intergeo-maps' ) ?>
			</div>
		</div>
	</div>
</li>
