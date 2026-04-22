<?php
/**
 * WCST_Plugin – main orchestrator.
 *
 * @package WC_Shipment_Tracker
 */

defined( 'ABSPATH' ) || exit;

class WCST_Plugin {

	/** @var self */
	private static $instance;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$actions = WCST_Actions::get_instance();

		// ---- Admin styles & scripts ----------------------------------------
		add_action( 'admin_print_styles', array( $actions, 'admin_styles' ) );

		// ---- Frontend styles & scripts ------------------------------------
		add_action( 'wp_enqueue_scripts', array( $actions, 'frontend_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $actions, 'frontend_scripts' ) );

		// ---- Shortcode -----------------------------------------------------
		add_shortcode( 'wcst_tracking', array( $actions, 'shortcode_tracking' ) );

		// ---- Meta box -------------------------------------------------------
		add_action( 'add_meta_boxes',                    array( $actions, 'add_meta_box' ) );
		add_action( 'woocommerce_process_shop_order_meta', array( $actions, 'save_meta_box' ), 0 );

		// ---- Frontend: My Account view-order page ---------------------------
		add_action( 'woocommerce_view_order', array( $actions, 'display_tracking_info' ) );

		// ---- Emails ---------------------------------------------------------
		add_action( 'woocommerce_email_before_order_table', array( $actions, 'email_display' ), 0, 4 );

		// ---- Orders list columns (legacy CPT) --------------------------------
		add_filter( 'manage_shop_order_posts_columns',        array( $actions, 'add_orders_list_column' ), 99 );
		add_action( 'manage_shop_order_posts_custom_column',  array( $actions, 'render_orders_list_column_legacy' ), 10, 2 );

		// ---- Orders list columns (HPOS) -------------------------------------
		add_filter( 'manage_woocommerce_page_wc-orders_columns',       array( $actions, 'add_orders_list_column' ), 99 );
		add_action( 'manage_woocommerce_page_wc-orders_custom_column', array( $actions, 'render_orders_list_column_hpos' ), 10, 2 );

		// ---- AJAX handlers --------------------------------------------------
		add_action( 'wp_ajax_wcst_save_tracking',   array( $actions, 'ajax_save_tracking' ) );
		add_action( 'wp_ajax_wcst_update_tracking', array( $actions, 'ajax_update_tracking' ) );
		add_action( 'wp_ajax_wcst_delete_tracking', array( $actions, 'ajax_delete_tracking' ) );
		add_action( 'wp_ajax_wcst_get_items',       array( $actions, 'ajax_get_items' ) );

		// ---- Subscriptions: prevent copying tracking to renewals ------------
		$subs_version = $this->get_subscriptions_version();
		if ( null !== $subs_version && version_compare( $subs_version, '2.5.0', '>=' ) ) {
			add_filter( 'wc_subscriptions_renewal_order_data', array( $actions, 'prevent_copying_tracking_data' ) );
		} elseif ( null !== $subs_version ) {
			add_filter( 'wcs_renewal_order_meta_query',              array( $actions, 'exclude_tracking_from_renewal_query' ) );
			add_filter( 'woocommerce_subscriptions_renewal_order_meta_query', array( $actions, 'exclude_tracking_from_renewal_query' ) );
		}

		// ---- REST API -------------------------------------------------------
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );

		// ---- Textdomain -----------------------------------------------------
		add_action( 'after_setup_theme', array( $this, 'load_textdomain' ) );
	}

	public function load_textdomain() {
		load_plugin_textdomain( 'trackora', false, basename( WCST_DIR ) . '/languages/' );
	}

	public function register_rest_routes() {
		require_once WCST_DIR . '/includes/class-wcst-api.php';

		// Native namespace.
		$api = new WCST_API();
		$api->register_routes();

		// Backward-compat namespaces so third-party code using wc/v2 still works.
		foreach ( array( 'wc/v1', 'wc/v2' ) as $ns ) {
			$compat = new WCST_API();
			$compat->set_namespace( $ns );
			$compat->register_routes();
		}
	}

	private function get_subscriptions_version() {
		if ( class_exists( 'WC_Subscriptions_Core_Plugin' ) ) {
			return WC_Subscriptions_Core_Plugin::instance()->get_plugin_version();
		}
		if ( class_exists( 'WC_Subscriptions' ) ) {
			return WC_Subscriptions::$version;
		}
		return null;
	}
}
