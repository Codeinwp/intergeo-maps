<?php
/*
Plugin Name: Intergeo - Google Maps Plugin
Plugin URI: http://themeisle.com/plugins/intergeo-maps-lite/
Description: A simple, easy and quite powerful Google Map tool to create, manage and embed custom Google Maps into your WordPress posts and pages. The plugin allows you to deeply customize look and feel of a map, add overlays like markers, rectangles, circles, polylines and polygons to your map. It could even be integraded with your Google Adsense account and show ad on your maps.
Version: 2.1.3
Author: Themeisle
Author URI: http://themeisle.com
License: GPL v2.0 or later
License URI: http://www.opensource.org/licenses/gpl-license.php
Text Domain: intergeo-maps
Domain Path: /languages
*/
// <editor-fold defaultstate="collapsed" desc="constants">
define( 'INTERGEO_PLUGIN_NAME', 'intergeo' ); // don't change it whatever
define( 'INTERGEO_VERSION', '2.1.3' );
define( 'INTERGEO_ABSPATH', dirname( __FILE__ ) );
define( 'INTERGEO_ABSURL', plugins_url( '/', __FILE__ ) );
defined( 'WPLANG' ) || define( 'WPLANG', '' );
define( 'INTERGEO_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'INTERGEO_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
define( 'INTERGEO_DEBUG', false );

if ( ! defined( 'INTERGEO_PRO_URL' ) ) {
	    define( 'INTERGEO_PRO_URL', 'http://themeisle.com/plugins/intergeo-maps/' );
}
// Added by Ash/Upwork
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="plugin init">
add_filter( 'plugin_action_links', 'intergeo_action_links', 10, 2 );
function intergeo_action_links( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		array_unshift(
			$links,
			sprintf( '<a href="%s">%s</a>', add_query_arg( 'page', INTERGEO_PLUGIN_NAME, admin_url( 'upload.php' ) ), __( 'Maps', 'intergeo-maps' ) ),
			sprintf( '<a href="%s">%s</a>', admin_url( 'options-media.php' ), __( 'Settings', 'intergeo-maps' ) )
		);
	}

	return $links;
}

