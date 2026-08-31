<?php
/**
 * Flexible content block: Projects grid.
 *
 * @package mario_tolvo_portfolio
 */

$block_anchor = sanitize_title( (string) get_sub_field( 'block_anchor' ) );
$title        = get_sub_field( 'projects_grid_title' );
$subtitle     = get_sub_field( 'projects_grid_subtitle' );
$button       = get_sub_field( 'projects_grid_button' );

if ( empty( $title ) ) {
	return;
}

$projects_query = new WP_Query(
	array(
		'post_type'      => 'progetto',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'rand',
	)
);

$filter_terms = array();
$filter_taxonomies = array( 'categoria_progetto', 'tecnologia' );

foreach ( $filter_taxonomies as $filter_taxonomy ) {
	$terms = get_terms(
		array(
			'taxonomy'   => $filter_taxonomy,
			'hide_empty' => true,
		)
	);

	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		$filter_terms = array_merge( $filter_terms, $terms );
	}
}
?>

<section<?php if ( $block_anchor ) : ?> id="<?php echo esc_attr( $block_anchor ); ?>"<?php endif; ?> class="flexible-block projects-grid py-5" data-header-theme="light">
	<div class="container py-lg-5">
		<div class="projects-grid__header mb-4 mb-lg-5">
			<h2 class="projects-grid__title h1 mb-3"><?php echo esc_html( $title ); ?></h2>
			<?php if ( $subtitle ) : ?>
				<p class="projects-grid__subtitle mb-0"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $filter_terms ) ) : ?>
			<div class="projects-grid__filters d-flex align-items-center flex-wrap gap-2 mb-4" aria-label="<?php echo esc_attr__( 'Filtra progetti', 'mario_tolvo_portfolio' ); ?>">
				<button class="projects-grid__filter is-active" type="button" data-project-filter-all aria-pressed="true">
					<?php echo esc_html__( 'Tutti', 'mario_tolvo_portfolio' ); ?>
				</button>
				<?php foreach ( $filter_terms as $filter_term ) : ?>
					<button class="projects-grid__filter" type="button" data-project-filter="<?php echo esc_attr( $filter_term->taxonomy . ':' . $filter_term->slug ); ?>" aria-pressed="false">
						<?php echo esc_html( $filter_term->name ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $projects_query->have_posts() ) : ?>
			<div class="projects-grid__items row g-4" data-projects-grid>
				<?php
				$project_index = 0;
				while ( $projects_query->have_posts() ) :
					$projects_query->the_post();

					$project_id          = get_the_ID();
					$project_terms       = array();
					$project_categories  = get_the_terms( $project_id, 'categoria_progetto' );
					$project_tech_terms  = get_the_terms( $project_id, 'tecnologia' );
					$project_hero_image  = get_field( 'project_hero_image', $project_id );
					$short_description   = get_field( 'project_short_description', $project_id );
					$project_terms_attr  = array();
					$is_initially_hidden = $project_index >= 3;

					if ( ! is_wp_error( $project_categories ) && ! empty( $project_categories ) ) {
						$project_terms = array_merge( $project_terms, $project_categories );
					}

					if ( ! is_wp_error( $project_tech_terms ) && ! empty( $project_tech_terms ) ) {
						$project_terms = array_merge( $project_terms, $project_tech_terms );
					}

					foreach ( $project_terms as $project_term ) {
						$project_terms_attr[] = $project_term->taxonomy . ':' . $project_term->slug;
					}

					if ( ! empty( $project_tech_terms ) && is_array( $project_tech_terms ) ) {
						shuffle( $project_tech_terms );
						$project_tech_terms = array_slice( $project_tech_terms, 0, 4 );
					}
					?>
					<div class="projects-grid__item col-12 col-md-6 col-xl-4<?php echo $is_initially_hidden ? ' is-hidden-by-default' : ''; ?>" data-project-card data-project-terms="<?php echo esc_attr( implode( ' ', $project_terms_attr ) ); ?>">
						<article class="project-card h-100">
							<a class="project-card__media" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Vedi progetto %s', 'mario_tolvo_portfolio' ), get_the_title() ) ); ?>">
								<?php if ( ! empty( $project_hero_image['ID'] ) ) : ?>
									<?php echo wp_get_attachment_image( (int) $project_hero_image['ID'], 'large', false, array( 'class' => 'project-card__image' ) ); ?>
								<?php elseif ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', array( 'class' => 'project-card__image' ) ); ?>
								<?php else : ?>
									<span class="project-card__image-placeholder"></span>
								<?php endif; ?>
							</a>

							<div class="project-card__content">
								<?php if ( ! empty( $project_categories ) && is_array( $project_categories ) ) : ?>
									<div class="project-card__categories mb-3">
										<?php foreach ( $project_categories as $project_category ) : ?>
											<span class="project-card__category"><?php echo esc_html( $project_category->name ); ?></span>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>

								<h3 class="project-card__title h4 mb-3">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>

								<?php if ( $short_description ) : ?>
									<p class="project-card__description mb-4"><?php echo esc_html( $short_description ); ?></p>
								<?php endif; ?>

								<?php if ( ! empty( $project_tech_terms ) && is_array( $project_tech_terms ) ) : ?>
									<ul class="project-card__technologies d-flex flex-wrap gap-2 list-unstyled mb-4">
										<?php foreach ( $project_tech_terms as $project_tech_term ) : ?>
											<li><?php echo esc_html( $project_tech_term->name ); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>

								<a class="project-card__link" href="<?php the_permalink(); ?>">
									<?php echo esc_html__( 'Vedi progetto', 'mario_tolvo_portfolio' ); ?>
								</a>
							</div>
						</article>
					</div>
					<?php
					$project_index++;
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p class="projects-grid__empty mb-0"><?php echo esc_html__( 'Nessun progetto disponibile.', 'mario_tolvo_portfolio' ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $button['url'] ) && ! empty( $button['title'] ) ) : ?>
			<?php $button_target = ! empty( $button['target'] ) ? $button['target'] : '_self'; ?>
			<div class="projects-grid__cta mt-4 mt-lg-5 text-center">
				<a class="btn btn-primary btn-lg text-uppercase js-scramble-button" href="<?php echo esc_url( $button['url'] ); ?>" target="<?php echo esc_attr( $button_target ); ?>"<?php echo '_blank' === $button_target ? ' rel="noopener noreferrer"' : ''; ?>>
					<?php echo esc_html( $button['title'] ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
