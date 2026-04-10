<?php
/**
 * Plugin Name: WC Shipment Tracker
 * Plugin URI:  https://wordpress.org/plugins/wc-shipment-tracker/
 * Description: Add tracking numbers to WooCommerce orders. Supports multiple shipping providers and custom tracking links. Tracking information appears in emails, the order view page and the customer account section.
 * Version:     1.1.0
 * Author:      slbarriosdev
 * Text Domain: wc-shipment-tracker
 * Domain Path: /languages
 * Requires Plugins: woocommerce
 * Requires PHP: 7.4
 * Requires at least: 6.4
 * WC requires at least: 8.0
 * WC tested up to: 9.5
 * License:        GPLv2 or later
 * License URI:    https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package WC_Shipment_Tracker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WCST_VERSION', '1.1.0' );
define( 'WCST_FILE',    __FILE__ );
define( 'WCST_DIR',     __DIR__ );
define( 'WCST_URL',     untrailingslashit( plugin_dir_url( __FILE__ ) ) );

// ---------------------------------------------------------------------------
// Declare HPOS + Blocks compatibility as early as possible.
// ---------------------------------------------------------------------------
add_action( 'before_woocommerce_init', 'wcst_declare_compat' );
function wcst_declare_compat() {
	if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables',  WCST_FILE, true );
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', WCST_FILE, true );
	}
}

// ---------------------------------------------------------------------------
// Bootstrap after WooCommerce is loaded.
// ---------------------------------------------------------------------------
add_action( 'plugins_loaded', 'wcst_init' );
function wcst_init() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'wcst_missing_wc_notice' );
		return;
	}

	require_once WCST_DIR . '/includes/trait-order-util.php';
	require_once WCST_DIR . '/includes/class-wcst-actions.php';
	require_once WCST_DIR . '/includes/class-wcst-plugin.php';

	WCST_Plugin::get_instance();
}

function wcst_missing_wc_notice() {
	echo '<div class="error"><p><strong>' .
		esc_html__( 'WC Shipment Tracker requires WooCommerce to be installed and active.', 'wc-shipment-tracker' ) .
		'</strong></p></div>';
}

// ---------------------------------------------------------------------------
// Public helper functions (can be called from themes / other plugins).
// ---------------------------------------------------------------------------

/**
 * Add a tracking number to an order.
 *
 * @param int         $order_id
 * @param string      $tracking_number
 * @param string      $provider         Provider name (predefined or custom).
 * @param int|null    $date_shipped     Unix timestamp. Defaults to now.
 * @param string|bool $custom_url       Custom tracking URL (only for custom providers).
 */
function wcst_add_tracking( $order_id, $tracking_number, $provider, $date_shipped = null, $custom_url = false ) {
	if ( ! $date_shipped ) {
		$date_shipped = time();
	}

	$actions       = WCST_Actions::get_instance();
	$custom        = true;
	$provider_slug = sanitize_title( str_replace( ' ', '', $provider ) );

	foreach ( $actions->get_providers() as $providers ) {
		foreach ( $providers as $p_name => $p_url ) {
			if ( sanitize_title( str_replace( ' ', '', $p_name ) ) === $provider_slug ) {
				$provider = sanitize_title( $p_name );
				$custom   = false;
				break 2;
			}
		}
	}

	$args = $custom
		? array(
			'tracking_provider'        => '',
			'custom_tracking_provider' => $provider,
			'custom_tracking_link'     => $custom_url ? $custom_url : '',
			'tracking_number'          => $tracking_number,
			'date_shipped'             => gmdate( 'Y-m-d', $date_shipped ),
		)
		: array(
			'tracking_provider'        => $provider,
			'custom_tracking_provider' => '',
			'custom_tracking_link'     => '',
			'tracking_number'          => $tracking_number,
			'date_shipped'             => gmdate( 'Y-m-d', $date_shipped ),
		);

	$actions->add_tracking_item( $order_id, $args );
}

/**
 * Delete a tracking number from an order.
 *
 * @param int    $order_id
 * @param string $tracking_number
 * @param string $provider  Optional – filter by provider.
 * @return bool
 */
function wcst_delete_tracking( $order_id, $tracking_number, $provider = '' ) {
	$actions = WCST_Actions::get_instance();

	foreach ( $actions->get_tracking_items( $order_id ) as $item ) {
		if ( $item['tracking_number'] !== $tracking_number ) {
			continue;
		}
		if ( $provider ) {
			$slug = sanitize_title( $provider );
			if ( $slug !== $item['tracking_provider'] && $slug !== $item['custom_tracking_provider'] ) {
				continue;
			}
		}
		$actions->delete_tracking_item( $order_id, $item['tracking_id'] );
		return true;
	}
	return false;
}
