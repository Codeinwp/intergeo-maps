<?php
if ( ! class_exists( 'IntergeoMaps_Adv' ) ) {
	class IntergeoMaps_Adv {

		function __construct() {
			$this->loadHooks();
		}

		private function loadHooks() {
			add_action( 'wp_ajax_export_data_pro', array( $this, 'ajax' ) );
		}

		public static function writeDebug( $msg ) {
			if ( INTERGEO_DEBUG ) {
				file_put_contents( INTERGEO_DIR . 'tmp/log.log', date( 'F j, Y H:i:s' ) . ' - ' . $msg . "\n", FILE_APPEND );
			}
		}

		public function addForm( $type, $json ) {
			include_once INTERGEO_DIR . "pro/templates/iframe/{$type}.php";
		}

		public function addValidations( &$validationArray, &$defaults ) {
			$validationArray['custom_url']      = FILTER_VALIDATE_URL;
			$validationArray['custom_latne']    = array(
				'filter'  => FILTER_VALIDATE_FLOAT,
				'flags'   => FILTER_REQUIRE_SCALAR,
				'options' => array(
					'min_range' => - 90,
					'max_range' => 90,
					'default'   => 48.1366069,
				),
			);
			$validationArray['custom_lonne']    = array(
				'filter'  => FILTER_VALIDATE_FLOAT,
				'flags'   => FILTER_REQUIRE_SCALAR,
				'options' => array(
					'min_range' => - 180,
					'max_range' => 180,
					'default'   => 11.577085099999977,
				),
			);
			$validationArray['custom_latsw']    = array(
				'filter'  => FILTER_VALIDATE_FLOAT,
				'flags'   => FILTER_REQUIRE_SCALAR,
				'options' => array(
					'min_range' => - 90,
					'max_range' => 90,
					'default'   => 48.1366069,
				),
			);
			$validationArray['custom_lonsw']    = array(
				'filter'  => FILTER_VALIDATE_FLOAT,
				'flags'   => FILTER_REQUIRE_SCALAR,
				'options' => array(
					'min_range' => - 180,
					'max_range' => 180,
					'default'   => 11.577085099999977,
				),
			);
			$validationArray['layer_custom']    = FILTER_VALIDATE_BOOLEAN;
			$validationArray['layer_importcsv'] = FILTER_VALIDATE_BOOLEAN;
			$validationArray['import_csv']      = null;
			$validationArray['csvfileorig']     = null;
			$defaults['custom_url']      = null;
			$defaults['custom_latne']    = null;
			$defaults['custom_lonne']    = null;
			$defaults['custom_latsw']    = null;
			$defaults['custom_lonsw']    = null;
			$defaults['layer_custom']    = false;
			$defaults['layer_importcsv'] = false;
			$defaults['import_csv']      = null;
			$defaults['csvfileorig']     = null;

		}

		public function enqueueScriptsAndStyles( $deps, $data = null ) {
			wp_enqueue_script( 'intergeo-maps-pro', INTERGEO_ABSURL . 'pro/js/pro.js', $deps, INTERGEO_VERSION, true );
			wp_enqueue_script( 'google-maps-utils', INTERGEO_ABSURL . 'pro/js/gmap-util.js', null, INTERGEO_VERSION, true );
			wp_localize_script( 'intergeo-maps-pro', 'igmp', array(
				'custom'   => $data,
				'ajax'     => array(
					'export' => 'export_data_pro',
					'nonce'  => wp_create_nonce( INTERGEO_PLUGIN_NAME . INTERGEO_VERSION ),
				),
				'messages' => array(
					'save_map' => __( 'Please save the map before clicking on the export button', 'intergeo-maps' ),
				),
			) );
		}

		function ajax() {
			check_ajax_referer( INTERGEO_PLUGIN_NAME . INTERGEO_VERSION, 'security' );
			switch ( $_POST['action'] ) {
				case 'export_data_pro':
					$this->exportData();
					break;
			}
			wp_die();
		}

		private function exportData() {
			$map_id = $_POST['id'];
			if ( $map_id ) {
				$map = get_post( intergeo_decode( $map_id ) );
				if ( $map->post_type == INTERGEO_PLUGIN_NAME ) {
					$rows = array();
					$json = json_decode( $map->post_content, true );
					if ( is_array( $json ) ) {
						// drawn markers
						if ( isset( $json['overlays'] ) && isset( $json['overlays']['marker'] ) ) {
							foreach ( $json['overlays']['marker'] as $marker ) {
								$rows[] = array(
									$marker['position'][0],
									$marker['position'][1],
									$marker['info'],
									empty( $marker['icon'] ) ? 'http://maps.google.com/mapfiles/ms/icons/red-dot.png' : $marker['icon'],
									$marker['title'],
								);
							}
						}
						// imported markers - only if it is enabled
						if ( isset( $json['layer'] ) && isset( $json['layer']['importcsv'] ) && $json['layer']['importcsv'] && isset( $json['xml'] ) && is_string( $json['xml'] ) ) {
							$array     = explode( '/', $json['xml'] );
							$filename  = $array[ count( $array ) - 1 ];
							$dir       = wp_upload_dir();
							$parentdir = trailingslashit( $dir['basedir'] ) . trailingslashit( INTERGEO_PLUGIN_NAME );
							$file      = $parentdir . $filename;
							if ( file_exists( $file ) ) {
								$xml = simplexml_load_file( $file );
								if ( $xml ) {
									foreach ( $xml->marker as $marker ) {
										$atts   = $marker->attributes();
										$rows[] = array(
											$atts['lat'],
											$atts['lng'],
											$atts['name'],
											$atts['icon'],
											'',
										);
									}
								}
							}
						}
					}
					if ( ! empty( $rows ) ) {
						$fp = tmpfile();
						foreach ( $rows as $row ) {
							fputcsv( $fp, $row );
						}
						rewind( $fp );
						$csv = '';
						while ( ( $array = fgetcsv( $fp ) ) !== false ) {
							if ( strlen( $csv ) > 0 ) {
								$csv .= PHP_EOL;
							}
							$csv .= '"' . implode( '","', $array ) . '"';
						}
						fclose( $fp );
						wp_send_json_success( array(
							'csv'  => $csv,
							'name' => $map_id . '.csv',
						) );
					}
				}
			}

		}

		public function processResults( &$results ) {
			if ( $_FILES ) {
				$filename = $_FILES['import_csv']['tmp_name'];
				$csv      = array_map( 'str_getcsv', file( $filename ) );
				$xml      = "<?xml version='1.0' encoding='UTF-8'?><markers>";
				foreach ( $csv as $line ) {
					$xml .= '<marker lat="' . htmlspecialchars( $line[0] ) . '" lng="' . htmlspecialchars( $line[1] ) . '" name="' . htmlspecialchars( $line[2] ) . '" icon="' . htmlspecialchars( $line[3] ) . '"/>';
				}
				$xml .= '</markers>';
				$dir       = wp_upload_dir();
				$filename  = microtime( true ) . '.xml';
				$parentdir = trailingslashit( $dir['basedir'] ) . trailingslashit( INTERGEO_PLUGIN_NAME );
				try {
					if ( ! file_exists( $parentdir ) ) {
						mkdir( $parentdir );
					}
				} catch ( ErrorException $ex ) {
					//TODO report error
				}
				$file = $parentdir . $filename;
				file_put_contents( $file, $xml );
				$results['xml'] = trailingslashit( $dir['baseurl'] ) . trailingslashit( INTERGEO_PLUGIN_NAME ) . $filename;
			} else {
				$results['xml'] = $results['csvfileorig'];
				unset( $results['csvfileorig'] );
			}
		}

		public function addUploadElements( $json ) {
			include_once INTERGEO_DIR . 'pro/templates/iframe/upload.php';
		}

	}
}
if ( class_exists( 'IntergeoMaps_Adv' ) ) {
	$IntergeoMaps_Adv = new IntergeoMaps_Adv();
}
