		<div class="">
			<h3 class="title"><?php esc_html_e( apply_filters('themeisle_subscribe_heading', 'Some heading'), INTERGEO_PLUGIN_NAME )?></h3>
			<div class="">
				<?php
                    $subscribed     = get_option('themeisle_subscribed', false);
                    $display        = $subscribed ? "" : "display:none";
                    echo sprintf( '<div class="ti-subscribe-success" style="' . $display . '"><p> %s </p></div>', esc_html__( apply_filters('themeisle_subscribed_msg', 'Thank you for subscribing! You have been added to the mailing list and will receive the next email information in the coming weeks. If you ever wish to unsubscribe, simply use the "Unsubscribe" link included in each newsletter.'), INTERGEO_PLUGIN_NAME ) );

                    if (!$subscribed) {
                        echo sprintf( '<fieldset class="ti-fieldset"><p> %s </p><input name="ti_subscribe_mail" id="ti_subscribe_mail" data-nonce="' . wp_create_nonce("themeisle_subscribe") . '" type="email" value="'.get_option( 'admin_email' ) .'" /><input class="button" type="button" id="ti_subscribe" value="'. __("Submit", INTERGEO_PLUGIN_NAME) . '"></fieldset>', esc_html__(apply_filters('themeisle_subscribe_msg', 'Ready to learn how to reduce your website loading times by half? Come and join the 1st lesson here!'), INTERGEO_PLUGIN_NAME ) );
                    }
                ?>
			</div>
		</div>
