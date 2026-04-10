<?php
/**
 * Email (HTML) – Tracking Information.
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

$cell_style = 'text-align:left; font-family:"Helvetica Neue",Helvetica,Roboto,Arial,sans-serif; color:#737373; border:1px solid #e4e4e4; padding:12px;';
?>

<h2><?php echo esc_html( apply_filters( 'wcst_email_tracking_title', __( 'Tracking Information', 'wc-shipment-tracker' ) ) ); ?></h2>

<table class="td" cellspacing="0" cellpadding="6" style="width:100%; margin-bottom:20px;" border="1">
	<thead>
		<tr>
			<th style="<?php echo esc_attr( $cell_style ); ?>"><?php esc_html_e( 'Provider', 'wc-shipment-tracker' ); ?></th>
			<th style="<?php echo esc_attr( $cell_style ); ?>"><?php esc_html_e( 'Tracking Number', 'wc-shipment-tracker' ); ?></th>
			<th style="<?php echo esc_attr( $cell_style ); ?>"><?php esc_html_e( 'Date', 'wc-shipment-tracker' ); ?></th>
			<th style="<?php echo esc_attr( $cell_style ); ?>">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $tracking_items as $item ) : ?>
			<tr>
				<td style="<?php echo esc_attr( $cell_style ); ?>">
					<?php echo esc_html( $item['formatted_tracking_provider'] ); ?>
				</td>
				<td style="<?php echo esc_attr( $cell_style ); ?>">
					<?php echo esc_html( $item['tracking_number'] ); ?>
				</td>
				<td style="<?php echo esc_attr( $cell_style ); ?>">
					<?php if ( $item['formatted_date_shipped_ymd'] ) : ?>
						<time datetime="<?php echo esc_attr( $item['formatted_date_shipped_ymd'] ); ?>"
							  title="<?php echo esc_attr( $item['formatted_date_shipped_wc'] ); ?>">
							<?php echo esc_html( $item['formatted_date_shipped_i18n'] ); ?>
						</time>
					<?php else : ?>
						&ndash;
					<?php endif; ?>
				</td>
				<td style="<?php echo esc_attr( $cell_style ); ?> text-align:center;">
					<?php if ( $item['formatted_tracking_link'] ) : ?>
						<a href="<?php echo esc_url( $item['formatted_tracking_link'] ); ?>" target="_blank">
							<?php esc_html_e( 'Track', 'wc-shipment-tracker' ); ?>
						</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
