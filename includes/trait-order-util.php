<?php
/**
 * Trait Order_Util – HPOS compatibility helper.
 *
 * @package WC_Shipment_Tracker
 */

namespace WCShipmentTracker;

use Automattic\WooCommerce\Utilities\OrderUtil;

defined( 'ABSPATH' ) || exit;

trait Order_Util {

	/** @var string */
	public static $wc_order_util_class          = 'Automattic\WooCommerce\Utilities\OrderUtil';
	/** @var string */
	public static $legacy_order_admin_screen     = 'shop_order';

	protected function order_util_exists() {
		return class_exists( self::$wc_order_util_class );
	}

	protected function order_util_method_exists( $method ) {
		return $this->order_util_exists() && method_exists( self::$wc_order_util_class, $method );
	}

	public function custom_orders_table_usage_is_enabled() {
		if ( ! $this->order_util_method_exists( 'custom_orders_table_usage_is_enabled' ) ) {
			return false;
		}
		return OrderUtil::custom_orders_table_usage_is_enabled();
	}

	public function get_order_admin_screen() {
		if ( ! $this->order_util_method_exists( 'get_order_admin_screen' ) ) {
			return self::$legacy_order_admin_screen;
		}
		return OrderUtil::get_order_admin_screen();
	}

	public function init_theorder_object( $post_or_order_object ) {
		if ( ! $this->order_util_method_exists( 'init_theorder_object' ) ) {
			return wc_get_order( $post_or_order_object->ID );
		}
		return OrderUtil::init_theorder_object( $post_or_order_object );
	}
}
