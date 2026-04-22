<?php
/**
 * Shortcode [wcst_tracking] – Public tracking lookup page.
 *
 * @package WC_Shipment_Tracker
 *
 * Variables available:
 *   $state          string  'form' | 'results' | 'no_tracking' | 'error'
 *   $order          WC_Order|null
 *   $tracking_items array (formatted)
 *   $error          string
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="wcst-public-tracking">

	<?php if ( 'error' === $state ) : ?>

		<div class="wcst-notice wcst-notice--error">
			<p><?php echo esc_html( $error ); ?></p>
		</div>

	<?php endif; ?>

	<?php if ( 'no_tracking' === $state ) : ?>

		<div class="wcst-notice wcst-notice--info">
			<p><?php esc_html_e( 'Your order has no tracking information yet. Please check back later.', 'trackora' ); ?></p>
		</div>

	<?php endif; ?>

	<?php if ( 'results' === $state && ! empty( $tracking_items ) ) : ?>

		<div class="wcst-results">

			<p class="wcst-results__order">
				<?php
				printf(
					/* translators: %s = order number */
					esc_html__( 'Tracking information for order %s', 'trackora' ),
					'<strong>#' . esc_html( $order->get_order_number() ) . '</strong>'
				);
				?>
			</p>

			<table class="shop_table shop_table_responsive wcst-tracking-table">
				<thead>
					<tr>
						<th class="wcst-col-provider"><span class="nobr"><?php esc_html_e( 'Provider', 'trackora' ); ?></span></th>
						<th class="wcst-col-number"><span class="nobr"><?php esc_html_e( 'Tracking Number', 'trackora' ); ?></span></th>
						<th class="wcst-col-date"><span class="nobr"><?php esc_html_e( 'Date', 'trackora' ); ?></span></th>
						<th class="wcst-col-action">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $tracking_items as $item ) : ?>
						<tr class="wcst-tracking-row">
							<td class="wcst-col-provider" data-title="<?php esc_attr_e( 'Provider', 'trackora' ); ?>">
								<?php echo esc_html( $item['formatted_tracking_provider'] ); ?>
							</td>
							<td class="wcst-col-number" data-title="<?php esc_attr_e( 'Tracking Number', 'trackora' ); ?>">
								<span class="wcst-number-row">
									<span class="wcst-number-text"><?php echo esc_html( $item['tracking_number'] ); ?></span>
									<button type="button"
										class="wcst-copy-btn"
										data-copy="<?php echo esc_attr( $item['tracking_number'] ); ?>"
										title="<?php esc_attr_e( 'Copy tracking number', 'trackora' ); ?>"
										aria-label="<?php esc_attr_e( 'Copy tracking number', 'trackora' ); ?>">
										<svg class="wcst-icon-copy" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
										<svg class="wcst-icon-check" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
									</button>
								</span>
							</td>
							<td class="wcst-col-date" data-title="<?php esc_attr_e( 'Date', 'trackora' ); ?>">
								<?php if ( $item['formatted_date_shipped_ymd'] ) : ?>
									<time datetime="<?php echo esc_attr( $item['formatted_date_shipped_ymd'] ); ?>"
										  title="<?php echo esc_attr( $item['formatted_date_shipped_wc'] ); ?>">
										<?php echo esc_html( $item['formatted_date_shipped_i18n'] ); ?>
									</time>
								<?php else : ?>
									&ndash;
								<?php endif; ?>
							</td>
							<td class="wcst-col-action">
								<?php if ( $item['formatted_tracking_link'] ) : ?>
									<a href="<?php echo esc_url( $item['formatted_tracking_link'] ); ?>"
									   target="_blank"
									   rel="noopener noreferrer"
									   class="button wcst-track-button">
										<?php esc_html_e( 'Track', 'trackora' ); ?>
									</a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

		</div><!-- .wcst-results -->

		<p class="wcst-lookup-again">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				&larr; <?php esc_html_e( 'Track another order', 'trackora' ); ?>
			</a>
		</p>

	<?php endif; ?>

	<?php if ( in_array( $state, array( 'form', 'error' ), true ) ) : ?>

		<div class="wcst-lookup-form">

			<p class="wcst-lookup-form__intro">
				<?php esc_html_e( 'Enter your order number and email address to track your shipment.', 'trackora' ); ?>
			</p>

			<form method="post" action="" class="wcst-form">
				<?php wp_nonce_field( 'wcst_tracking_lookup', 'wcst_lookup_nonce' ); ?>

				<p class="form-row">
					<label for="wcst_order_id"><?php esc_html_e( 'Order Number', 'trackora' ); ?> <span class="required">*</span></label>
					<input type="number"
						id="wcst_order_id"
						name="wcst_order_id"
						class="input-text"
						required
						min="1"
						placeholder="<?php esc_attr_e( 'e.g. 1234', 'trackora' ); ?>"
						value="<?php echo isset( $_POST['wcst_order_id'] ) ? absint( $_POST['wcst_order_id'] ) : ''; ?>" />
				</p>

				<p class="form-row">
					<label for="wcst_email"><?php esc_html_e( 'Billing Email', 'trackora' ); ?> <span class="required">*</span></label>
					<input type="email"
						id="wcst_email"
						name="wcst_email"
						class="input-text"
						required
						placeholder="<?php esc_attr_e( 'you@example.com', 'trackora' ); ?>"
						value="<?php echo isset( $_POST['wcst_email'] ) ? esc_attr( sanitize_email( wp_unslash( $_POST['wcst_email'] ) ) ) : ''; ?>" />
				</p>

				<p class="form-row">
					<button type="submit" class="button<?php echo wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ) : ''; ?>">
						<?php esc_html_e( 'Track Order', 'trackora' ); ?>
					</button>
				</p>

			</form>

		</div><!-- .wcst-lookup-form -->

	<?php endif; ?>

</div><!-- .wcst-public-tracking -->
