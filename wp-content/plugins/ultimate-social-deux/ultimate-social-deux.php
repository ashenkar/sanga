<?php
/**
 * @package   	Ultimate Social Deux
 * @author    	Ultimate WP <hello@ultimate-wp.com>
 * @link      	http://social.ultimate-wp.com
 * @copyright 	2015 Ultimate WP
 *
 * @wordpress-plugin
 * Plugin Name:       Ultimate Social Deux
 * Plugin URI:        http://social.ultimate-wp.com
 * Description:       Ultimate Social Deux is a plugin that gives you more than 20 popular custom styled social media sharing buttons with counters.
 * Version:           5.0.3
 * Author:            Ultimate WP
 * Author URI:        http://ultimate-wp.com
 * Text Domain:       ultimate-social-deux
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('ULTIMATE_SOCIAL_DEUX_VERSION', '5.0.3');

require_once( plugin_dir_path( __FILE__ ) . 'public/class-ultimate-social-deux-public.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-ultimate-social-deux-buttons.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-ultimate-social-deux-shortcodes.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-ultimate-social-deux-placement.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-ultimate-social-deux-widget.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-ultimate-social-deux-visual-composer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-ultimate-social-deux-fan-count.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-ultimate-social-deux-ajax.php' );

register_activation_hook( __FILE__, array( 'UltimateSocialDeux', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'UltimateSocialDeux', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'UltimateSocialDeux', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'UltimateSocialDeuxButtons', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'UltimateSocialDeuxShortcodes', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'UltimateSocialDeuxPlacement', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'UltimateSocialDeuxFanCount', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'UltimateSocialDeuxAjax', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-ultimate-social-deux-admin.php' );
	add_action( 'plugins_loaded', array( 'UltimateSocialDeuxAdmin', 'get_instance' ) );

	if( ! class_exists( 'UltimateUpdater' ) ) {
       require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/class.ultimate-updater.php' );
    }

    if ( UltimateSocialDeux::opt('us_license', '') ) {
        $updater = new UltimateUpdater(
            'http://api.ultimate-wp.com/update-check',
            __FILE__,
            array(
                'item'    => 'Ultimate Social Deux',
                'version' => ULTIMATE_SOCIAL_DEUX_VERSION,
                'unique'  => 'WoqUdWkA64w3Iy3A',
                'license' => trim( UltimateSocialDeux::opt('us_license', '') ),
            )
        );
    }

}
require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/titan-framework/titan-framework-embedder.php' );