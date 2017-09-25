<?php
/**
 * Class for subscription box
 * User: Marius Cristea <marius@themeisle.com>
 */
if ( ! class_exists( 'THEMEISLE_SUBSCRIBE' ) ) {
	class THEMEISLE_SUBSCRIBE {
		/*
		 * The product slug for subscribe box
		 */
		/**
		 * The script version
		 *
		 * @var string Script version
		 */
		public $script_version = '1.0.0';
		/**
		 * The slug of the product
		 *
		 * @var Slug of the product which use this script
		 */
		public $product_slug;
		/**
		 * The script url
		 *
		 * @var The URL of the script
		 */
		public $script_url;
		/**
		 * The default title
		 *
		 * @var string The default title of the subscribe box
		 */
		public $default_title = 'Get Our Free Email Course';
		/**
		 * The defualt success message
		 *
		 * @var string The default success message of the subscribe box
		 */
		public $default_success = 'Thank you for subscribing! You have been added to the mailing list and will receive the next email information in the coming weeks. If you ever wish to unsubscribe, simply use the "Unsubscribe" link included in each newsletter.';
		/**
		 * Thhe default optin message
		 *
		 * @var string The default optin message for the box
		 */
		public $default_subscribe = 'Ready to learn how to reduce your website loading times by half? Come and join the 1st lesson here!';
		/**
		 * The defualt submit btn
		 *
		 * @var string The default submit btn string
		 */
		public $default_submit = 'Send Me ! ';

		/**
		 * THEMEISLE_SUBSCRIBE constructor.
		 *
		 * @param $slug
		 */
		public function __construct( $slug ) {
			$this->product_slug = str_replace( '-', '_', $slug );
			$this->load_hooks();
			$this->setup_vars();
		}

		/**
		 * Load all the hooks of the script
		 */
		public function load_hooks() {
			add_action( $this->product_slug . '_render_subscribe_box', array( $this, 'render_box' ) );
			add_action( 'wp_ajax_themeisle_sdk_subscribe_' . $this->product_slug, array( $this, 'ajax_subscribe' ) );
		}

		/**
		 * Load all the vars
		 */
		public function setup_vars() {
			$abs              = untrailingslashit( ( dirname( __FILE__ ) ) );
			$parts            = str_replace( untrailingslashit( ABSPATH ), '', $abs );
			$parts            = explode( DIRECTORY_SEPARATOR, $parts );
			$parts            = array_filter( $parts );
			$this->script_url = site_url() . '/' . implode( '/', $parts );

		}

		/**
		 * Render the box content
		 */
		public function render_box() {
			$subscribed = get_option( $this->product_slug . '_themeisle_sdk_subscribed', 'no' );
			if ( $subscribed === 'yes' ) {
				return '';
			}
			wp_enqueue_script( 'themeisle-sdk-subscribe', $this->script_url . '/subscribe.js', array( 'jquery' ), $this->script_version, true );
			wp_localize_script(
				'themeisle-sdk-subscribe', 'themeisle_sdk', array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				)
			);
			?>
			<div id='<?php echo $this->product_slug; ?>-subscribe-box' class=" themeisle-sdk-subscribe-box">
				<h3 class="themeisle-sdk-title"><?php echo esc_html( apply_filters( $this->product_slug . '_themeisle_subscribe_heading', $this->default_title ) ); ?></h3>
				<div class="themeisle-sdk-box-content">
					<?php
					$display = ( $subscribed !== 'no' ) ? '' : 'display:none';
					echo sprintf( '<div class="themeisle-sdk-subscrive-success" style="' . $display . '"><p> %s </p></div>', esc_html( apply_filters( $this->product_slug . '_themeisle_subscribed_msg', $this->default_success ) ) );
					if ( $subscribed === 'no' ) {
						echo sprintf( '<fieldset class="themeisle-sdk-subscribe-fieldset"><p> %s </p><input name="themeisle-sdk-subscribe-email" class="themeisle-sdk-subscribe-email" id="' . $this->product_slug . '-themeisle-sdk-email-field" data-nonce="' . wp_create_nonce( $this->product_slug . '_themeisle_sdk_subscribe_nonce' ) . '" type="email" value="' . get_option( 'admin_email' ) . '" /><input  type="button" id="' . $this->product_slug . '-themeisle-sdk-email-do" data-product-slug="' . $this->product_slug . '" class="themeisle-sdk-subscribe-btn button" value="' . apply_filters( $this->product_slug . '_themeisle_subscribe_submit', $this->default_submit ) . '"></fieldset>', esc_html( apply_filters( $this->product_slug . '_themeisle_subscribe_msg', $this->default_subscribe ) ) );
					}
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * The ajax subscribe action
		 */
		public function ajax_subscribe() {
			check_ajax_referer( $this->product_slug . '_themeisle_sdk_subscribe_nonce', 'nonce' );
			$email = $_POST['email'];
			if ( ! empty( $email ) ) {
				require_once( dirname( __FILE__ ) . '/mailin.php' );
				$user_info = get_userdata( get_current_user_id() );
				$mailin    = new Mailin( 'https://api.sendinblue.com/v2.0', 'cHW5sxZnzE7mhaYb' );
				$data      = array(
					'email'           => $email,
					'attributes'      => array(
						'NAME' => $user_info->first_name,
						'SURNAME' => $user_info->last_name,
					),
					'blacklisted'     => 0,
					'listid'          => array( apply_filters( $this->product_slug . '_themeisle_sdk_subscribe_list', 0 ) ),
					'blacklisted_sms' => 0,
				);
				$status    = $mailin->create_update_user( $data );
				if ( $status['code'] == 'success' ) {
					update_option( $this->product_slug . '_themeisle_sdk_subscribed', 'yes' );
					wp_send_json_success(
						array(
							'success' => true,
						)
					);
				}
			}
			wp_die();
		}

	}
}
