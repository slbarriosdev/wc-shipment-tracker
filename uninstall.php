<?php
/**
 * Uninstall Trackora.
 *
 * Tracking data is stored as WooCommerce order meta and belongs to the orders,
 * so it is intentionally preserved on uninstall.
 *
 * @package WC_Shipment_Tracker
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
