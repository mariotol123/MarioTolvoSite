<?php
/**
 * Flexible content block: CTA banner.
 *
 * @package mario_tolvo_portfolio
 */

$block_anchor = sanitize_title( (string) get_sub_field( 'block_anchor' ) );
$cta_banner_title = get_sub_field( 'cta_banner_title' );
$cta_banner_subtitle = get_sub_field( 'cta_banner_subtitle' );
$cta_banner_button = get_sub_field( 'cta_banner_button' );
$cta_banner_image = get_sub_field( 'cta_banner_image' );
$cta_banner_image_id = ! empty( $cta_banner_image['ID'] ) ? (int) $cta_banner_image['ID'] : 0;
$cta_banner_image_url = $cta_banner_image_id ? wp_get_attachment_image_url( $cta_banner_image_id, 'full' ) : '';
$cta_banner_style = $cta_banner_image_url
	? 'style="background-image: url(' . esc_url( $cta_banner_image_url ) . ');"'
	: '';

if ( empty( $cta_banner_title ) ) {
	return;
}
?>

<section<?php if ( $block_anchor ) : ?> id="<?php echo esc_attr( $block_anchor ); ?>"<?php endif; ?> class="flexible-block cta-banner position-relative overflow-hidden d-flex align-items-center text-white" data-header-theme="dark" <?php echo $cta_banner_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="cta-banner__overlay position-absolute top-0 start-0 w-100 h-100"></div>
	<div class="container position-relative z-1 py-5">
		<div class="row py-lg-5">
			<div class="col-12 col-lg-7">
				<h2 class="cta-banner__title text-white mb-3">
					<?php echo esc_html( $cta_banner_title ); ?>
				</h2>

				<?php if ( $cta_banner_subtitle ) : ?>
					<p class="cta-banner__subtitle lead text-white mb-4">
						<?php echo esc_html( $cta_banner_subtitle ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $cta_banner_button ) : ?>
					<?php $cta_banner_target = ! empty( $cta_banner_button['target'] ) ? $cta_banner_button['target'] : '_self'; ?>
					<a class="btn btn-primary btn-lg text-uppercase js-scramble-button" href="<?php echo esc_url( $cta_banner_button['url'] ); ?>" target="<?php echo esc_attr( $cta_banner_target ); ?>"<?php echo '_blank' === $cta_banner_target ? ' rel="noopener noreferrer"' : ''; ?>>
						<?php echo esc_html( $cta_banner_button['title'] ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
