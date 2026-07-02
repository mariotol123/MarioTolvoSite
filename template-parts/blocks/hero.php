<?php
/**
 * Flexible content block: Hero.
 *
 * @package mario_tolvo_portfolio
 */

$hero_title = get_sub_field( 'hero_title' );
$hero_text = get_sub_field( 'hero_text' );
$hero_background_image = get_sub_field( 'hero_background_image' );
$hero_primary_button = get_sub_field( 'hero_primary_button' );
$hero_secondary_button = get_sub_field( 'hero_secondary_button' );

if ( empty( $hero_title ) ) {
	return;
}

$background_url = '';
if ( ! empty( $hero_background_image['url'] ) ) {
	$background_url = $hero_background_image['url'];
}

$hero_style = '';
if ( $background_url ) {
	$hero_style = 'style="background-image: linear-gradient(0deg, rgba(17, 17, 17, 0.55), rgba(17, 17, 17, 0.55)), url(' . esc_url( $background_url ) . ');"';
}
?>

<section class="hero-block position-relative overflow-hidden d-flex align-items-center min-vh-100 text-white" <?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(17, 17, 17, 0.25);"></div>
	<div class="container position-relative z-1 py-5">
		<div class="row align-items-center min-vh-100 py-5">
			<div class="col-12 col-lg-6">
				<h1 class="display-4 fw-bold mb-3 text-white"><?php echo esc_html( $hero_title ); ?></h1>
				<?php if ( $hero_text ) : ?>
					<p class="lead mb-4 h4 text-white"><?php echo esc_html( $hero_text ); ?></p>
				<?php endif; ?>
				<div class="d-flex flex-column flex-sm-row gap-3">
					<?php if ( $hero_primary_button ) : ?>
						<a class="btn btn-primary btn-lg text-uppercase js-scramble-button" href="<?php echo esc_url( $hero_primary_button['url'] ); ?>" target="<?php echo esc_attr( $hero_primary_button['target'] ? $hero_primary_button['target'] : '_self' ); ?>">
							<?php echo esc_html( $hero_primary_button['title'] ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $hero_secondary_button ) : ?>
						<a class="btn btn-outline-light btn-lg text-uppercase js-scramble-button" href="<?php echo esc_url( $hero_secondary_button['url'] ); ?>" target="<?php echo esc_attr( $hero_secondary_button['target'] ? $hero_secondary_button['target'] : '_self' ); ?>">
							<?php echo esc_html( $hero_secondary_button['title'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
