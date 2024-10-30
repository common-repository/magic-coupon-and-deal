<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.ifourtechnolab.com/
 * @since             1.0.0
 * @package           Magic_Coupon_And_Deal
 *
 * @wordpress-plugin
 * Plugin Name:       Magic Coupon And Deal
 * Plugin URI:        https://wordpress.org/plugins/magic-coupon-and-deal
 * Description:       A WP plugin that convert your wordpress blog to coupon website.
 * Version:           1.0.0
 * Author:            ifourtechnolab
 * Author URI:        http://www.ifourtechnolab.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       magic-coupon-and-deal
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined( 'WPINC' )) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-magic-coupon-and-deal-activator.php
 */
function activate_magic_coupon_and_deal()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-magic-coupon-and-deal-activator.php';
    Magic_Coupon_And_Deal_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-magic-coupon-and-deal-deactivator.php
 */
function deactivate_magic_coupon_and_deal()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-magic-coupon-and-deal-deactivator.php';
    Magic_Coupon_And_Deal_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_magic_coupon_and_deal' );
register_deactivation_hook( __FILE__, 'deactivate_magic_coupon_and_deal' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-magic-coupon-and-deal.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_magic_coupon_and_deal()
{

    $plugin = new Magic_Coupon_And_Deal();
    $plugin->run();
}
run_magic_coupon_and_deal();
