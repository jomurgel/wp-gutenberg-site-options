<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jomurgel.com
 * @since             1.0.0
 * @package           wp-gutenberg-site-options
 *
 * @wordpress-plugin
 * Plugin Name:       WP Gutenberg Site Options
 * Plugin URI:        https://github.com/jomurgel/wp-gutenberg-site-options
 * Description:       A starter plugin adding Gutenberg-powered options to a Core WordPress options page.
 * Version:           1.0.0
 * Author:            Jo Murgel
 * Author URI:        https://jomurgel.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-gutenberg-site-options
 * Domain Path:       /languages
 */

declare( strict_types = 1 );

namespace WP_GSO;

use WP_GSO\Admin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_GSO_DIR', plugin_dir_path(__FILE__) );
define( 'WP_GSO_BUILD_PATH', plugin_dir_url(__FILE__) );

require_once WP_GSO_DIR . '/classes/class-admin.php';

if ( class_exists( '\\WP_GSO\\Admin' ) ) {
  Admin::init();
}
