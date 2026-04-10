<?php
/**
 * Email (Plain Text) – Tracking Information.
 *
 * @package WC_Shipment_Tracker
 * @version 1.0.0
 *
 * Variables available:
 *   $tracking_items array (formatted)
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $tracking_items ) || ! is_array( $tracking_items ) ) {
	return;
}

echo esc_html( apply_filters( 'wcst_email_tracking_title', __( 'TRACKING INFORMATION', 'wc-shipment-tracker' ) ) );
echo "\n\n";

foreach ( $tracking_items as $item ) {
	echo esc_html( $item['formatted_tracking_provider'] ) . "\n";
	echo esc_html( $item['tracking_number'] ) . "\n";
	if ( $item['formatted_tracking_link'] ) {
		echo esc_url( $item['formatted_tracking_link'] ) . "\n";
	}
	echo "\n";
}

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
