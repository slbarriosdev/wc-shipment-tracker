<?php
/**
 * My Account – View Order: Tracking Information table.
 *
 * @package WC_Shipment_Tracker
 * @version 1.0.0
 *
 * Variables available:
 *   $order          WC_Order
 *   $tracking_items array (formatted)
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $tracking_items ) || ! is_array( $tracking_items ) ) {
	return;
}
?>

<h2 class="wcst-tracking-title">
	<?php echo esc_html( apply_filters( 'wcst_myaccount_tracking_title', __( 'Tracking Information', 'trackora' ) ) ); ?>
</h2>

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
				<td class="wcst-col-action" style="text-align:center;">
					<?php if ( $item['formatted_tracking_link'] ) : ?>
						<a href="<?php echo esc_url( $item['formatted_tracking_link'] ); ?>"
						   target="_blank"
						   class="button wcst-track-button">
							<?php esc_html_e( 'Track', 'trackora' ); ?>
						</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
