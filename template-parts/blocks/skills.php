<?php
/**
 * Flexible content block: Skills.
 *
 * @package mario_tolvo_portfolio
 */

$skills_title = get_sub_field( 'skills_title' );
$skills_items = get_sub_field( 'skills_items' );
$skills_has_more = is_array( $skills_items ) && count( $skills_items ) > 4;
$skills_grid_id = wp_unique_id( 'skills-grid-' );
$block_anchor = sanitize_title( (string) get_sub_field( 'block_anchor' ) );

if ( empty( $skills_title ) && empty( $skills_items ) ) {
	return;
}
?>

<section<?php if ( $block_anchor ) : ?> id="<?php echo esc_attr( $block_anchor ); ?>"<?php endif; ?> class="flexible-block skills-block py-5 text-white" data-header-theme="dark">
	<div class="container py-lg-5">
		<?php if ( $skills_title ) : ?>
			<h2 class="skills-block__title display-5 text-white mb-5">
				<?php echo esc_html( $skills_title ); ?>
			</h2>
		<?php endif; ?>

		<?php if ( $skills_items ) : ?>
			<div id="<?php echo esc_attr( $skills_grid_id ); ?>" class="skills-grid row row-cols-2 row-cols-lg-4 g-4 g-lg-5 justify-content-center">
				<?php foreach ( $skills_items as $skill_index => $skill ) : ?>
					<?php
					$skill_image = isset( $skill['skill_image'] ) ? $skill['skill_image'] : array();
					$skill_text = isset( $skill['skill_text'] ) ? $skill['skill_text'] : '';
					$skill_image_id = ! empty( $skill_image['ID'] ) ? (int) $skill_image['ID'] : 0;
					?>
					<div class="col"<?php echo $skill_index >= 4 ? ' data-skill-extra hidden' : ''; ?>>
						<article class="skill-card h-100 d-flex flex-column align-items-center text-center">
							<?php if ( $skill_image_id ) : ?>
								<div class="skill-card__media mb-3">
									<?php
									echo wp_get_attachment_image(
										$skill_image_id,
										'medium',
										false,
										array(
											'class'   => 'skill-card__image',
											'loading' => 'lazy',
										)
									);
									?>
								</div>
							<?php endif; ?>

							<?php if ( $skill_text ) : ?>
								<h3 class="skill-card__title h5 text-white mb-0">
									<?php echo esc_html( $skill_text ); ?>
								</h3>
							<?php endif; ?>
						</article>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $skills_has_more ) : ?>
				<div class="skills-block__actions text-center mt-5">
					<button
						type="button"
						class="skills-block__toggle btn btn-outline-light btn-lg text-uppercase js-scramble-button"
						aria-controls="<?php echo esc_attr( $skills_grid_id ); ?>"
						aria-expanded="false"
					>
						<?php esc_html_e( 'Tutte le competenze', 'mario_tolvo_portfolio' ); ?>
					</button>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
