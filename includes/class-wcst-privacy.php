<?php
/**
 * WCST_Privacy – personal data exporter and eraser for shipment tracking.
 *
 * Registers a WordPress privacy exporter and eraser so that a store can answer
 * GDPR/CCPA data requests for the tracking numbers attached to a customer's
 * orders. Loaded from WCST_Plugin only once WooCommerce is initialised.
 *
 * @package WC_Shipment_Tracker
 */

defined( 'ABSPATH' ) || exit;

class WCST_Privacy extends WC_Abstract_Privacy {

	/** Orders processed per exporter/eraser page. */
	const PER_PAGE = 10;

	const META_KEY = '_wc_shipment_tracking_items';

	public function __construct() {
		parent::__construct( __( 'Trackora', 'trackora' ) );

		$this->add_exporter(
			'trackora-order-tracking',
			__( 'Trackora Shipment Tracking Data', 'trackora' ),
			array( $this, 'order_tracking_data_exporter' )
		);

		$this->add_eraser(
			'trackora-order-tracking',
			__( 'Trackora Shipment Tracking Data', 'trackora' ),
			array( $this, 'order_tracking_data_eraser' )
		);
	}

	/**
	 * Text shown in the wp-admin privacy policy guide.
	 *
	 * @return string
	 */
	public function get_privacy_message() {
		return wpautop(
			sprintf(
				/* translators: %s = plugin name */
				esc_html__( '%s stores a shipment tracking number, the carrier name and the shipping date against each order. This information is shown to the customer in order emails, in the My Account area and on any public tracking page, and is exported or erased together with the order it belongs to. No tracking data is sent to any third party by the plugin; tracking links are only opened when a customer or a store administrator clicks them.', 'trackora' ),
				'<strong>' . esc_html__( 'Trackora', 'trackora' ) . '</strong>'
			)
		);
	}

	/**
	 * Orders belonging to an email address (and, if it maps to a user, that user).
	 *
	 * @param string $email_address
	 * @param int    $page 1-based.
	 * @return WC_Order[]
	 */
	protected function get_orders( $email_address, $page ) {
		$user = get_user_by( 'email', $email_address );

		// 'customer' matches any of the given emails or user IDs, so a guest order
		// placed with the same email is included alongside the account's orders.
		$customer = array( $email_address );
		if ( $user instanceof WP_User ) {
			$customer[] = (int) $user->ID;
		}

		$orders = wc_get_orders(
			array(
				'limit'    => self::PER_PAGE,
				'page'     => (int) $page,
				'customer' => $customer,
				'return'   => 'objects',
			)
		);

		return is_array( $orders ) ? $orders : array();
	}

	/**
	 * Export tracking items for every order tied to the email address.
	 *
	 * @param string $email_address
	 * @param int    $page
	 * @return array
	 */
	public function order_tracking_data_exporter( $email_address, $page = 1 ) {
		$page   = max( 1, (int) $page );
		$orders = $this->get_orders( $email_address, $page );
		$export = array();

		foreach ( $orders as $order ) {
			$items = $order->get_meta( self::META_KEY );

			if ( ! is_array( $items ) || empty( $items ) ) {
				continue;
			}

			foreach ( $items as $item ) {
				$provider = ! empty( $item['custom_tracking_provider'] )
					? $item['custom_tracking_provider']
					: ( isset( $item['tracking_provider'] ) ? $item['tracking_provider'] : '' );

				$date_shipped = ! empty( $item['date_shipped'] ) && is_numeric( $item['date_shipped'] )
					? gmdate( 'Y-m-d', (int) $item['date_shipped'] )
					: '';

				$export[] = array(
					'group_id'    => 'trackora_order_tracking',
					'group_label' => __( 'Shipment Tracking', 'trackora' ),
					'item_id'     => 'order-' . $order->get_id() . '-tracking-' . ( isset( $item['tracking_id'] ) ? $item['tracking_id'] : '' ),
					'data'        => array(
						array(
							'name'  => __( 'Order Number', 'trackora' ),
							'value' => $order->get_order_number(),
						),
						array(
							'name'  => __( 'Tracking Provider', 'trackora' ),
							'value' => $provider,
						),
						array(
							'name'  => __( 'Tracking Number', 'trackora' ),
							'value' => isset( $item['tracking_number'] ) ? $item['tracking_number'] : '',
						),
						array(
							'name'  => __( 'Date Shipped', 'trackora' ),
							'value' => $date_shipped,
						),
					),
				);
			}
		}

		return array(
			'data' => $export,
			'done' => count( $orders ) < self::PER_PAGE,
		);
	}

	/**
	 * Erase tracking items from every order tied to the email address.
	 *
	 * @param string $email_address
	 * @param int    $page
	 * @return array
	 */
	public function order_tracking_data_eraser( $email_address, $page = 1 ) {
		$page          = max( 1, (int) $page );
		$orders        = $this->get_orders( $email_address, $page );
		$items_removed = false;
		$messages      = array();

		foreach ( $orders as $order ) {
			$items = $order->get_meta( self::META_KEY );

			if ( ! is_array( $items ) || empty( $items ) ) {
				continue;
			}

			// Order CRUD, not delete_post_meta(): the order may live in the HPOS tables.
			$order->delete_meta_data( self::META_KEY );
			$order->save();

			$items_removed = true;
			/* translators: %s = order number */
			$messages[] = sprintf( __( 'Removed shipment tracking data from order %s.', 'trackora' ), $order->get_order_number() );
		}

		return array(
			'items_removed'  => $items_removed,
			'items_retained' => false,
			'messages'       => $messages,
			'done'           => count( $orders ) < self::PER_PAGE,
		);
	}
}
