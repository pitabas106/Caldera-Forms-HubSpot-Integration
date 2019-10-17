<?php
/**
 * Plugin Name: Caldera Forms HubSpot Integration
 * Plugin URI:  https://zetamatic.com
 * Description: The integration of Caldera Forms and HubSpot plugin lets you add a new HubSpot Processor to Caldera form. It automatically syncs data from your Caldera form to your HubSpot CRM when the form is submitted.
 * Version:     0.0.1
 * Author:      ZetaMatic
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cf-hubspot-integration
 * Domain Path: /languages/
 *
 * @package cf-hubspot-integration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'CFHI_PLUGIN_FILE' ) ) {
	define( 'CFHI_PLUGIN_FILE', __FILE__ );
}


// Define plugin version
define( 'CFHI_VERSION', '0.0.1' );


if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {
	add_action( 'admin_notices', 'cfhi_fail_php_version' );
} else {
	// Include the CFHI class.
	require_once dirname( __FILE__ ) . '/inc/class-cf-hubspot-integration.php';
}


/**
 * Admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 0.0.1
 *
 * @return void
 */
function cfhi_fail_php_version() {

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}

	/* translators: %s: PHP version */
	$message      = sprintf( esc_html__( 'HubSpot Integration for Caldera Forms requires PHP version %s+, plugin is currently NOT RUNNING.', 'cf-hubspot-integration' ), '5.6' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}
