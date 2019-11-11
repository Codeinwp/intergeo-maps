<div class="wrap">
	<?php
	if ( ! get_option( 'intergeo_map_api_key' ) ) {
		?>
		<div class="notice notice-warning">
			<p><?php echo sprintf( __( 'You have not added an API Key. Your maps may not display properly. Please add an API Key %1$s here %2$s', 'intergeo-maps' ), "<a href='" . admin_url( 'options-general.php?page=' . INTERGEO_PLUGIN_NAME ) . "'>", '</a>' ); ?></p>
		</div>
		<?php
	}
	?>
	<h2>
		<div id="intergeo_lbrr_ttl">Inter<span style="color:#4067dc">g</span><span style="color:#e21b31">e</span><span
					style="color:#fcaa08">o</span> <?php _e( 'Maps', 'intergeo-maps' ); ?></div>

		<a id="intergeo_lbrr_add_new" href="javascript:;"
		   class="intergeo_lbrr_add_new add-new-h2"><?php _e( 'Add New', 'intergeo-maps' ); ?></a>

		<a id="intergeo_lbrr_settings"
		   href="<?php echo admin_url( 'options-general.php?page=' . INTERGEO_PLUGIN_NAME ); ?>"
		   class="add-new-h2"><?php _e( 'Maps Settings', 'intergeo-maps' ); ?></a>
	</h2>

	<script type="text/javascript">
		/* <![CDATA[ */
		window.intergeo_maps = [];
		window.intergeo_maps_maps = [];
		/* ]]> */
	</script>

	<div id="intergeo_library" class="intergeo_library">
		<div id="intergeo_sidebar" class="intergeo_sidebar_right">
			<h2>Intergeo recommends</h2>
			<?php

			do_action(
				TI_INTERGEO_PLUGIN_NAME . '_recommend_products', array(
					'otter-blocks' => 'Otter',
					'optimole-wp'  => 'OptiMole',
				), array(
					'neve' => 'Neve',
				), array( 'install' => __( 'More details', 'intergeo-maps' ) ), array( 'image' => 'icon' )
			);

			do_action( INTERGEO_PLUGIN_NAME . '_render_subscribe_box' );

			?>
		</div>

		<div id="intergeo_lbrr_items" class="intergeo_sidebar_left">

		<?php if ( ! defined( 'OTTER_BLOCKS_VERSION' ) && current_user_can( 'manage_options' ) && version_compare( get_bloginfo( 'version' ), '5.0', '>=' ) && ! get_option( 'intergeo_maps_otter_notice', false ) ) : ?>

			<?php
				$index = 0;

				$url = add_query_arg(
					array(
						'tab'       => 'plugin-information',
						'plugin'    => 'otter-blocks',
						'TB_iframe' => true,
						'width'     => 800,
						'height'    => 800,
					),
					network_admin_url( 'plugin-install.php' )
				);

				$dismiss = add_query_arg(
					array(
						'do'       => 'dismiss-notice',
						'noheader' => 'true',
						'nonce'    => wp_create_nonce( 'dismiss-notice' . filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ) ),
					)
				);

				$index ++;
			?>
			<div class="intergeo_lbrr_item intergeo_otter">
				<div class="intergeo_lbrr_wrapper">
					<img src="https://ps.w.org/otter-blocks/assets/icon-256x256.png?rev=2019293"/>

					<div class="intergeo_otter_details">
						<p class="intergeo_otter_title"><?php _e( 'Intergeo recommends Otter', 'intergeo-maps' ); ?></p>
						<p class="intergeo_otter_info"><?php _e( 'Intergeo recommends Otter for best in class Google Maps Builder for WordPress\'s new Block Editor.', 'intergeo-maps' ); ?></p>
					</div>

					<div class="intergeo_otter_actions">
						<a class="button button-default" href="<?php echo $dismiss; ?>"><?php _e( 'Dismiss', 'intergeo-maps' ); ?></a>

						<a class="button button-primary thickbox open-plugin-details-modal" href="<?php echo $url; ?>">
							<span class="dashicons dashicons-external"></span><?php _e( 'More details', 'intergeo-maps' ); ?>
						</a>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $query->have_posts() ) : ?>

			<?php
			if ( ! isset( $index ) ) {
				$index = 0;
			}

			while ( $query->have_posts() ) :
				$post = $query->next_post();

				$id   = intergeo_encode( $post->ID );
				$json = json_decode( $post->post_content, true );

				$delete_url = add_query_arg(
					array(
						'map'      => $id,
						'do'       => 'delete',
						'noheader' => 'true',
						'nonce'    => wp_create_nonce( $post->ID . filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ) ),
					)
				);

				$libraries = intergeo_check_libraries( $json, $libraries );

				?>
				<div class="intergeo_lbrr_item"<?php echo $index != 0 && $index % 3 == 0 ? ' style="clear:both"' : ''; ?>>
					<div class="intergeo_lbrr_wrapper">
						<div class="intergeo_lbrr_map_wrapper">
							<div class="intergeo_lbrr_map_loader">
								<div id="intergeo_map<?php echo $id; ?>" class="intergeo_lbrr_map"></div>
							</div>
						</div>
						<table class="intergeo_lbrr_cntrls" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td>
									<input type="text" class="intergeo_lbrr_code"
										   value="[intergeo id=&quot;<?php echo $id; ?>&quot;]<?php echo ! empty( $json['address'] ) ? esc_attr( $json['address'] ) : ''; ?>[/intergeo]">
								</td>
								<td class="intergeo_lbrr_item_actions">
									<a class="intergeo_lbrr_item_edit" href="javascript:;"
									   title="<?php _e( 'Edit', 'intergeo-maps' ); ?>"
									   data-map="<?php echo $id; ?>"></a>
									<a class="intergeo_lbrr_item_copy" href="javascript:;"
									   title="<?php _e( 'Clone', 'intergeo-maps' ); ?>"
									   data-map="<?php echo $id; ?>"></a>
									<a class="intergeo_lbrr_item_delete" href="<?php echo esc_attr( $delete_url ); ?>"
									   title="<?php _e( 'Delete', 'intergeo-maps' ); ?>"
									   onclick="return showNotice.warn();"></a>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<script type="text/javascript">
					/* <![CDATA[ */
					window.intergeo_maps.push({
						container: 'intergeo_map<?php echo $id; ?>',
						options: <?php echo $post->post_content; ?>
					});
					/* ]]> */
				</script>
				<?php

				$index ++;
			endwhile;

			?>

			<?php if ( ! empty( $pagination ) ) : ?>
				<div class="clear">
					<ul id="intergeo_lbrr_pgntn">
						<?php foreach ( $pagination as $page_item ) : ?>
							<li><?php echo $page_item; ?></li>
						<?php endforeach; ?>
					</ul>
					<div style="clear:both"></div>
				</div>
			<?php endif; ?>

			<?php else : ?>
				<p>
					<?php esc_html_e( 'You do not have created maps. Start adding it by clicking "Add New" button.', 'intergeo-maps' ); ?>
				</p>
			<?php endif; ?>
			<div style="clear:both"></div>

		</div>
	</div>
</div>
