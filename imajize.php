<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.imajize.com
 * @since             1.0.0
 * @package           Imajize
 *
 * @wordpress-plugin
 * Plugin Name:       Imajize
 * Plugin URI:        www.imajize.com
 * Description:       Imajize is a maintenance-free publishing platform for spinning your products.
 * Version:           1.0.1
 * Author:            Jasper Michalczik
 * Author URI:        www.imajize.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       imajize
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-imajize-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-imajize-activator.php';
	Imajize_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-imajize-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-imajize-deactivator.php';
	Imajize_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-imajize.php';


/**
 * Add imajize oembed support
 */

// Register oEmbed providers
function imajize_oembed_provider() {
	wp_oembed_add_provider( '#https?://embed.imajize.com/.*#i', 'http://app.imajize.com/api/oembed.json', true );
}

// Hook into the 'init' action
add_action( 'init', 'imajize_oembed_provider' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Imajize();
	$plugin->run();

}
run_plugin_name();
