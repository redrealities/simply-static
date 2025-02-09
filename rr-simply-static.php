<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Name:       RR Simply Static
 * Plugin URI:        https://redrealities.com
 * Description:       A static site generator customised by Red Realities
 * Version:           2.1.5.8
 * Author:            Patrick Posner & Alex Chernov
 * Author URI:        https://alexchernov.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simply-static
 * Domain Path:       /languages
 */

define( 'SIMPLY_STATIC_PATH', plugin_dir_path( __FILE__ ) );
define( 'SIMPLY_STATIC_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

// Check PHP version.
if ( version_compare( PHP_VERSION, '7.2.5', '<' ) ) {
	deactivate_plugins( plugin_basename( __FILE__ ) );
	wp_die( esc_html__( 'Simply Static requires PHP 7.2.5 or higher.', 'simply-static' ), 'Plugin dependency check', array( 'back_link' => true ) );
}

// localize.
$textdomain_dir = plugin_basename( dirname( __FILE__ ) ) . '/languages';
load_plugin_textdomain( 'simply-static', false, $textdomain_dir );

// run autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) && ! class_exists( 'Simply_Static\Plugin' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

// boot Simply Static.
if ( ! function_exists( 'simply_static_run_plugin' ) ) {
	add_action( 'plugins_loaded', 'simply_static_run_plugin' );

	/**
	 * Run plugin
	 *
	 * @return void
	 */
	function simply_static_run_plugin() {
		require_once SIMPLY_STATIC_PATH . 'src/class-ss-plugin.php';

		Simply_Static\Plugin::instance();
	}
}
