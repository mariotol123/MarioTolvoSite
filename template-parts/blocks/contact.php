<?php
/**
 * Flexible content block: Contact.
 *
 * @package mario_tolvo_portfolio
 */

$contact_title = get_sub_field( 'contact_title' );
$contact_description = get_sub_field( 'contact_description' );
$contact_details = get_sub_field( 'contact_details' );
$contact_form_id = (int) get_sub_field( 'contact_form' );
$block_anchor = sanitize_title( (string) get_sub_field( 'block_anchor' ) );

if ( empty( $contact_title ) && ! $contact_form_id ) {
	return;
}
?>

<section<?php if ( $block_anchor ) : ?> id="<?php echo esc_attr( $block_anchor ); ?>"<?php endif; ?> class="flexible-block contact-block py-5" data-header-theme="light">
	<div class="container py-lg-5">
		<div class="row align-items-start g-5">
			<div class="col-12 col-lg-5">
				<?php if ( $contact_title ) : ?>
					<h2 class="contact-block__title mb-4">
						<?php echo esc_html( $contact_title ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $contact_details ) : ?>
					<ul class="contact-block__details list-unstyled mb-4">
						<?php foreach ( $contact_details as $contact_detail ) : ?>
							<?php
							$contact_detail_label = isset( $contact_detail['contact_detail_label'] ) ? $contact_detail['contact_detail_label'] : '';
							$contact_detail_value = isset( $contact_detail['contact_detail_value'] ) ? $contact_detail['contact_detail_value'] : '';
							$contact_detail_link = isset( $contact_detail['contact_detail_link'] ) ? $contact_detail['contact_detail_link'] : array();
							$contact_detail_target = ! empty( $contact_detail_link['target'] ) ? $contact_detail_link['target'] : '_self';
							?>
							<li class="contact-block__detail">
								<?php if ( $contact_detail_label ) : ?>
									<span class="contact-block__detail-label">
										<?php echo esc_html( $contact_detail_label ); ?>
									</span>
								<?php endif; ?>

								<?php if ( ! empty( $contact_detail_link['url'] ) ) : ?>
									<a
										class="contact-block__detail-link"
										href="<?php echo esc_url( $contact_detail_link['url'] ); ?>"
										target="<?php echo esc_attr( $contact_detail_target ); ?>"
										<?php echo '_blank' === $contact_detail_target ? 'rel="noopener noreferrer"' : ''; ?>
									>
										<?php echo esc_html( ! empty( $contact_detail_link['title'] ) ? $contact_detail_link['title'] : $contact_detail_link['url'] ); ?>
									</a>
								<?php elseif ( $contact_detail_value ) : ?>
									<span class="contact-block__detail-value">
										<?php echo esc_html( $contact_detail_value ); ?>
									</span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $contact_description ) : ?>
					<div class="contact-block__description lead">
						<?php echo wp_kses_post( $contact_description ); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $contact_form_id && 'wpcf7_contact_form' === get_post_type( $contact_form_id ) ) : ?>
				<div class="col-12 col-lg-6 offset-lg-1">
					<div class="contact-block__form">
						<?php echo do_shortcode( '[contact-form-7 id="' . $contact_form_id . '"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
