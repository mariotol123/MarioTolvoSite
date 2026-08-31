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
$hero_icons = get_sub_field( 'hero_icons' );
$block_anchor = sanitize_title( (string) get_sub_field( 'block_anchor' ) );

if ( empty( $hero_title ) ) {
	return;
}

$background_url = '';
if ( ! empty( $hero_background_image['url'] ) ) {
	$background_url = $hero_background_image['url'];
}

$hero_style = '';
if ( $background_url ) {
	$hero_style = 'style="background-image: url(' . esc_url( $background_url ) . ');"';
}

$hero_title_words = preg_split( '/\s+/', trim( (string) $hero_title ) );
?>

<section<?php if ( $block_anchor ) : ?> id="<?php echo esc_attr( $block_anchor ); ?>"<?php endif; ?> class="flexible-block hero-block position-relative overflow-hidden d-flex align-items-center min-vh-100 text-white" data-header-theme="dark">
	<?php if ( $background_url ) : ?>
		<div class="hero-block__background position-absolute top-0 start-0 w-100 h-100" <?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>
	<?php endif; ?>
	<div class="hero-block__overlay position-absolute top-0 start-0 w-100 h-100"></div>
	<div class="container position-relative z-1 py-5">
		<div class="row align-items-center min-vh-100 py-5">
			<div class="col-12 col-lg-6">
				<h1 class="hero-block__title display-4 fw-bold mb-3 text-white" aria-label="<?php echo esc_attr( $hero_title ); ?>">
					<?php foreach ( $hero_title_words as $word_index => $hero_title_word ) : ?>
						<span class="hero-block__title-word" style="--hero-word-index: <?php echo esc_attr( (string) $word_index ); ?>;"><?php echo esc_html( $hero_title_word ); ?></span>
					<?php endforeach; ?>
				</h1>
				<?php if ( $hero_text ) : ?>
					<p class="hero-block__subtitle lead mb-4 h4 text-white"><?php echo esc_html( $hero_text ); ?></p>
				<?php endif; ?>
				<div class="hero-block__buttons d-flex flex-column flex-sm-row gap-3">
					<?php if ( $hero_primary_button ) : ?>
						<a class="hero-block__button btn btn-primary btn-lg text-uppercase js-scramble-button" href="<?php echo esc_url( $hero_primary_button['url'] ); ?>" target="<?php echo esc_attr( $hero_primary_button['target'] ? $hero_primary_button['target'] : '_self' ); ?>">
							<?php echo esc_html( $hero_primary_button['title'] ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $hero_secondary_button ) : ?>
						<a class="hero-block__button btn btn-outline-light btn-lg text-uppercase js-scramble-button" href="<?php echo esc_url( $hero_secondary_button['url'] ); ?>" target="<?php echo esc_attr( $hero_secondary_button['target'] ? $hero_secondary_button['target'] : '_self' ); ?>">
							<?php echo esc_html( $hero_secondary_button['title'] ); ?>
						</a>
					<?php endif; ?>
				</div>

				<?php if ( $hero_icons ) : ?>
					<ul class="hero-icons d-flex align-items-center flex-wrap gap-3 mt-4 mb-0 list-unstyled">
						<?php foreach ( $hero_icons as $hero_icon ) : ?>
							<?php
							$hero_icon_image = isset( $hero_icon['hero_icon_image'] ) ? $hero_icon['hero_icon_image'] : array();
							$hero_icon_link = isset( $hero_icon['hero_icon_link'] ) ? $hero_icon['hero_icon_link'] : array();
							$hero_icon_image_id = ! empty( $hero_icon_image['ID'] ) ? (int) $hero_icon_image['ID'] : 0;
							$hero_icon_target = ! empty( $hero_icon_link['target'] ) ? $hero_icon_link['target'] : '_self';

							if ( ! $hero_icon_image_id ) {
								continue;
							}
							?>
							<li class="hero-icons__item">
								<?php if ( ! empty( $hero_icon_link['url'] ) ) : ?>
									<a
										class="hero-icons__link"
										href="<?php echo esc_url( $hero_icon_link['url'] ); ?>"
										target="<?php echo esc_attr( $hero_icon_target ); ?>"
										<?php echo ! empty( $hero_icon_link['title'] ) ? 'aria-label="' . esc_attr( $hero_icon_link['title'] ) . '"' : ''; ?>
										<?php echo '_blank' === $hero_icon_target ? 'rel="noopener noreferrer"' : ''; ?>
									>
								<?php else : ?>
									<span class="hero-icons__icon">
								<?php endif; ?>

									<?php
									echo wp_get_attachment_image(
										$hero_icon_image_id,
										'thumbnail',
										false,
										array( 'class' => 'hero-icons__image' )
									);
									?>

								<?php if ( ! empty( $hero_icon_link['url'] ) ) : ?>
									</a>
								<?php else : ?>
									</span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
