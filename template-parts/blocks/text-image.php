<?php
/**
 * Flexible content block: Text and image.
 *
 * @package mario_tolvo_portfolio
 */

$text_image_title = get_sub_field( 'text_image_title' );
$text_image_description = get_sub_field( 'text_image_description' );
$text_image_button = get_sub_field( 'text_image_button' );
$text_image_image = get_sub_field( 'text_image_image' );
$text_image_image_id = ! empty( $text_image_image['ID'] ) ? (int) $text_image_image['ID'] : 0;
$block_anchor = sanitize_title( (string) get_sub_field( 'block_anchor' ) );

if ( empty( $text_image_title ) && empty( $text_image_description ) && ! $text_image_image_id ) {
	return;
}
?>

<section<?php if ( $block_anchor ) : ?> id="<?php echo esc_attr( $block_anchor ); ?>"<?php endif; ?> class="flexible-block text-image-block py-5" data-header-theme="light">
	<div class="container py-lg-5">
		<div class="row align-items-start g-5">
			<div class="col-12 col-lg-6">
				<div class="text-image-block__content">
					<?php if ( $text_image_title ) : ?>
						<h2 class="text-image-block__title mb-4">
							<?php echo esc_html( $text_image_title ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( $text_image_description ) : ?>
						<div class="text-image-block__description lead mb-4">
							<?php echo wp_kses_post( $text_image_description ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $text_image_button ) : ?>
						<a class="text-image-block__button btn btn-primary btn-lg text-uppercase js-scramble-button" href="<?php echo esc_url( $text_image_button['url'] ); ?>" target="<?php echo esc_attr( $text_image_button['target'] ? $text_image_button['target'] : '_self' ); ?>">
							<?php echo esc_html( $text_image_button['title'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $text_image_image_id ) : ?>
				<div class="col-12 col-lg-6">
					<div class="text-image-block__media">
						<?php
						echo wp_get_attachment_image(
							$text_image_image_id,
							'large',
							false,
							array(
								'class'   => 'text-image-block__image',
								'loading' => 'lazy',
							)
						);
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
