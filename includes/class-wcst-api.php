<?php
/**
 * WCST_API – REST API controller for order tracking items.
 *
 * Routes (default namespace: wc-shipment-tracker/v1):
 *   GET  /orders/{order_id}/trackings
 *   POST /orders/{order_id}/trackings
 *   GET  /orders/{order_id}/trackings/{id}
 *   DELETE /orders/{order_id}/trackings/{id}
 *   GET  /providers   (public, no auth required)
 *
 * @package WC_Shipment_Tracker
 */

defined( 'ABSPATH' ) || exit;

class WCST_API extends WC_REST_Controller {

	/** @var string */
	protected $namespace = 'wc-shipment-tracker/v1';

	/** @var string */
	protected $rest_base = 'orders/(?P<order_id>[\d]+)/trackings';

	/** @var string */
	protected $post_type = 'shop_order';

	public function set_namespace( $namespace ) {
		$this->namespace = $namespace;
		return $this;
	}

	public function register_routes() {
		// --- Collection: list + create --------------------------------------
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_item' ),
					'permission_callback' => array( $this, 'create_item_permissions_check' ),
					'args'                => array_merge(
						$this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
						array(
							'tracking_number' => array( 'required' => true ),
						)
					),
				),
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);

		// --- Single item: read + delete -------------------------------------
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base . '/(?P<id>[a-fA-F0-9]{0,32})',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'get_item_permissions_check' ),
					'args'                => array(
						'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					),
				),
				array(
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'delete_item' ),
					'permission_callback' => array( $this, 'delete_item_permissions_check' ),
				),
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);

		// --- Providers list (public) ----------------------------------------
		register_rest_route(
			$this->namespace,
			'/providers',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_providers' ),
					'permission_callback' => '__return_true',
				),
			)
		);
	}

	// -------------------------------------------------------------------------
	// Permission callbacks
	// -------------------------------------------------------------------------

	public function get_items_permissions_check( $request ) {
		if ( ! wc_rest_check_post_permissions( $this->post_type, 'read', (int) $request['order_id'] ) ) {
			return new WP_Error( 'wcst_rest_cannot_view', __( 'Sorry, you cannot list resources.', 'trackora' ), array( 'status' => rest_authorization_required_code() ) );
		}
		return true;
	}

	public function create_item_permissions_check( $request ) {
		if ( ! wc_rest_check_post_permissions( $this->post_type, 'create', (int) $request['order_id'] ) ) {
			return new WP_Error( 'wcst_rest_cannot_create', __( 'Sorry, you are not allowed to create resources.', 'trackora' ), array( 'status' => rest_authorization_required_code() ) );
		}
		return true;
	}

	public function get_item_permissions_check( $request ) {
		if ( ! wc_rest_check_post_permissions( $this->post_type, 'read', (int) $request['order_id'] ) ) {
			return new WP_Error( 'wcst_rest_cannot_view', __( 'Sorry, you cannot view this resource.', 'trackora' ), array( 'status' => rest_authorization_required_code() ) );
		}
		return true;
	}

	public function delete_item_permissions_check( $request ) {
		if ( ! wc_rest_check_post_permissions( $this->post_type, 'delete', (int) $request['order_id'] ) ) {
			return new WP_Error( 'wcst_rest_cannot_delete', __( 'Sorry, you are not allowed to delete this resource.', 'trackora' ), array( 'status' => rest_authorization_required_code() ) );
		}
		return true;
	}

	// -------------------------------------------------------------------------
	// Endpoints
	// -------------------------------------------------------------------------

	public function get_items( $request ) {
		$order_id = (int) $request['order_id'];
		if ( ! wc_get_order( $order_id ) ) {
			return new WP_Error( 'wcst_rest_invalid_order', __( 'Invalid order ID.', 'trackora' ), array( 'status' => 404 ) );
		}

		$actions = WCST_Actions::get_instance();
		$items   = $actions->get_tracking_items( $order_id, true );
		$data    = array();

		foreach ( $items as $item ) {
			$item['order_id'] = $order_id;
			$response         = $this->prepare_item_for_response( $item, $request );
			$data[]           = $this->prepare_response_for_collection( $response );
		}

		return rest_ensure_response( $data );
	}

	public function get_item( $request ) {
		$order_id    = (int) $request['order_id'];
		$tracking_id = $request['id'];

		if ( ! wc_get_order( $order_id ) ) {
			return new WP_Error( 'wcst_rest_invalid_order', __( 'Invalid order ID.', 'trackora' ), array( 'status' => 404 ) );
		}

		$actions = WCST_Actions::get_instance();
		$item    = $actions->get_tracking_item( $order_id, $tracking_id, true );

		if ( ! $item ) {
			return new WP_Error( 'wcst_rest_invalid_tracking', __( 'Invalid tracking ID.', 'trackora' ), array( 'status' => 404 ) );
		}

		$item['order_id'] = $order_id;
		return rest_ensure_response( $this->prepare_item_for_response( $item, $request ) );
	}

	public function create_item( $request ) {
		if ( ! empty( $request['tracking_id'] ) ) {
			return new WP_Error( 'wcst_rest_exists', __( 'Cannot create existing tracking item.', 'trackora' ), array( 'status' => 400 ) );
		}

		$order_id = (int) $request['order_id'];
		if ( ! wc_get_order( $order_id ) ) {
			return new WP_Error( 'wcst_rest_invalid_order', __( 'Invalid order ID.', 'trackora' ), array( 'status' => 404 ) );
		}

		$actions = WCST_Actions::get_instance();
		$item    = $actions->add_tracking_item(
			$order_id,
			array(
				'tracking_provider'        => wc_clean( sanitize_title( $request['tracking_provider'] ) ),
				'custom_tracking_provider' => wc_clean( $request['custom_tracking_provider'] ),
				'custom_tracking_link'     => wc_clean( $request['custom_tracking_link'] ),
				'tracking_number'          => wc_clean( $request['tracking_number'] ),
				'date_shipped'             => wc_clean( $request['date_shipped'] ),
			)
		);

		$item     = array_merge( $item, $actions->get_formatted_tracking_item( $order_id, $item ) );
		$item['order_id'] = $order_id;

		$request->set_param( 'context', 'edit' );
		$response = rest_ensure_response( $this->prepare_item_for_response( $item, $request ) );
		$response->set_status( 201 );
		$response->header( 'Location', rest_url( sprintf(
			'/%s/orders/%d/trackings/%s',
			$this->namespace,
			$order_id,
			$item['tracking_id']
		) ) );

		return $response;
	}

	public function delete_item( $request ) {
		$order_id    = (int) $request['order_id'];
		$tracking_id = $request['id'];

		if ( ! wc_get_order( $order_id ) ) {
			return new WP_Error( 'wcst_rest_invalid_order', __( 'Invalid order ID.', 'trackora' ), array( 'status' => 404 ) );
		}

		$actions = WCST_Actions::get_instance();
		$item    = $actions->get_tracking_item( $order_id, $tracking_id, true );

		if ( ! $item ) {
			return new WP_Error( 'wcst_rest_invalid_tracking', __( 'Invalid tracking ID.', 'trackora' ), array( 'status' => 404 ) );
		}

		$item['order_id'] = $order_id;
		$response         = rest_ensure_response( $this->prepare_item_for_response( $item, $request ) );

		if ( ! $actions->delete_tracking_item( $order_id, $tracking_id ) ) {
			return new WP_Error( 'wcst_rest_cannot_delete', __( 'The tracking item cannot be deleted.', 'trackora' ), array( 'status' => 500 ) );
		}

		return $response;
	}

	public function get_providers( $request ) {
		return rest_ensure_response( WCST_Actions::get_instance()->get_providers() );
	}

	// -------------------------------------------------------------------------
	// Response preparation
	// -------------------------------------------------------------------------

	public function prepare_item_for_response( $item, $request ) {
		$data = array(
			'tracking_id'       => $item['tracking_id'],
			'tracking_provider' => isset( $item['formatted_tracking_provider'] ) ? $item['formatted_tracking_provider'] : $item['tracking_provider'],
			'tracking_link'     => isset( $item['formatted_tracking_link'] )     ? $item['formatted_tracking_link']     : '',
			'tracking_number'   => $item['tracking_number'],
			'date_shipped'      => isset( $item['formatted_date_shipped_ymd'] )  ? $item['formatted_date_shipped_ymd']  : '',
		);

		$order_id = isset( $item['order_id'] ) ? $item['order_id'] : 0;
		$context  = ! empty( $request['context'] ) ? $request['context'] : 'view';
		$data     = $this->add_additional_fields_to_object( $data, $request );
		$data     = $this->filter_response_by_context( $data, $context );

		$response = rest_ensure_response( $data );
		$response->add_links( $this->prepare_links( $order_id, $item ) );

		return apply_filters( 'wcst_rest_prepare_tracking', $response, $item, $request );
	}

	protected function prepare_links( $order_id, $item ) {
		$base = 'orders/' . (int) $order_id . '/trackings';
		return array(
			'self'       => array( 'href' => rest_url( "/{$this->namespace}/{$base}/{$item['tracking_id']}" ) ),
			'collection' => array( 'href' => rest_url( "/{$this->namespace}/{$base}" ) ),
			'up'         => array( 'href' => rest_url( "/{$this->namespace}/orders/{$order_id}" ) ),
		);
	}

	// -------------------------------------------------------------------------
	// Schema
	// -------------------------------------------------------------------------

	public function get_item_schema() {
		return $this->add_additional_fields_schema( array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'wcst_tracking',
			'type'       => 'object',
			'properties' => array(
				'tracking_id'              => array(
					'description' => __( 'Unique identifier for the tracking item.', 'trackora' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
					'readonly'    => true,
				),
				'tracking_provider'        => array(
					'description' => __( 'Tracking provider name.', 'trackora' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
				'custom_tracking_provider' => array(
					'description' => __( 'Custom provider name.', 'trackora' ),
					'type'        => 'string',
					'context'     => array( 'edit' ),
				),
				'custom_tracking_link'     => array(
					'description' => __( 'Custom tracking URL.', 'trackora' ),
					'type'        => 'string',
					'format'      => 'uri',
					'context'     => array( 'edit' ),
				),
				'tracking_number'          => array(
					'description' => __( 'Tracking number.', 'trackora' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
				'date_shipped'             => array(
					'description' => __( 'Shipped date (Y-m-d).', 'trackora' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
			),
		) );
	}

	public function get_collection_params() {
		return array(
			'context' => $this->get_context_param( array( 'default' => 'view' ) ),
		);
	}
}
