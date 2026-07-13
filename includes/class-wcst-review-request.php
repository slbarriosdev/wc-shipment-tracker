<?php
/**
 * WCST_Review_Request – asks for a wordpress.org review once the store has
 * actually got some use out of the plugin.
 *
 * The whole thing is deliberately easy to get rid of: "No thanks" is final,
 * the native dismiss button snoozes for a month, and nothing is ever blocked
 * or gated behind leaving a review.
 *
 * @package WC_Shipment_Tracker
 */

defined( 'ABSPATH' ) || exit;

class WCST_Review_Request {

	/** Single option holding the whole state. */
	const OPTION = 'wcst_review_state';

	/** Nonce action for the dismiss request. */
	const NONCE = 'wcst_dismiss_review';

	/** Trackings the store must have saved before we ask. */
	const MIN_TRACKINGS = 5;

	/** How long the plugin must have been installed before we ask. */
	const MIN_AGE = 1209600; // 14 days.

	/** How long "Maybe later" (and the native X) buys us. */
	const SNOOZE = 2592000; // 30 days.

	/** Screens the notice is allowed to appear on. */
	private function allowed_screens() {
		return array(
			'dashboard',                 // Dashboard.
			'plugins',                   // Plugins list.
			'shop_order',                // Single order, legacy CPT storage.
			'edit-shop_order',           // Orders list, legacy CPT storage.
			'woocommerce_page_wc-orders', // Orders list + single order, HPOS.
		);
	}

	/**
	 * Admin-only wiring: the notice and the request that dismisses it.
	 *
	 * The counter is deliberately NOT here. See register_counter().
	 */
	public function __construct() {
		add_action( 'admin_init',                  array( $this, 'maybe_backfill_install_time' ) );
		add_action( 'admin_enqueue_scripts',       array( $this, 'maybe_enqueue' ) );
		add_action( 'admin_notices',               array( $this, 'maybe_render' ) );
		add_action( 'wp_ajax_wcst_dismiss_review', array( $this, 'ajax_dismiss' ) );
	}

	/**
	 * Counts trackings on every request that can create one, admin or not.
	 *
	 * Kept separate from the constructor because the REST API does not run in
	 * an admin context, and a store creating trackings over REST is exactly the
	 * kind of store worth asking. Static so it costs nothing on the frontend.
	 */
	public static function register_counter() {
		add_action( 'wcst_tracking_saved', array( __CLASS__, 'increment_count' ) );
	}

	// -----------------------------------------------------------------------
	// State
	// -----------------------------------------------------------------------

	/**
	 * @return array Always fully populated, whatever is in the database.
	 */
	private static function get_state() {
		$state = get_option( self::OPTION, array() );

		if ( ! is_array( $state ) ) {
			$state = array();
		}

		return array_merge(
			array(
				'install_time'      => 0,
				'tracking_count'    => 0,
				'dismissed_until'   => 0,
				'dismissed_forever' => false,
			),
			$state
		);
	}

	/**
	 * Not autoloaded: the frontend never reads this.
	 *
	 * @param array $state
	 */
	private static function save_state( $state ) {
		update_option( self::OPTION, $state, false );
	}

	/**
	 * Stores installed before this feature shipped have no install_time, and a
	 * missing one would otherwise read as "installed at epoch" and fire the
	 * notice immediately. Treat first sight as the start of the clock instead.
	 */
	public function maybe_backfill_install_time() {
		$state = self::get_state();

		if ( (int) $state['install_time'] > 0 ) {
			return;
		}

		$state['install_time'] = time();
		self::save_state( $state );
	}

	/**
	 * Counts tracking numbers actually added. Hooked to wcst_tracking_saved.
	 */
	public static function increment_count() {
		$state = self::get_state();

		$state['tracking_count'] = (int) $state['tracking_count'] + 1;

		self::save_state( $state );
	}

	// -----------------------------------------------------------------------
	// Should we ask?
	// -----------------------------------------------------------------------

