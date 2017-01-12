<div class="wrap">
    <?php
	if ( ! get_option( 'intergeo_map_api_key' ) ) {
	?>
	<div class="notice notice-warning"><p><?php echo sprintf( __( 'You have not added an API Key. Your maps may not display properly. Please add an API Key %1$s here %2$s', 'intergeo-maps' ), "<a href='" . admin_url( 'options-general.php?page=' . INTERGEO_PLUGIN_NAME ) . "'>", '</a>' );?></p></div>
	<?php
	}
	?>
	<h2>
		<div id="intergeo_lbrr_ttl">Inter<span style="color:#4067dc">g</span><span style="color:#e21b31">e</span><span style="color:#fcaa08">o</span> <?php _e( 'Maps', 'intergeo-maps' ) ?></div>
		<?php if ( intergeo_check_maps_number() ) : ?>
		    <a id="intergeo_lbrr_add_new" href="javascript:;" class="intergeo_lbrr_add_new add-new-h2"><?php _e( 'Add New', 'intergeo-maps' ) ?></a>
		<?php else : ?>
			<a  target="_blank" href="<?php echo INTERGEO_PRO_URL; ?>" class="intergeo-pro-btn add-new-h2"><?php _e( 'Buy PRO version to add more maps', 'intergeo-maps' ) ?></a>
		<?php endif; ?>

		<a id="intergeo_lbrr_settings" href="<?php echo admin_url( 'options-general.php?page=' . INTERGEO_PLUGIN_NAME );?>" class="add-new-h2"><?php _e( 'Maps Settings', 'intergeo-maps' ) ?></a>
	</h2>
	
	<script type="text/javascript">
		/* <![CDATA[ */
		window.intergeo_maps = [];
		window.intergeo_maps_maps = [];
		/* ]]> */
	</script>
	
	<div id="intergeo_library" class="intergeo_library">
		<div id="intergeo_sidebar" class="intergeo_sidebar_right">
			<?php
			if ( ! intergeo_is_developer() ) :
			?>
			<div class="intergeo_sidebar_pro">
			<span class="maps-available"><span class="dashicons dashicons-location"></span> <?php echo intergeo_get_maps(); ?>/<?php
			if ( intergeo_is_personal() ) {
				echo 10;
			} else {
				echo 3;
			}
				?> maps available</span>
				<h3>Upgrade to <?php
				if ( intergeo_is_personal() ) {
					echo 'Devloper Plan';
				} else {
					echo 'PRO';
				}
				?></h3>
				<ul>
				<li>Unlimited maps</li>

				<?php
				if ( ! intergeo_is_personal() ) :
					?>
					<li>Unlimited markers</li>
	                <?php endif; ?>
					<li>Custom layers</li>
					<li>Add directions</li>
					<li>Adsense integrations</li>
					<li>Import/export markers</li>
				</ul>
				<a href="<?php echo INTERGEO_PRO_URL?>" target="_blank" class="btn">Upgrade Now</a>
			</div>
			<?php endif; ?>
	            <?php
	            do_action( INTERGEO_PLUGIN_NAME . '_render_subscribe_box' );
	            ?>
		</div>

	<?php if ( $query->have_posts() ) : ?>
	
		<div id="intergeo_lbrr_items" class="intergeo_sidebar_left"><?php
			$index = 0;
		while ( $query->have_posts() ) :
			$post = $query->next_post();

			$id = intergeo_encode( $post->ID );
			$json = json_decode( $post->post_content, true );

			$delete_url = add_query_arg( array(
				'map'      => $id,
				'do'       => 'delete',
				'noheader' => 'true',
				'nonce'    => wp_create_nonce( $post->ID . filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ) ),
			) );

			$libraries = intergeo_check_libraries( $json, $libraries );

		?><div class="intergeo_lbrr_item"<?php echo $index != 0 && $index % 3 == 0 ? ' style="clear:both"' : '' ?>>
			<div class="intergeo_lbrr_wrapper">
				<div class="intergeo_lbrr_map_wrapper">
					<div class="intergeo_lbrr_map_loader">
						<div id="intergeo_map<?php echo $id ?>" class="intergeo_lbrr_map"></div>
					</div>
				</div>
				<table class="intergeo_lbrr_cntrls" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td>
							<input type="text" class="intergeo_lbrr_code" value="[intergeo id=&quot;<?php echo $id ?>&quot;]<?php echo ! empty( $json['address'] ) ? esc_attr( $json['address'] ) : '' ?>[/intergeo]">
						</td>
						<td class="intergeo_lbrr_item_actions">
							<a class="intergeo_lbrr_item_edit" href="javascript:;" title="<?php _e( 'Edit', 'intergeo-maps' ) ?>" data-map="<?php echo $id  ?>"></a>
							<a class="intergeo_lbrr_item_copy" href="javascript:;" title="<?php _e( 'Copy', 'intergeo-maps' ) ?>" data-map="<?php echo $id  ?>"></a>
							<a class="intergeo_lbrr_item_delete" href="<?php echo esc_attr( $delete_url ) ?>" title="<?php _e( 'Delete', 'intergeo-maps' ) ?>" onclick="return showNotice.warn();"></a>
						</td>
					</tr>
				</table>
			</div>
			</div>
			<script type="text/javascript">
			/* <![CDATA[ */
			window.intergeo_maps.push({
				container: 'intergeo_map<?php echo $id ?>', 
				options: <?php echo $post->post_content ?> 
			});
			/* ]]> */
			</script><?php

				$index++;
			endwhile;

			?><div style="clear:both"></div>
			</div>
		</div>

		<?php if ( ! empty( $pagination ) ) : ?>
		<div class="clear">
			<ul id="intergeo_lbrr_pgntn">
				<?php foreach ( $pagination as $page_item ) : ?>
				<li><?php echo $page_item ?></li>
				<?php endforeach; ?>
			</ul>
			<div style="clear:both"></div>
		</div>
		<?php endif; ?>
	
	<?php else : ?>
		<p>
			<?php esc_html_e( 'You do not have created maps. Start adding it by clicking "Add New" button.', 'intergeo-maps' ) ?>
		</p>
	<?php endif; ?>
</div>
