<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link              http://woocommerce.db-dzine.de
 * @since             1.0.0
 * @package           WooCommerce_Store_Locator
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Store Locator
 * Plugin URI:        http://woocommerce.db-dzine.de
 * Description:       Add a Store Locator to your WooCommerce Shop!
 * Version:           1.0.0.2
 * Author:            DB-Dzine
 * Author URI:        http://www.db-dzine.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-store-locator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-store-locator-activator.php
 */
function activate_WooCommerce_Store_Locator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-store-locator-activator.php';
	WooCommerce_Store_Locator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-store-locator-deactivator.php
 */
function deactivate_WooCommerce_Store_Locator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-store-locator-deactivator.php';
	WooCommerce_Store_Locator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_WooCommerce_Store_Locator' );
register_deactivation_hook( __FILE__, 'deactivate_WooCommerce_Store_Locator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-store-locator.php';

/**
 * Run the Plugin
 * @author Daniel Barenkamp
 * @version 1.0.0
 * @since   1.0.0
 * @link    http://woocommerce.db-dzine.de
 */
function run_WooCommerce_Store_Locator() {

	$plugin = new WooCommerce_Store_Locator();
	$plugin->run();

}

run_WooCommerce_Store_Locator();