	/**
	 * @return bool
	 */
	private function should_show() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return false;
		}

		if ( ! $this->is_allowed_screen() ) {
			return false;
		}

		$state = self::get_state();

		if ( ! empty( $state['dismissed_forever'] ) ) {
			return false;
		}

		if ( time() <= (int) $state['dismissed_until'] ) {
			return false;
		}

		if ( (int) $state['tracking_count'] < self::MIN_TRACKINGS ) {
			return false;
		}

		$install_time = (int) $state['install_time'];

		if ( $install_time <= 0 || ( time() - $install_time ) < self::MIN_AGE ) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	private function is_allowed_screen() {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}

		$screen = get_current_screen();

		if ( ! $screen instanceof WP_Screen ) {
			return false;
		}

		return in_array( $screen->id, $this->allowed_screens(), true );
	}

	// -----------------------------------------------------------------------
	// Output
	// -----------------------------------------------------------------------

	/**
	 * Only loaded on the request that actually paints the notice.
	 */
	public function maybe_enqueue() {
		if ( ! $this->should_show() ) {
			return;
		}

		wp_register_script( 'wcst-review', false, array(), WCST_VERSION, true );
		wp_enqueue_script( 'wcst-review' );

		$data = 'var wcstReview = ' . wp_json_encode(
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( self::NONCE ),
			)
		) . ';';

		wp_add_inline_script( 'wcst-review', $data . $this->inline_js() );
	}

	public function maybe_render() {
		if ( ! $this->should_show() ) {
			return;
		}

		$state = self::get_state();
		$count = (int) $state['tracking_count'];
		?>
		<div id="wcst-review-notice" class="notice notice-info is-dismissible">
			<p>
				<?php
				printf(
					esc_html(
						/* translators: %d: number of tracking numbers the store has added with the plugin. */
						_n(
							'You have added %d tracking number with Trackora. If it is saving you time, a quick review would help other shop owners find it.',
							'You have added %d tracking numbers with Trackora. If it is saving you time, a quick review would help other shop owners find it.',
							$count,
							'trackora'
						)
					),
					(int) $count
				);
				?>
			</p>
			<p>
				<a class="button button-primary wcst-review-link"
					href="<?php echo esc_url( 'https://wordpress.org/support/plugin/trackora/reviews/#new-post' ); ?>"
					target="_blank"
					rel="noopener noreferrer">
					<?php esc_html_e( 'Leave a review ★★★★★', 'trackora' ); ?>
				</a>
				<button type="button" class="button-link wcst-review-later">
					<?php esc_html_e( 'Maybe later', 'trackora' ); ?>
				</button>
				<button type="button" class="button-link wcst-review-no">
					<?php esc_html_e( 'No thanks', 'trackora' ); ?>
				</button>
			</p>
		</div>
		<?php
	}

	/**
	 * Delegated from document, because core injects the native dismiss button
	 * after this script runs.
	 *
	 * @return string
	 */
	private function inline_js() {
		return <<<'JS'
( function() {
	function send( dismiss ) {
		var body = new FormData();
		body.append( 'action', 'wcst_dismiss_review' );
		body.append( 'dismiss', dismiss );
		body.append( 'nonce', wcstReview.nonce );

		window.fetch( wcstReview.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: body
		} );
	}

	function close( notice ) {
		if ( notice.parentNode ) {
			notice.parentNode.removeChild( notice );
		}
	}

	document.addEventListener( 'click', function( event ) {
		var notice = document.getElementById( 'wcst-review-notice' );

		if ( ! notice || ! notice.contains( event.target ) ) {
			return;
		}

		var el = event.target.closest( 'a, button' );

		if ( ! el ) {
			return;
		}

		// The review link keeps its default behaviour and opens in a new tab.
		if ( el.classList.contains( 'wcst-review-link' ) || el.classList.contains( 'wcst-review-no' ) ) {
			send( 'forever' );
			close( notice );
			return;
		}

		if ( el.classList.contains( 'wcst-review-later' ) || el.classList.contains( 'notice-dismiss' ) ) {
			send( 'later' );
			close( notice );
		}
	} );
}() );
JS;
	}

	// -----------------------------------------------------------------------
	// AJAX
	// -----------------------------------------------------------------------

	public function ajax_dismiss() {
		check_ajax_referer( self::NONCE, 'nonce' );

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json_error( null, 403 );
		}

		$dismiss = isset( $_POST['dismiss'] ) ? sanitize_key( wp_unslash( $_POST['dismiss'] ) ) : '';

		if ( ! in_array( $dismiss, array( 'later', 'forever' ), true ) ) {
			wp_send_json_error( null, 400 );
		}

		$state = self::get_state();

		if ( 'forever' === $dismiss ) {
			$state['dismissed_forever'] = true;
		} else {
			$state['dismissed_until'] = time() + self::SNOOZE;
		}

		self::save_state( $state );

		wp_send_json_success();
	}
}