add_action( 'admin_init', 'intergeo_admin_init' );
function intergeo_admin_init() {
	load_plugin_textdomain( INTERGEO_PLUGIN_NAME, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	register_post_type( INTERGEO_PLUGIN_NAME );
}

add_action( 'wp_enqueue_scripts', 'intergeo_frontend_enqueue_scripts' );
function intergeo_frontend_enqueue_scripts() {
	wp_register_style( 'intergeo-frontend', INTERGEO_ABSURL . 'css/frontend.css', array(), INTERGEO_VERSION );
}

add_action( 'plugins_loaded', 'intergeo_i18n' );
function intergeo_i18n() {
	$pluginDirName = dirname( plugin_basename( __FILE__ ) );
	$domain        = INTERGEO_PLUGIN_NAME;
	$locale        = apply_filters( 'plugin_locale', get_locale(), $domain );
	load_textdomain( $domain, WP_LANG_DIR . '/' . $pluginDirName . '/' . $domain . '-' . $locale . '.mo' );
	load_plugin_textdomain( $domain, '', $pluginDirName . '/languages/' );
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="settings">
function intergeo_settings() {
	if ( isset( $_POST['sb-intergeo'] ) && wp_verify_nonce( $_POST['intergeo-nonce'], 'intergeo-settings' ) ) {
		update_option( 'intergeo_map_api_key', sanitize_text_field( $_POST['intergeo_map_api_key'] ) );
		if ( intergeo_is_developer() ) {
			update_option( 'intergeo_adsense_publisher_id', sanitize_text_field( $_POST['intergeo_adsense_publisher_id'] ) );
		}
	}
	echo '<div class="wrap">
    <h2>
		<div id="intergeo_lbrr_ttl">Inter<span style="color:#4067dc">g</span><span style="color:#e21b31">e</span><span style="color:#fcaa08">o</span>' . __( 'Maps Settings', 'intergeo-maps' ) . '</div> ';
	if ( intergeo_check_maps_number() ) {
		echo '<a   href="' . admin_url( 'upload.php?page=' . INTERGEO_PLUGIN_NAME ) . '" class="add-new-h2">' . __( 'Create New Map', 'intergeo-maps' ) . '</a>';
	} else {
		echo '<a  target="_blank" href="' . INTERGEO_PRO_URL . '" class="intergeo-pro-btn add-new-h2">' . __( 'Buy PRO version to add more maps', 'intergeo-maps' ) . '</a>';
	}
	echo '<a id="intergeo_lbrr_settings" href="' . admin_url( 'upload.php?page=' . INTERGEO_PLUGIN_NAME ) . '" class="add-new-h2">' . __( 'View Existing Maps', 'intergeo-maps' ) . '</a>
	</h2>';
	echo '<div class="intergeo_settings">';
	echo '<div id="intergeo_sidebar" class="intergeo_sidebar_right">';
	do_action( 'intergeo_render_subscribe_box' );
	echo '</div>';
	echo '<div class="intergeo_sidebar_left">';
	echo "<form method='post' action=''>";
	register_setting( 'intergeo', 'intergeo-settings-map-api-key', 'trim' );
	add_settings_section( 'intergeo-settings-maps', __( 'Intergeo Google Maps', 'intergeo-maps' ), 'intergeo_settings_init_map', INTERGEO_PLUGIN_NAME );
	add_settings_field( 'intergeo_map_api_key', __( 'Maps API Key', 'intergeo-maps' ), 'intergeo_settings_print_field', INTERGEO_PLUGIN_NAME, 'intergeo-settings-maps', array(
		'<input type="text" name="%s" value="%s" class="regular-text">',
		'intergeo_map_api_key',
		esc_attr( get_option( 'intergeo_map_api_key' ) ),
	) );

	if (   intergeo_is_developer() ) {
		register_setting( 'intergeo', 'intergeo_adsense_publisher_id', 'trim' );
		add_settings_section( 'intergeo-settings-adsense', __( 'Intergeo Google Maps AdSense Integration', 'intergeo-maps' ), 'intergeo_settings_init_adsense', INTERGEO_PLUGIN_NAME );
		add_settings_field( 'intergeo_adsense_publisher_id', __( 'AdSense Publisher Id', 'intergeo-maps' ), 'intergeo_settings_print_field', INTERGEO_PLUGIN_NAME, 'intergeo-settings-adsense', array(
			'<input type="text" name="%s" value="%s" class="regular-text">',
			'intergeo_adsense_publisher_id',
			esc_attr( get_option( 'intergeo_adsense_publisher_id' ) ),
		) );
	}
	do_settings_sections( INTERGEO_PLUGIN_NAME );
	submit_button( __( 'Save Changes', 'intergeo-maps' ), 'primary', 'sb-intergeo' );
	wp_nonce_field( 'intergeo-settings', 'intergeo-nonce' );
	echo '</form>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
}

function intergeo_settings_init_map() {
	?><p><?php
	printf( esc_html__( ' Below shows how to find your API Key, after retrieving your key add it to the "Maps API Key" input box.', 'intergeo-maps' ) );
	?></p>

	<iframe width="560" height="315" src="https://www.youtube.com/embed/gbFDMBGPCcs" frameborder="0"
			allowfullscreen></iframe>
	<?php
}

function intergeo_settings_init_adsense() {

	if (   intergeo_is_developer() ) {
		?><p><?php
		printf( esc_html__( "Adding display ads to your map requires that you have an AdSense account enabled for AdSense for Content. If you don't yet have an AdSense account, %1\$ssign up%3\$s for one. Once you have done so (or if you already have an account) make sure you've also enabled the account with %2\$sAdSense for Content%3\$s.", 'intergeo-maps' ), '<a href="https://www.google.com/adsense/support/bin/answer.py?answer=10162" target="_blank">', '<a href="https://www.google.com/adsense/support/bin/answer.py?hl=en&answer=17470" target="_blank">', '</a>' )
		?></p><p><?php
		esc_html_e( 'Once you have an Adsense for Content account, you will have received an AdSense for Content (AFC) publisher ID. This publisher ID is used to link any advertising shown to your AdSense account, allowing you to share in advertising revenue when a user clicks on one of the ads shown on your maps.', 'intergeo-maps' )
		?></p><?php
	}
}

function intergeo_settings_print_field( array $args ) {
	vprintf( array_shift( $args ), $args );
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="common">
function intergeo_enqueue_google_maps_script( $libraries = false ) {
	global $wp_scripts;
	if ( is_array( $libraries ) ) {
		$libraries = implode( ',', $libraries );
	}
	if ( wp_script_is( 'google-maps-v3' ) ) {
		$params = array();
		$arr    = explode( '?', $wp_scripts->registered['google-maps-v3']->src );
		parse_str( end( $arr ), $params );
		$params['libraries']                           = implode( ',', array_unique( array_merge( isset( $params['libraries'] ) ? explode( ',', $params['libraries'] ) : array(), explode( ',', $libraries ) ) ) );
		$wp_scripts->registered['google-maps-v3']->src = '//maps.googleapis.com/maps/api/js?' . http_build_query( $params );

	} else {
		$lang   = explode( '_', WPLANG ? WPLANG : 'en_US' );
		$params = array(
			'region'   => isset( $lang[1] ) ? $lang[1] : 'US',
			'language' => $lang[0],
		);
		if ( ! empty( $libraries ) ) {
			$params['libraries'] = $libraries;
		}
		$api_key = get_option( 'intergeo_map_api_key' );
		if ( ! empty( $api_key ) ) {
			$params['key'] = $api_key;
		}
		if ( wp_script_is( 'google-maps' ) ) {
			wp_dequeue_script( 'google-maps' );
		}
		wp_enqueue_script( 'google-maps-v3', '//maps.googleapis.com/maps/api/js?' . http_build_query( $params ), array(), null );
	}
}

function intergeo_check_libraries( $json, $libraries = array() ) {
	if ( isset( $json['layer']['adsense'] ) && $json['layer']['adsense'] && ! in_array( 'adsense', $libraries ) ) {
		$libraries[] = 'adsense';
	}
	if ( isset( $json['layer']['panoramio'] ) && $json['layer']['panoramio'] && ! in_array( 'panoramio', $libraries ) ) {
		$libraries[] = 'panoramio';
	}
	if ( ( isset( $json['layer']['weather'] ) && $json['layer']['weather'] ) || ( isset( $json['layer']['cloud'] ) && $json['layer']['cloud'] ) ) {
		if ( ! in_array( 'weather', $libraries ) ) {
			$libraries[] = 'weather';
		}
	}

	return $libraries;
}

function intergeo_encode( $id ) {
	return strrev( rtrim( call_user_func( 'base64_' . 'encode', $id ), '=' ) );
}

function intergeo_decode( $code ) {
	return intval( call_user_func( 'base64' . '_decode', strrev( $code ) ) );
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="iframe">
// <editor-fold defaultstate="collapsed" desc="rendering">
add_filter( 'media_upload_tabs', 'intergeo_media_upload_tabs' );
function intergeo_media_upload_tabs( $tabs ) {
	$tabs['intergeo_map'] = __( 'Intergeo Maps', 'intergeo-maps' );

	return $tabs;
}

add_action( 'media_upload_intergeo_map', 'intergeo_map_popup_init' );
function intergeo_map_popup_init() {
	$post_id        = filter_input( INPUT_GET, 'post_id', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
	$map_id         = filter_input( INPUT_GET, 'map' );
	$send_to_editor = false;
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$shortcode = intergeo_save_map( $map_id, $post_id );
		if ( $post_id ) {
			$send_to_editor = $shortcode;
		} else {
			$args = array(
				'page'    => INTERGEO_PLUGIN_NAME,
				'updated' => date( 'YmdHis' ),
			);
			wp_redirect( add_query_arg( $args, admin_url( 'upload.php' ) ) );
			exit;
		}
	}
	intergeo_enqueue_google_maps_script( 'adsense,panoramio,weather,drawing,places' );
	wp_enqueue_script( 'jquery-ddslick', INTERGEO_ABSURL . 'js/jquery.ddslick.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'intergeo-editor', INTERGEO_ABSURL . 'js/editor.js', array(
		'jquery-ddslick',
		'wp-color-picker',
		'google-maps-v3',
	), time() );
	wp_localize_script( 'intergeo-editor', 'intergeo_options', array(
		'send_to_editor' => $send_to_editor,
		'is_pro' => intergeo_is_personal() ? 'yes' : 'no',
		'adsense'        => array( 'publisher_id' => get_option( 'intergeo_adsense_publisher_id' ) ),
		'ajaxurl'        => admin_url( 'admin-ajax.php' ),
		'nonce'          => wp_create_nonce( 'editor_popup' . filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ) ),
		'l10n'           => array(
			'marker' => __( 'marker', 'intergeo-maps' ),
			'error'  => array(
				'style'      => __( 'Styles are broken. Please, fix it and try again.', 'intergeo-maps' ),
				'directions' => __( 'Direction was not found.', 'intergeo-maps' ),
			),
		),
	) );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'intergeo-editor', INTERGEO_ABSURL . 'css/editor.css', array(), INTERGEO_VERSION );
	// Added by Ash/Upwork
	global $IntergeoMaps_Adv;
	$IntergeoMaps_Adv->enqueueScriptsAndStyles( array( 'intergeo-editor' ), array( 'mapID' => $map_id ) );
	// Added by Ash/Upwork
	wp_iframe( 'intergeo_iframe', $post_id, $map_id );
}

function intergeo_iframe( $post_id = false, $map_id = false ) {
	$publisher_id    = trim( get_option( 'intergeo_adsense_publisher_id' ) );
	$show_map_center = get_option( 'intergeo_show_map_center', true );
	$submit_text     = __( 'Insert into post', 'intergeo-maps' );
	if ( ! $post_id ) {
		$submit_text = __( 'Create the map', 'intergeo-maps' );
	}
	$copy = false;
	if ( ! $map_id ) {
		$copy   = true;
		$map_id = filter_input( INPUT_GET, 'copy' );
	}
	$json = array();
	if ( $map_id ) {
		$map = get_post( intergeo_decode( $map_id ) );
		if ( $map->post_type == INTERGEO_PLUGIN_NAME ) {
			$json = json_decode( $map->post_content, true );
			if ( ! $copy ) {
				$submit_text = __( 'Update the map', 'intergeo-maps' );
			}
		}
	}
	require INTERGEO_ABSPATH . '/templates/iframe/form.php';
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="filtering">
function intergeo_filter_value( $value, $array ) {
	$value = strtoupper( $value );

	return ! in_array( $value, $array ) ? null : $value;
}

function intergeo_filter_position( $position ) {
	return intergeo_filter_value( $position, array(
		'TOP_LEFT',
		'TOP_CENTER',
		'TOP_RIGHT',
		'RIGHT_TOP',
		'RIGHT_CENTER',
		'RIGHT_BOTTOM',
		'BOTTOM_RIGHT',
		'BOTTOM_CENTER',
		'BOTTOM_LEFT',
		'LEFT_BOTTOM',
		'LEFT_CENTER',
		'LEFT_TOP',
	) );
}

function intergeo_filter_map_type( $type ) {
	return intergeo_filter_value( $type, array( 'ROADMAP', 'TERRAIN', 'SATELLITE', 'HYBRID' ) );
}

function intergeo_filter_map_type_style( $style ) {
	return intergeo_filter_value( $style, array( 'DEFAULT', 'DROPDOWN_MENU', 'HORIZONTAL_BAR' ) );
}

function intergeo_filter_zoom_style( $style ) {
	return intergeo_filter_value( $style, array( 'DEFAULT', 'SMALL', 'LARGE' ) );
}

function intergeo_filter_wind_speed_units( $unit ) {
	return intergeo_filter_value( $unit, array( 'KILOMETERS_PER_HOUR', 'METERS_PER_SECOND', 'MILES_PER_HOUR' ) );
}

function intergeo_filter_temperature_units( $unit ) {
	return intergeo_filter_value( $unit, array( 'CELSIUS', 'FAHRENHEIT' ) );
}

function intergeo_filter_adsense_format( $format ) {
	return intergeo_filter_value( $format, array(
		'BANNER',
		'BUTTON',
		'HALF_BANNER',
		'LARGE_HORIZONTAL_LINK_UNIT',
		'LARGE_RECTANGLE',
		'LARGE_VERTICAL_LINK_UNIT',
		'LEADERBOARD',
		'MEDIUM_RECTANGLE',
		'MEDIUM_VERTICAL_LINK_UNIT',
		'SKYSCRAPER',
		'SMALL_HORIZONTAL_LINK_UNIT',
		'SMALL_RECTANGLE',
		'SMALL_SQUARE',
		'SMALL_VERTICAL_LINK_UNIT',
		'SQUARE',
		'VERTICAL_BANNER',
		'WIDE_SKYSCRAPER',
		'X_LARGE_VERTICAL_LINK_UNIT',
	) );
}

function intergeo_filter_custom_style( $style ) {
	$style = trim( $style );
	$json  = json_decode( $style, true );

	return empty( $json ) ? null : $json;
}

function intergeo_filter_overlays_marker( $marker ) {
	if ( ! isset( $marker['position'] ) || ! preg_match( '/^-?\d+\.?\d*,-?\d+\.?\d*$/', $marker['position'] ) ) {
		return false;
	}

	return array(
		'position' => explode( ',', $marker['position'] ),
		'icon'     => isset( $marker['icon'] ) ? filter_var( $marker['icon'], FILTER_VALIDATE_URL ) : '',
		'info'     => isset( $marker['info'] ) ? trim( preg_replace( '/\<\/?script.*?\>/is', '', $marker['info'] ) ) : '',
		'title'    => isset( $marker['title'] ) ? strip_tags( trim( $marker['title'] ) ) : '',
		'loc'      => isset( $marker['loc'] ) ? strip_tags( trim( $marker['loc'] ) ) : '',
	);
}

function intergeo_filter_overlays_polyline( $polyline ) {
	if ( ! isset( $polyline['path'] ) ) {
		return false;
	}
	$path = array();
	foreach ( explode( ';', $polyline['path'] ) as $point ) {
		if ( preg_match( '/^-?\d+\.?\d*,-?\d+\.?\d*$/', $point ) ) {
			$path[] = explode( ',', $point );
		}
	}
	if ( count( $path ) < 2 ) {
		return false;
	}

	return array(
		'path'    => $path,
		'weight'  => isset( $polyline['weight'] )
			? filter_var( $polyline['weight'], FILTER_VALIDATE_INT, array(
				'options' => array(
					'min_range' => 1,
					'default'   => '',
				),
			) )
			: '',
		'opacity' => isset( $polyline['opacity'] )
			? filter_var( $polyline['opacity'], FILTER_VALIDATE_FLOAT, array(
				'options' => array(
					'min_range' => 0,
					'max_range' => 1,
					'default'   => '',
				),
			) )
			: '',
		'color'   => isset( $polyline['color'] )
			? filter_var( $polyline['color'], FILTER_VALIDATE_REGEXP, array(
				'options' => array(
					'regexp'  => '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
					'default' => '#000000',
				),
			) )
			: '#000000',
	);
}

function intergeo_filter_overlays_polyoverlay( $polygon ) {
	if ( ! isset( $polygon['path'] ) ) {
		return false;
	}
	$path = array();
	foreach ( explode( ';', $polygon['path'] ) as $point ) {
		if ( preg_match( '/^-?\d+\.?\d*,-?\d+\.?\d*$/', $point ) ) {
			$path[] = explode( ',', $point );
		}
	}
	if ( count( $path ) < 2 ) {
		return false;
	}
	$position = isset( $polygon['position'] ) ? strtoupper( trim( $polygon['position'] ) ) : 'CENTER';

	return array(
		'path'           => $path,
		'position'       => in_array( $position, array( 'CENTER', 'INSIDE', 'OUTSIDE' ) ) ? $position : 'CENTER',
		'weight'         => isset( $polygon['weight'] ) ? filter_var( $polygon['weight'], FILTER_VALIDATE_INT, array(
			'options' => array(
				'min_range' => 1,
				'default'   => '',
			),
		) ) : '',
		'stroke_opacity' => isset( $polygon['stroke_opacity'] ) ? filter_var( $polygon['stroke_opacity'], FILTER_VALIDATE_FLOAT, array(
			'options' => array(
				'min_range' => 0,
				'max_range' => 1,
				'default'   => '',
			),
		) ) : '',
		'stroke_color'   => isset( $polygon['stroke_color'] ) ? filter_var( $polygon['stroke_color'], FILTER_VALIDATE_REGEXP, array(
			'options' => array(
				'regexp'  => '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
				'default' => '#000000',
			),
		) ) : '#000000',
		'fill_opacity'   => isset( $polygon['fill_opacity'] ) ? filter_var( $polygon['fill_opacity'], FILTER_VALIDATE_FLOAT, array(
			'options' => array(
				'min_range' => 0,
				'max_range' => 1,
				'default'   => '',
			),
		) ) : '',
		'fill_color'     => isset( $polygon['fill_color'] ) ? filter_var( $polygon['fill_color'], FILTER_VALIDATE_REGEXP, array(
			'options' => array(
				'regexp'  => '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
				'default' => '#000000',
			),
		) ) : '#000000',
	);
}

function intergeo_filter_directions( $direction ) {
	$to   = isset( $direction['to'] ) ? trim( $direction['to'] ) : '';
	$from = isset( $direction['from'] ) ? trim( $direction['from'] ) : '';
	if ( empty( $to ) || empty( $from ) ) {
		return false;
	}
	$mode = isset( $direction['mode'] ) ? strtoupper( trim( $direction['mode'] ) ) : 'DRIVING';

	return array(
		'mode' => in_array( $mode, array( 'BICYCLING', 'DRIVING', 'TRANSIT', 'WALKING' ) ) ? $mode : 'DRIVING',
		'from' => $from,
		'to'   => $to,
	);
}

function intergeo_filter_input() {
	$color_regexp    = '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/';
	$postion_filter  = array( 'filter' => FILTER_CALLBACK, 'options' => 'intergeo_filter_position' );
	$validationArray = array(
		'lat'                                   => array(
			'filter'  => FILTER_VALIDATE_FLOAT,
			'flags'   => FILTER_REQUIRE_SCALAR,
			'options' => array( 'min_range' => - 90, 'max_range' => 90, 'default' => 48.1366069 ),
		),
		'lng'                                   => array(
			'filter'  => FILTER_VALIDATE_FLOAT,
			'flags'   => FILTER_REQUIRE_SCALAR,
			'options' => array( 'min_range' => - 180, 'max_range' => 180, 'default' => 11.577085099999977 ),
		),
		'zoom'                                  => array(
			'filter'  => FILTER_VALIDATE_INT,
			'flags'   => FILTER_REQUIRE_SCALAR,
			'options' => array( 'min_range' => 0, 'max_range' => 19, 'default' => 5 ),
		),
		'address'                               => FILTER_SANITIZE_STRING,
		'map_mapTypeId'                         => array(
			'filter'  => FILTER_CALLBACK,
			'options' => 'intergeo_filter_map_type',
		),
		'map_draggable'                         => FILTER_VALIDATE_BOOLEAN,
		'map_minZoom'                           => array(
			'filter'  => FILTER_VALIDATE_INT,
			'flags'   => FILTER_REQUIRE_SCALAR,
			'options' => array( 'min_range' => 0, 'max_range' => 19, 'default' => 0 ),
		),
		'map_maxZoom'                           => array(
			'filter'  => FILTER_VALIDATE_INT,
			'flags'   => FILTER_REQUIRE_SCALAR,
			'options' => array( 'min_range' => 0, 'max_range' => 19, 'default' => 19 ),
		),
		'map_scrollwheel'                       => FILTER_VALIDATE_BOOLEAN,
		'map_zoomControl'                       => FILTER_VALIDATE_BOOLEAN,
		'map_zoomControlOptions_position'       => $postion_filter,
		'map_zoomControlOptions_style'          => array(
			'filter'  => FILTER_CALLBACK,
			'options' => 'intergeo_filter_zoom_style',
		),
		'map_panControl'                        => FILTER_VALIDATE_BOOLEAN,
		'map_panControlOptions_position'        => $postion_filter,
		'map_scaleControl'                      => FILTER_VALIDATE_BOOLEAN,
		'map_scaleControlOptions_position'      => $postion_filter,
		'map_mapTypeControl'                    => FILTER_VALIDATE_BOOLEAN,
		'map_mapTypeControlOptions_position'    => $postion_filter,
		'map_mapTypeControlOptions_style'       => array(
			'filter'  => FILTER_CALLBACK,
			'options' => 'intergeo_filter_map_type_style',
		),
		'map_mapTypeControlOptions_mapTypeIds'  => array(
			'filter'  => FILTER_CALLBACK,
			'flags'   => FILTER_REQUIRE_ARRAY,
			'options' => 'intergeo_filter_map_type',
		),
		'map_streetViewControl'                 => FILTER_VALIDATE_BOOLEAN,
		'map_streetViewControlOptions_position' => $postion_filter,
		'map_rotateControl'                     => FILTER_VALIDATE_BOOLEAN,
		'map_rotateControlOptions_position'     => $postion_filter,
		'map_overviewMapControl'                => FILTER_VALIDATE_BOOLEAN,
		'map_overviewMapControlOptions_opened'  => FILTER_VALIDATE_BOOLEAN,
		'layer_traffic'                         => FILTER_VALIDATE_BOOLEAN,
		'layer_bicycling'                       => FILTER_VALIDATE_BOOLEAN,
		'layer_cloud'                           => FILTER_VALIDATE_BOOLEAN,
		'layer_weather'                         => FILTER_VALIDATE_BOOLEAN,
		'weather_temperatureUnits'              => array(
			'filter'  => FILTER_CALLBACK,
			'options' => 'intergeo_filter_temperature_units',
		),
		'weather_windSpeedUnits'                => array(
			'filter'  => FILTER_CALLBACK,
			'options' => 'intergeo_filter_wind_speed_units',
		),
		'layer_panoramio'                       => FILTER_VALIDATE_BOOLEAN,
		'panoramio_tag'                         => FILTER_SANITIZE_STRING,
		'panoramio_userId'                      => FILTER_SANITIZE_STRING,
		'layer_adsense'                         => FILTER_VALIDATE_BOOLEAN,
		'adsense_format'                        => array(
			'filter'  => FILTER_CALLBACK,
			'options' => 'intergeo_filter_adsense_format',
		),
		'adsense_position'                      => $postion_filter,
		'adsense_backgroundColor'               => array(
			'filter'  => FILTER_VALIDATE_REGEXP,
			'options' => array(
				'regexp'  => $color_regexp,
				'default' => '#c4d4f3',
			),
		),
		'adsense_borderColor'                   => array(
			'filter'  => FILTER_VALIDATE_REGEXP,
			'options' => array(
				'regexp'  => $color_regexp,
				'default' => '#e5ecf9',
			),
		),
		'adsense_titleColor'                    => array(
			'filter'  => FILTER_VALIDATE_REGEXP,
			'options' => array(
				'regexp'  => $color_regexp,
				'default' => '#0000cc',
			),
		),
		'adsense_textColor'                     => array(
			'filter'  => FILTER_VALIDATE_REGEXP,
			'options' => array(
				'regexp'  => $color_regexp,
				'default' => '#000000',
			),
		),
		'adsense_urlColor'                      => array(
			'filter'  => FILTER_VALIDATE_REGEXP,
			'options' => array(
				'regexp'  => $color_regexp,
				'default' => '#009900',
			),
		),
		'container_width'                       => FILTER_SANITIZE_STRING,
		'container_height'                      => FILTER_SANITIZE_STRING,
		'container_styles'                      => FILTER_SANITIZE_STRING,
		'styles_type'                           => FILTER_SANITIZE_STRING,
		'styles_custom'                         => array(
			'filter'  => FILTER_CALLBACK,
			'options' => 'intergeo_filter_custom_style',
		),
		'overlays_marker'                       => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
		'overlays_polyline'                     => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
		'overlays_polygon'                      => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
		'overlays_rectangle'                    => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
		'overlays_circle'                       => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
		'directions'                            => array( 'filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY ),
	);
	$defaults        = array(
		'lat'                                   => 48.1366069,
		'lng'                                   => 11.577085099999977,
		'zoom'                                  => 5,
		'address'                               => '',
		'map_mapTypeId'                         => 'ROADMAP',
		'map_draggable'                         => true,
		'map_minZoom'                           => 0,
		'map_maxZoom'                           => 19,
		'map_scrollwheel'                       => true,
		'map_zoomControl'                       => true,
		'map_zoomControlOptions_position'       => null,
		'map_zoomControlOptions_style'          => 'DEFAULT',
		'map_panControl'                        => true,
		'map_panControlOptions_position'        => null,
		'map_scaleControl'                      => false,
		'map_scaleControlOptions_position'      => null,
		'map_mapTypeControl'                    => true,
		'map_mapTypeControlOptions_position'    => null,
		'map_mapTypeControlOptions_style'       => 'DEFAULT',
		'map_mapTypeControlOptions_mapTypeIds'  => array( 'ROADMAP', 'TERRAIN', 'SATELLITE', 'HYBRID' ),
		'map_streetViewControl'                 => true,
		'map_streetViewControlOptions_position' => null,
		'map_rotateControl'                     => true,
		'map_rotateControlOptions_position'     => null,
		'map_overviewMapControl'                => false,
		'map_overviewMapControlOptions_opened'  => false,
		'layer_traffic'                         => false,
		'layer_bicycling'                       => false,
		'layer_cloud'                           => false,
		'layer_weather'                         => false,
		'weather_temperatureUnits'              => null,
		'weather_windSpeedUnits'                => null,
		'layer_panoramio'                       => false,
		'panoramio_tag'                         => '',
		'panoramio_userId'                      => '',
		'layer_adsense'                         => false,
		'adsense_format'                        => null,
		'adsense_position'                      => null,
		'adsense_backgroundColor'               => '#c4d4f3',
		'adsense_borderColor'                   => '#e5ecf9',
		'adsense_titleColor'                    => '#0000cc',
		'adsense_textColor'                     => '#000000',
		'adsense_urlColor'                      => '#009900',
		'container_width'                       => '',
		'container_height'                      => '',
		'container_styles'                      => '',
		'styles_type'                           => 'DEFAULT',
		'styles_custom'                         => null,
		'overlays_marker'                       => array(),
		'overlays_polyline'                     => array(),
		'overlays_polygon'                      => array(),
		'overlays_rectangle'                    => array(),
		'overlays_circle'                       => array(),
		'directions'                            => array(),
	);
	// Added by Ash/Upwork
	global $IntergeoMaps_Adv;
	$IntergeoMaps_Adv->addValidations( $validationArray, $defaults );
	// Added by Ash/Upwork
	$options = filter_input_array( INPUT_POST, $validationArray );
	$results = array();
	foreach ( $options as $key => $value ) {
		if ( array_key_exists( $key, $defaults ) ) {
			$equals = $defaults[ $key ] == $value;
			if ( is_array( $value ) ) {
				$equals = ( count( $value ) == count( $defaults[ $key ] ) ) && ( count( array_diff( (array) $defaults[ $key ], $value ) ) == 0 );
			}
			if ( ! $equals ) {
				$results[ $key ] = $value;
			}
		}
	}
	if ( ! empty( $results['overlays_marker'] ) ) {
		$results['overlays_marker'] = array_filter( array_map( 'intergeo_filter_overlays_marker', $results['overlays_marker'] ) );
	}
	if ( ! empty( $results['overlays_polyline'] ) ) {
		$results['overlays_polyline'] = array_filter( array_map( 'intergeo_filter_overlays_polyline', $results['overlays_polyline'] ) );
	}
	if ( ! empty( $results['directions'] ) ) {
		$results['directions'] = array_filter( array_map( 'intergeo_filter_directions', $results['directions'] ) );
	}
	foreach ( array( 'polygon', 'rectangle', 'circle' ) as $overlay ) {
		$overlay = 'overlays_' . $overlay;
		if ( ! empty( $results[ $overlay ] ) ) {
			$results[ $overlay ] = array_filter( array_map( 'intergeo_filter_overlays_polyoverlay', $results[ $overlay ] ) );
		}
	}
	// Added by Ash/Upwork
	global $IntergeoMaps_Adv;
	$IntergeoMaps_Adv->processResults( $results );

	// Added by Ash/Upwork
	return $results;
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="saving">
function intergeo_save_map( $map_id = false, $post_id = false ) {
	$options   = array();
	$array_ptr = &$options;
	foreach ( intergeo_filter_input() as $key => $value ) {
		if ( ! is_null( $value ) ) {
			$keys     = explode( '_', $key );
			$last_key = array_pop( $keys );
			while ( $arr_key = array_shift( $keys ) ) {
				if ( ! array_key_exists( $arr_key, $array_ptr ) ) {
					$array_ptr[ $arr_key ] = array();
				}
				$array_ptr = &$array_ptr[ $arr_key ];
			}
			$array_ptr[ $last_key ] = $value;
			$array_ptr              = &$options;
		}
	}
	$address = '';
	if ( ! empty( $options['address'] ) ) {
		$address = $options['address'] = trim( $options['address'] );
	}
	$args   = array(
		'post_type'    => INTERGEO_PLUGIN_NAME,
		'post_content' => addcslashes( json_encode( $options ), '\\' ),
		'post_status'  => 'private',
	);
	$update = false;
	if ( $map_id ) {
		$post = get_post( intergeo_decode( $map_id ) );
		if ( $post && $post->post_type == INTERGEO_PLUGIN_NAME ) {
			$update     = true;
			$args['ID'] = $post->ID;
		}
	}
	$id = wp_insert_post( $args );
	if ( ! empty( $id ) && ! is_wp_error( $id ) ) {
		if ( ! $post_id ) {
			intergeo_set_info( $update
				? __( 'The map has been updated successfully.', 'intergeo-maps' )
				: __( 'The map has been created successfully.', 'intergeo-maps' )
			);
		}

		return sprintf( '[intergeo id="%s"]%s[/intergeo]', intergeo_encode( $id ), $address );
	}
	if ( ! $post_id ) {
		intergeo_set_error( $update
			? __( 'The map updating failed.', 'intergeo-maps' )
			: __( 'The map creation failed.', 'intergeo-maps' )
		);
	}

	return false;
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="ajax stuff">
add_action( 'wp_ajax_intergeo_show_map_center', 'intergeo_show_map_center_changed' );
function intergeo_show_map_center_changed() {
	$nonce = filter_input( INPUT_POST, 'nonce' );
	if ( wp_verify_nonce( $nonce, 'editor_popup' . filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ) ) ) {
		update_option( 'intergeo_show_map_center', (int) filter_input( INPUT_POST, 'status', FILTER_VALIDATE_BOOLEAN ) );
	}
}

// </editor-fold>
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="shortcode">
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'term_description', 'do_shortcode' );
add_shortcode( INTERGEO_PLUGIN_NAME, 'intergeo_shortcode' );
function intergeo_shortcode( $attrs, $address = '' ) {
	do_action( 'intergeo_shortcode_render_before', $attrs );
	$args    = shortcode_atts( array(
		'id'     => false,
		'hook'   => false,
		'width'  => false,
		'height' => false,
		'style'  => false,
		'zoom'   => false,
	), $attrs );
	$address = trim( $address );
	if ( empty( $args['id'] ) && empty( $address ) ) {
		return '';
	}
	$json = array();
	if ( ! empty( $args['id'] ) ) {
		$post = get_post( intergeo_decode( $args['id'] ) );
		if ( ! $post || $post->post_type != INTERGEO_PLUGIN_NAME ) {
			return '';
		}
		$json = json_decode( $post->post_content, true );
	} else {
		$args['id']   = intergeo_encode( rand( 0, 100 ) . rand( 0, 10000 ) );
		$json['zoom'] = intval( $args['zoom'] ) ? intval( $args['zoom'] ) : 15;
	}
	if ( ! empty( $address ) ) {
		$json['address'] = $address;
	}
	if ( trim( $args['hook'] ) != '' ) {
		$json = apply_filters( $args['hook'], $json );
	}
	wp_enqueue_style( 'intergeo-frontend' );
	intergeo_enqueue_google_maps_script( intergeo_check_libraries( $json ) );
	if ( ! wp_script_is( 'intergeo-rendering' ) ) {
		wp_enqueue_script( 'intergeo-rendering', INTERGEO_ABSURL . 'js/rendering.js', array(
			'jquery',
			'google-maps-v3',
		), INTERGEO_VERSION );
		wp_localize_script( 'intergeo-rendering', 'intergeo_options', array(
			'adsense' => array( 'publisher_id' => get_option( 'intergeo_adsense_publisher_id' ) ),
		) );
	}
	$container = array();
	if ( isset( $json['container'] ) ) {
		$container = $json['container'];
		unset( $json['container'] );
	}
	$width = ! empty( $container['width'] ) ? esc_attr( $container['width'] ) : '100%';
	if ( trim( $args['width'] ) != '' ) {
		$width = $args['width'];
	}
	if ( is_numeric( $width ) ) {
		$width .= 'px';
	}
	$height = ! empty( $container['height'] ) ? esc_attr( $container['height'] ) : '300px';
	if ( trim( $args['height'] ) != '' ) {
		$height = $args['height'];
	}
	if ( is_numeric( $height ) ) {
		$height .= 'px';
	}
	$styles = ! empty( $container['styles'] ) ? esc_attr( $container['styles'] ) : '';
	if ( trim( $args['style'] ) != '' ) {
		$styles = $args['style'];
	}

	return sprintf( '
		<div id="intergeo_map%1$s" class="intergeo_map_canvas" style="width:100%%;height:300px;width:%2$s;height:%3$s;%4$s"></div>
		<script type="text/javascript">
			/* <![CDATA[ */
			if (!window.intergeo_maps) window.intergeo_maps = [];
			window.intergeo_maps.push( { container: \'intergeo_map%1$s\', options: %5$s } );
			if (!window.intergeo_maps_current) window.intergeo_maps_current = null;
			/* ]]> */
		</script>
		',
		$args['id'],
		$width,
		$height,
		$styles,
		json_encode( $json )
	);
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="library">
add_action( 'admin_menu', 'intergeo_admin_menu' );
function intergeo_admin_menu() {
	$settings = add_options_page( __( 'Intergeo Maps Library', 'intergeo-maps' ), __( 'Intergeo Maps', 'intergeo-maps' ), 'edit_posts', INTERGEO_PLUGIN_NAME, 'intergeo_settings' );
	if ( $settings ) {
		add_action( "load-{$settings}", 'intergeo_settings_init' );
	}
	$library = add_submenu_page( 'upload.php', __( 'Intergeo Maps Library', 'intergeo-maps' ), __( 'Intergeo Maps', 'intergeo-maps' ), 'edit_posts', INTERGEO_PLUGIN_NAME, 'intergeo_library' );
	if ( $library ) {
		add_action( "load-{$library}", 'intergeo_library_init' );
	}
}

function intergeo_settings_init() {
	wp_enqueue_style( 'intergeo_library', INTERGEO_ABSURL . 'css/library.css', array(), INTERGEO_VERSION );
	wp_enqueue_script( 'themeisle-subscribe', INTERGEO_ABSURL . 'subscribe/subscribe.js', array( 'jquery' ) );
	wp_localize_script( 'themeisle-subscribe', 'ti', array() );
}

function intergeo_library_init() {
	wp_enqueue_style( 'intergeo_library', INTERGEO_ABSURL . 'css/library.css', array(), INTERGEO_VERSION );
	wp_enqueue_script( 'themeisle-subscribe', INTERGEO_ABSURL . 'subscribe/subscribe.js', array( 'jquery' ) );
	wp_localize_script( 'themeisle-subscribe', 'ti', array() );
	wp_enqueue_media();
	$screen = get_current_screen();
	$screen->add_help_tab( array(
		'title'   => esc_html__( 'Overview', 'intergeo-maps' ),
		'id'      => 'overview',
		'content' => sprintf( '<p>%s</p>', implode( '</p><p>', array(
			esc_html__( "The library is a list to view all maps you have created in your system. The library is showing you 3x3 grid of maps' previews. You will see the same maps embedded into your posts at front end, as you see here. The library is paginated and if you have more than 9 maps, you will see pagination links under maps grid.", 'intergeo-maps' ),
			esc_html__( 'To create a new map, click on "Add New" button next to the page title and map editor popup will appear. In case you want to edit a map, you can click on pencil icon in the right bottom corner of map preview box and edit popup window will appear.', 'intergeo-maps' ),
			esc_html__( "If you want to delete a map, click on the trash icon in the right bottom corner of a map and confirm your action. Pay attention that whole information about the map will be removed from the system, but all shortcodes will be left where you embed it. However these deprecated shortcodes won't be rendered anymore, so you don't have to worry about it while the plugin is enabled.", 'intergeo-maps' ),
		) ) ),
	) );
	$screen->add_help_tab( array(
		'title'   => esc_html__( 'Shortcodes', 'intergeo-maps' ),
		'id'      => 'shortcodes',
		'content' => sprintf( '<p>%s</p>', implode( '</p><p>', array(
			esc_html__( 'You can easily embed a map into your posts, pages, categories or tags descriptions and text widgets by copying shortcode which you can find in the input field of a map preview box.', 'intergeo-maps' ),
			esc_html__( 'To specify a certain address just type it inside a shortcode, and a map will be automatically centered at this place. Also each shortcode could be extended with custom attributes like width, height, style, zoom and hook. Use standard CSS values for such attributes as width, height and style. Type an integer between 0 and 19 for zoom attribute. You can use hook attribute to set up a filter hook which you can use in your custom plugin or theme to configure all options of a map.', 'intergeo-maps' ),
		) ) ),
	) );
}

function intergeo_library() {
	if ( filter_input( INPUT_GET, 'do' ) == 'delete' ) {
		intergeo_library_delete();
	}
	$query      = new WP_Query( array(
		'orderby'        => 'ID',
		'order'          => 'DESC',
		'post_type'      => INTERGEO_PLUGIN_NAME,
		'posts_per_page' => 9,
		'paged'          => filter_input( INPUT_GET, 'pagenum', FILTER_VALIDATE_INT, array(
			'options' => array(
				'min_range' => 1,
				'default'   => 1,
			),
		) ),
	) );
	$libraries  = array();
	$pagination = paginate_links( array(
		'base'    => add_query_arg( array(
			'pagenum' => '%#%',
			'updated' => false,
		) ),
		'format'  => '',
		'current' => max( 1, $query->get( 'paged' ) ),
		'total'   => $query->max_num_pages,
		'type'    => 'array',
	) );
	require INTERGEO_ABSPATH . '/templates/library/list.php';
	intergeo_enqueue_google_maps_script( $libraries );
	wp_enqueue_script( 'intergeo-rendering', INTERGEO_ABSURL . 'js/rendering.js', array(
		'jquery',
		'google-maps-v3',
	), INTERGEO_VERSION );
	wp_enqueue_script( 'intergeo-library', INTERGEO_ABSURL . 'js/library.js', array(
		'intergeo-rendering',
		'media-views',
	), INTERGEO_VERSION );
	wp_localize_script( 'intergeo-rendering', 'intergeo_options', array(
		'adsense' => array( 'publisher_id' => get_option( 'intergeo_adsense_publisher_id' ) ),
	) );
	// Added by Ash/Upwork
	global $IntergeoMaps_Adv;
	$IntergeoMaps_Adv->enqueueScriptsAndStyles( array( 'intergeo-rendering' ) );
	// Added by Ash/Upwork
}

function intergeo_library_delete() {
	if ( ! current_user_can( 'delete_posts' ) ) {
		return;
	}
	$id = intergeo_decode( trim( filter_input( INPUT_GET, 'map' ) ) );
	if ( ! $id ) {
		return;
	}
	$post = get_post( $id );
	if ( wp_verify_nonce( filter_input( INPUT_GET, 'nonce' ), $id . filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ) ) && $post->post_type == INTERGEO_PLUGIN_NAME ) {
		if ( wp_delete_post( $id, true ) ) {
			intergeo_set_info( __( 'The map was deleted successfully.', 'intergeo-maps' ) );
		}
	}
	if ( filter_input( INPUT_GET, 'noheader', FILTER_VALIDATE_BOOLEAN ) ) {
		wp_redirect( add_query_arg( 'page', INTERGEO_PLUGIN_NAME, admin_url( 'upload.php' ) ) );
		exit;
	}
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="messaging functions">
function intergeo_set_message( $message, $is_normal, $user_id = false ) {
	$messages = get_option( 'intergeo_messages', array() );
	if ( $user_id === false ) {
		$user_id = get_current_user_id();
	}
	if ( ! isset( $messages[ $user_id ] ) ) {
		$messages[ $user_id ] = array();
	}
	$messages[ $user_id ][] = array( $message, $is_normal );
	update_option( 'intergeo_messages', $messages );
}

function intergeo_set_info( $message, $user_id = false ) {
	intergeo_set_message( $message, 1, $user_id );
}

function intergeo_set_error( $message, $user_id = false ) {
	intergeo_set_message( $message, 0, $user_id );
}

add_action( 'admin_notices', 'intergeo_print_messages' );
function intergeo_print_messages() {
	global $pagenow;
	// Added by Ash/Upwork
	intergeo_show_nag();
	// Added by Ash/Upwork
	if ( $pagenow != 'upload.php' ) {
		return;
	}
	$messages = get_option( 'intergeo_messages', array() );
	$user_id  = get_current_user_id();
	if ( ! isset( $messages[ $user_id ] ) ) {
		return;
	}
	foreach ( $messages[ $user_id ] as $message ) {
		printf( $message[1] ? '<div class="updated"><p>%s</p></div>' : '<div class="error"><p>%s</p></div>', $message[0] );
	}
	$messages[ $user_id ] = array();
	update_option( 'intergeo_messages', $messages );
}

// Added by Ash/Upwork
add_action( 'admin_enqueue_scripts', 'intergeo_enqueue_scripts' );
function intergeo_enqueue_scripts() {
	wp_enqueue_script( 'intergeo-misc', INTERGEO_ABSURL . 'js/misc.js', array( 'jquery' ), INTERGEO_VERSION );
	wp_localize_script( 'intergeo-misc', 'intergeo_misc', array(
		'ajax' => array(
			'action'                    => 'intergeo_dismiss_nag',
			'themeisle_feedback_action' => 'themeisle_feedback_dismiss_nag',
			'themeisle_feedback_slug'   => INTERGEO_PLUGIN_NAME,
			'nonce'                     => wp_create_nonce( INTERGEO_PLUGIN_NAME . INTERGEO_VERSION ),
		),
	) );
}

add_action( 'wp_ajax_intergeo_dismiss_nag', 'intergeo_dismiss_nag' );
function intergeo_dismiss_nag() {
	check_ajax_referer( INTERGEO_PLUGIN_NAME . INTERGEO_VERSION, 'security' );
	update_option( 'intergeo_nag_dismissed', true );
	wp_die();
}

function intergeo_show_nag() {
	global $pagenow;
	if ( $pagenow == 'plugins.php' && ! get_option( 'intergeo_nag_dismissed', false ) ) {
		include_once INTERGEO_ABSPATH . '/templates/nag.php';
	}
}

add_action( 'admin_init', 'intergeo_init_triggered_feedback' );
function intergeo_init_triggered_feedback() {
	/*
	array(
		"name_of_trigger_filter_that_returns_true" => array(
			"behaviour"     => array(
				"show_when"     => strtotime compliant time,
				"show_where"    => "name_of_filter"
			),
			"notifications" => array(
				array(
					"description"       => mandatory, dont show the notification if this is empty,
					"button_ok_link"    => mandatory, dont show the notification if this is empty,
					"button_ok_text"    => mandatory, dont show the notification if thihs is empty,
					"button_hide_text"  => optional, default value is 'Hide',
					"button_done_text"  => optional, default value is "I've already done it"
				),
			)
		)
	)
	*/
	$feedback_config = array(
		'intergeo_created_3_maps'       => array(
			'behaviour'     => array(
				'show_when'  => '+6 hours',
				'show_where' => 'intergeo_triggered_feedback_show_notification_filter',
			),
			'notifications' => array(
				array(
					'description'      => 'Hey, looks like you’re doing a great job creating maps with the Intergeo plugin. Can you share your experience with other people who are using it ? ',
					'button_ok_link'   => 'http://bit.ly/2cNQyMz',
					'button_ok_text'   => ' Sure, I can do it  ',
					'button_hide_text' => 'Not now ',
					'button_done_text' => 'Already did it',
				),
				array(
					'description'      => 'Hey, looks like you’re doing a great job creating maps with the Intergeo plugin. Can you share your experience with other people who are using it ?',
					'button_ok_link'   => 'http://bit.ly/2cE92Qp',
					'button_ok_text'   => 'Yes, cool',
					'button_hide_text' => 'Not right now',
					'button_done_text' => 'Done it',
				),
				array(
					'description'      => 'Looks like you rock using the Intergeo plugin. Would you like to share your experience with others?',
					'button_ok_link'   => 'http://bit.ly/2cFhgv0',
					'button_ok_text'   => 'Yes, sure',
					'button_hide_text' => 'Not really',
					'button_done_text' => 'Already did',
				),
				array(
					'description'      => 'You’re quite productive using the Intergeo plugin. Would you like to share your experience with the rest of the users?',
					'button_ok_link'   => 'http://bit.ly/2cVFijo',
					'button_ok_text'   => 'Yes please',
					'button_hide_text' => 'Nope ',
					'button_done_text' => "I've done it already",
				),
			),
		),
		'intergeo_plugin_1week_old'     => array(
			'behaviour'     => array(
				'show_when'  => '+6 hours',
				'show_where' => 'intergeo_triggered_feedback_show_notification_filter',
			),
			'notifications' => array(
				array(
					'description'      => 'You’ve been using Intergeo plugin for over 1 week. Would you like to leave a review about your experience so far?',
					'button_ok_link'   => 'http://bit.ly/2d7Gq54',
					'button_ok_text'   => 'Yep ',
					'button_hide_text' => 'Nope ',
					'button_done_text' => ' Already did',
				),
				array(
					'description'      => 'How is Intergeo plugin working for you? Would you mind leaving a review for others to see how it works?',
					'button_ok_link'   => 'http://bit.ly/2cVFrDs',
					'button_ok_text'   => 'Sure  ',
					'button_hide_text' => ' Not today ',
					'button_done_text' => ' Already did ',
				),
				array(
					'description'      => 'We would love to get your feedback about using the Intergeo plugin so far. Can you share your thoughts with us in order to improve the future versions?',
					'button_ok_link'   => 'http://bit.ly/2bkAJuE',
					'button_ok_text'   => 'Okay   ',
					'button_hide_text' => ' Not now  ',
					'button_done_text' => ' I already did ',
				),
			),
		),
		'intergeo_map_frontend_display' => array(
			'behaviour'     => array(
				'show_when'  => '+6 hours',
				'show_where' => 'intergeo_triggered_feedback_show_notification_filter',
			),
			'notifications' => array(
				array(
					'description'      => 'Hey, it seems you are already using the Intergeo maps shortcode in your site and your users are enjoying it. How about rating this plugin, it would help others learn about it.',
					'button_ok_link'   => 'http://bit.ly/2cE9sGr',
					'button_ok_text'   => 'Sure ',
					'button_hide_text' => 'Not now',
					'button_done_text' => "I've already done it",
				),
				array(
					'description'      => 'It seems you are successfully using the Intergeo plugin and your users are enjoying it. Would you like to share your experience with other site owners?',
					'button_ok_link'   => 'http://bit.ly/2czU8st',
					'button_ok_text'   => 'Sure ',
					'button_hide_text' => 'Not now',
					'button_done_text' => "I've already done it",
				),
				array(
					'description'      => 'Looks like you have successfully published your first map with the Intergeo plugin. Would you like to rate your experience with the plugin?',
					'button_ok_link'   => 'http://bit.ly/2d1djQE',
					'button_ok_text'   => 'Sure ',
					'button_hide_text' => 'Not now',
					'button_done_text' => "I've already done it",
				),
			),
		),
	);
	// add the configuration with the slug and trigger the generic action
	do_action( 'themeisle_triggered_feedback_add_config', $feedback_config, INTERGEO_PLUGIN_NAME );
}

add_action( 'themeisle_triggered_feedback_add_config', 'themeisle_triggered_feedback_add_config', 10, 2 );
function themeisle_triggered_feedback_add_config( $config, $slug ) {
	global $pagenow;
	$trigger_time = $slug . '-triggered-feedback-time';
	$trigger_type = $slug . '-triggered-feedback-type';
	$fuse_lit     = get_option( $trigger_time, false );
	if ( $fuse_lit !== false ) {
		if ( ctype_digit( $fuse_lit ) && $fuse_lit != - 1 && time() >= $fuse_lit ) {
			// it is time to explode
			$trigger    = get_option( $trigger_type );
			$attributes = $config[ $trigger ];
			if ( apply_filters( $attributes['behaviour']['show_where'], $pagenow ) === true ) {
				$notification = $attributes['notifications'][ rand( 0, count( $attributes['notifications'] ) - 1 ) ];
				do_action( 'themeisle_triggered_feedback_show_notification', $notification, $slug );
			}
		}
	} else {
		// if multiple triggers are available, choose a random one
		$triggers_available = array();
		foreach ( $config as $trigger => $attributes ) {
			$pull_trigger = apply_filters( $trigger, false );
			if ( $pull_trigger === true ) {
				// light fuse
				$triggers_available[] = $trigger;
			}
		}
		if ( ! empty( $triggers_available ) ) {
			$trigger_fuse = $triggers_available[ rand( 0, ( count( $triggers_available ) - 1 ) ) ];
			update_option( $trigger_time, strtotime( $config[ $trigger_fuse ]['behaviour']['show_when'] ) );
			update_option( $trigger_type, $trigger );
		}
	}
}

global $themeisle_notification;
add_action( 'themeisle_triggered_feedback_show_notification', 'themeisle_triggered_feedback_show_notification', 10, 2 );
function themeisle_triggered_feedback_show_notification( $notification, $slug ) {
	global $themeisle_notification;
	if (
		! isset( $notification['description'] ) || empty( $notification['description'] )
		|| ! isset( $notification['button_ok_link'] ) || empty( $notification['button_ok_link'] )
		|| ! isset( $notification['button_ok_text'] ) || empty( $notification['button_ok_text'] )
	) {
		return;
	}
	if ( ! isset( $notification['button_hide_text'] ) || empty( $notification['button_hide_text'] ) ) {
		$notification['button_hide_text'] = __( 'Hide', 'intergeo-maps' );
	}
	if ( ! isset( $notification['button_done_text'] ) || empty( $notification['button_done_text'] ) ) {
		$notification['button_done_text'] = __( "I've already done it", 'intergeo-maps' );
	}
	$themeisle_notification = '
    <style type="text/css">.ti-feedback-notice .themeisle-feedback-click { margin-left:5px; }</style><div class="updated activated notice is-dismissible themeisle_triggered_feedback_nag">'
	                          . '<p>' . $notification['description'] . '</p>'
	                          . '<p class="ti-feedback-notice"><a href="' . $notification['button_ok_link'] . '" target="_new"><input type="button" class="button button-secondary themeisle-feedback-click" value="' . $notification['button_ok_text'] . '"></a>'
	                          . '<input type="button" class="button button-secondary themeisle-feedback-click" value="' . $notification['button_hide_text'] . '">'
	                          . '<input type="button" class="button button-secondary themeisle-feedback-click" value="' . $notification['button_done_text'] . '">'
	                          . '</p></div>';
	add_action( 'admin_notices', 'themeisle_triggered_feedback_show_admin_notice' );
}

function themeisle_triggered_feedback_show_admin_notice() {
	global $themeisle_notification;
	echo $themeisle_notification;
}

add_action( 'wp_ajax_themeisle_feedback_dismiss_nag', 'themeisle_feedback_dismiss_nag' );
function themeisle_feedback_dismiss_nag() {
	check_ajax_referer( INTERGEO_PLUGIN_NAME . INTERGEO_VERSION, 'security' );
	update_option( sanitize_text_field( $_REQUEST['slug'] ) . '-triggered-feedback-time', - 1 );
	wp_die();
}

add_filter( 'intergeo_triggered_feedback_show_notification_filter', 'intergeo_triggered_feedback_show_notification_filter' );
function intergeo_triggered_feedback_show_notification_filter( $pagenow ) {
	return ( $pagenow == 'upload.php' || $pagenow == 'options-general.php' ) && isset( $_GET['page'] ) && $_GET['page'] == INTERGEO_PLUGIN_NAME;
}

register_activation_hook( __FILE__, 'intergeo_activate' );
function intergeo_activate() {
	if ( get_option( 'intergeo-activation-date', false ) === false ) {
		update_option( 'intergeo-activation-date', time() );
	}
}

// events triggered for feedback
add_filter( 'intergeo_created_3_maps', 'intergeo_created_3_maps' );
function intergeo_created_3_maps() {
	$maps = get_posts( array(
		'post_type'      => INTERGEO_PLUGIN_NAME,
		'posts_per_page' => 4,
		'post_status'    => 'private',
	) );

	return count( $maps ) > 3;

}

add_filter( 'intergeo_plugin_1week_old', 'intergeo_plugin_1week_old' );
function intergeo_plugin_1week_old() {
	$activation_date = get_option( 'intergeo-activation-date', false );
	if ( $activation_date !== false ) {
		return ( ( time() - $activation_date ) >= 7 * 24 * 60 * 60 );
	}

	return false;
}

add_filter( 'intergeo_map_frontend_display', 'intergeo_map_frontend_display' );
function intergeo_map_frontend_display() {
	return get_option( 'intergeo-frontend-used', 0 ) > 0;
}

add_action( 'intergeo_shortcode_render_before', 'intergeo_shortcode_render_before' );
function intergeo_shortcode_render_before( $atts ) {
	// set a flag if the map has been shown on the front end
	if ( ! is_admin() && get_option( 'intergeo-frontend-used', 0 ) != 1 ) {
		update_option( 'intergeo-frontend-used', 1 );
	}
}

// Include the advanced/pro features
require dirname( __FILE__ ) . '/pro/addon.php';
add_action( 'plugins_loaded', 'intergeo_check_version' );
function intergeo_check_version() {
	$check = get_option( 'intergeo_new_users_flag', '' );
	if ( $check === '' ) {
		$query = new WP_Query( array(
			'orderby'        => 'ID',
			'order'          => 'DESC',
			'post_type'      => INTERGEO_PLUGIN_NAME,
			'posts_per_page' => 1,
		) );
		if ( $query->found_posts === 0 ) {
			update_option( 'intergeo_new_users_flag', 'yes' );
		} else {
			update_option( 'intergeo_new_users_flag', 'no' );
		}
	}
}

function intergeo_get_maps() {
	$query = new WP_Query( array(
		'orderby'        => 'ID',
		'order'          => 'DESC',
		'fields'          => 'ids',
		'no_found_rows' => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
		'post_type'      => INTERGEO_PLUGIN_NAME,
		'posts_per_page' => 11,
	) );
	return $query->post_count;
}
function intergeo_is_new() {
	$check = get_option( 'intergeo_new_users_flag', '' );
	if ( $check === 'yes' ) {
		return true;
	}
	if ( $check === 'no' ) {
		return false;
	}

	return false;
}

function intergeo_is_free() {
	return ( ! defined( 'IntergeoMapsPro_Version' ) );
}

function intergeo_is_personal() {
	if ( intergeo_is_new() ) {
		if ( ! intergeo_is_free() ) {
			return true;
		} else {
			return false;
		}
	}

	return true;
}

function intergeo_is_developer() {
	if ( intergeo_is_personal() ) {
		$plan = get_option( 'intergeo_maps_pro_license_plan', 0 );
		$plan = intval( $plan );
		if ( $plan > 0 ) {
			return true;
		}
	}
	if ( ! intergeo_is_new() ) { return true;
	}
	return false;
}

function intergeo_is_agency() {
	if ( intergeo_is_developer() ) {
		$plan = get_option( 'intergeo_maps_pro_license_plan', 0 );
		$plan = intval( $plan );
		if ( $plan > 2 ) {
			return true;
		}
	}

	return false;
}
function intergeo_check_maps_number() {
	$maps = intergeo_get_maps();
	if ( $maps < 3 ) {
		return true;
	}
	if ( $maps > 0 && $maps < 11 ) {
		return intergeo_is_personal();
	}
	return intergeo_is_developer();
}
function intergeo_check_markers( $no ) {
	$no = intval( $no );
	if ( $no < 6 ) {
		return true;
	}
	if ( $no >= 6 ) {
		return intergeo_is_personal();
	}
}
//subscribe script
add_filter( 'intergeo_themeisle_sdk_subscribe_list', 'intergeo_change_subscribe_list' );
function intergeo_change_subscribe_list() {
	return 81;
}

require dirname( __FILE__ ) . '/subscribe/subscribe.php';
$intergeo_subscribe = new THEMEISLE_SUBSCRIBE( INTERGEO_PLUGIN_NAME );
require dirname( __FILE__ ) . '/dashboard/dashboard.php';
