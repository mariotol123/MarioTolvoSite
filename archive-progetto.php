<?php
/**
 * Archive template for projects.
 *
 * @package mario_tolvo_portfolio
 */

get_header();

$projects_query = new WP_Query(
	array(
		'post_type'      => 'progetto',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

$filter_terms = array();
foreach ( array( 'categoria_progetto', 'tecnologia' ) as $taxonomy ) {
	$terms = get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
		)
	);

	if ( ! is_wp_error( $terms ) && $terms ) {
		$filter_terms = array_merge( $filter_terms, $terms );
	}
}
?>

<main id="primary" class="site-main projects-archive" data-header-theme="light">
	<section class="projects-grid py-5">
		<div class="container py-lg-5">
			<header class="projects-grid__header mb-4 mb-lg-5">
				<h1 class="projects-grid__title h1 mb-3"><?php esc_html_e( 'Progetti', 'mario_tolvo_portfolio' ); ?></h1>
				<p class="projects-grid__subtitle mb-0"><?php esc_html_e( 'Una selezione dei progetti che ho progettato e sviluppato.', 'mario_tolvo_portfolio' ); ?></p>
			</header>

			<?php if ( $filter_terms ) : ?>
				<div class="projects-grid__filters d-flex align-items-center flex-wrap gap-2 mb-4" aria-label="<?php esc_attr_e( 'Filtra progetti', 'mario_tolvo_portfolio' ); ?>">
					<button class="projects-grid__filter is-active" type="button" data-project-filter-all aria-pressed="true"><?php esc_html_e( 'Tutti', 'mario_tolvo_portfolio' ); ?></button>
					<?php foreach ( $filter_terms as $filter_term ) : ?>
						<button class="projects-grid__filter" type="button" data-project-filter="<?php echo esc_attr( $filter_term->taxonomy . ':' . $filter_term->slug ); ?>" aria-pressed="false"><?php echo esc_html( $filter_term->name ); ?></button>
					<?php endforeach; ?>
					<?php if ( count( $filter_terms ) > 20 ) : ?>
						<button class="projects-grid__filter projects-grid__filters-toggle" type="button" data-project-filters-toggle data-label-expand="<?php esc_attr_e( 'Mostra tutte', 'mario_tolvo_portfolio' ); ?>" data-label-collapse="<?php esc_attr_e( 'Mostra meno', 'mario_tolvo_portfolio' ); ?>" aria-expanded="false" hidden><?php esc_html_e( 'Mostra tutte', 'mario_tolvo_portfolio' ); ?></button>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $projects_query->have_posts() ) : ?>
				<div class="projects-grid__items projects-archive__items row g-4" data-projects-grid>
					<?php while ( $projects_query->have_posts() ) : $projects_query->the_post(); ?>
						<?php
						$project_id         = get_the_ID();
						$categories         = get_the_terms( $project_id, 'categoria_progetto' );
						$technologies       = get_the_terms( $project_id, 'tecnologia' );
						$hero_image         = get_field( 'project_hero_image', $project_id );
						$short_description  = get_field( 'project_short_description', $project_id );
						$project_terms_attr = array();

						foreach ( array( $categories, $technologies ) as $terms ) {
							if ( ! is_wp_error( $terms ) && is_array( $terms ) ) {
								foreach ( $terms as $term ) {
									$project_terms_attr[] = $term->taxonomy . ':' . $term->slug;
								}
							}
						}
						?>
						<div class="projects-grid__item col-12 col-lg-6" data-project-card data-project-terms="<?php echo esc_attr( implode( ' ', $project_terms_attr ) ); ?>">
							<article class="project-card h-100">
								<a class="project-card__media" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Vedi progetto %s', 'mario_tolvo_portfolio' ), get_the_title() ) ); ?>">
									<?php if ( ! empty( $hero_image['ID'] ) ) : ?>
										<?php echo wp_get_attachment_image( (int) $hero_image['ID'], 'large', false, array( 'class' => 'project-card__image' ) ); ?>
									<?php elseif ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'large', array( 'class' => 'project-card__image' ) ); ?>
									<?php else : ?>
										<span class="project-card__image-placeholder"></span>
									<?php endif; ?>
								</a>
								<div class="project-card__content">
									<?php if ( ! is_wp_error( $categories ) && $categories ) : ?><div class="project-card__categories mb-3"><?php foreach ( $categories as $category ) : ?><span class="project-card__category"><?php echo esc_html( $category->name ); ?></span><?php endforeach; ?></div><?php endif; ?>
									<h2 class="project-card__title h3 mb-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<?php if ( $short_description ) : ?><p class="project-card__description mb-4"><?php echo esc_html( $short_description ); ?></p><?php endif; ?>
									<?php if ( ! is_wp_error( $technologies ) && $technologies ) : ?><ul class="project-card__technologies d-flex flex-wrap gap-2 list-unstyled mb-4"><?php foreach ( $technologies as $technology ) : ?><li><?php echo esc_html( $technology->name ); ?></li><?php endforeach; ?></ul><?php endif; ?>
									<a class="project-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Vedi progetto', 'mario_tolvo_portfolio' ); ?></a>
								</div>
							</article>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			<?php else : ?>
				<p class="projects-grid__empty mb-0"><?php esc_html_e( 'Nessun progetto disponibile.', 'mario_tolvo_portfolio' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer();
