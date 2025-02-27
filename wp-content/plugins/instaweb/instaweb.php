<?php

/**
 * 
 * @link              https://iqtsystems.com/
 * @since             1.0.0
 * @package           Insta Web
 * @author     		  IQ <contact@iqtsystems.com>
 * 
 * @wordpress-plugin
 * Plugin Name:       Insta Web
 * Plugin URI:        https://instapago.com
 * Description:       Plugin de pagos para Instapago
 * Version:           1.0.0
 * Author:            IQ
 * Author URI:        https://iqtsystems.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       instaweb
 * Domain Path:       /languages
 * 
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'INSTAWEB_VERSION', '1.0.0' );
define( 'INSTAWEB_CART_CHECKOUT_BLOCKS', 'cart_checkout_blocks' );
define( 'INSTAWEB_CUSTOM_ORDER_TABLES', 'custom_order_tables' );
define( 'INSTAWEB_SUPPORT_DIR', WP_PLUGIN_DIR . '/instaweb/support/' );
define( 'INSTAWEB_GATEWAY_BLOCKS_SUPPORT_FILE', INSTAWEB_SUPPORT_DIR . 'class-wc-instaweb-gateway-blocks-support.php' );

function activate_instaweb() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-instaweb-activator.php';
    Instaweb_Activator::activate();
}

function deactivate_instaweb() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-instaweb-deactivator.php';
    Instaweb_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_instaweb' );
register_deactivation_hook( __FILE__, 'deactivate_instaweb');

require plugin_dir_path( __FILE__ ) . 'includes/class-instaweb.php';

function run_instaweb() {
    $plugin = new Instaweb();
    $plugin->run();
}

run_instaweb();