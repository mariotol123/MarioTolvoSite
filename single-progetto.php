<?php
/**
 * Single project template.
 *
 * @package mario_tolvo_portfolio
 */

get_header();

while ( have_posts() ) :
	the_post();

	$project_id    = get_the_ID();
	$client        = get_field( 'project_client', $project_id );
	$year          = get_field( 'project_year', $project_id );
	$role          = get_field( 'project_role', $project_id );
	$site_url      = get_field( 'project_site_url', $project_id );
	$status        = get_field( 'project_status', $project_id );
	$short_description = get_field( 'project_short_description', $project_id );
	$description   = get_field( 'project_description', $project_id );
	$contribution  = get_field( 'project_contribution', $project_id );
	$challenge     = get_field( 'project_challenge', $project_id );
	$solution      = get_field( 'project_solution', $project_id );
	$results       = get_field( 'project_results', $project_id );
	$gallery       = get_field( 'project_gallery', $project_id );
	$links         = get_field( 'project_links', $project_id );
	$hero_image    = get_field( 'project_hero_image', $project_id );
	$categories    = get_the_terms( $project_id, 'categoria_progetto' );
	$technologies  = get_the_terms( $project_id, 'tecnologia' );
	$metadata      = array_filter(
		array(
			esc_html__( 'Cliente', 'mario_tolvo_portfolio' ) => $client,
			esc_html__( 'Anno', 'mario_tolvo_portfolio' )    => $year,
			esc_html__( 'Ruolo', 'mario_tolvo_portfolio' )   => $role,
			esc_html__( 'Stato', 'mario_tolvo_portfolio' )   => $status,
		)
	);
	?>
	<main id="primary" class="site-main project-detail" data-header-theme="light">
		<article <?php post_class( 'project-detail__article' ); ?>>
			<header class="project-detail__hero py-5">
				<div class="container py-lg-5">
					<a class="project-detail__back" href="<?php echo esc_url( get_post_type_archive_link( 'progetto' ) ); ?>">&larr; <?php esc_html_e( 'Tutti i progetti', 'mario_tolvo_portfolio' ); ?></a>
					<?php if ( ! is_wp_error( $categories ) && $categories ) : ?><p class="project-detail__eyebrow mt-4 mb-3"><?php echo esc_html( implode( ' · ', wp_list_pluck( $categories, 'name' ) ) ); ?></p><?php endif; ?>
					<h1 class="project-detail__title mb-4"><?php the_title(); ?></h1>
					<?php if ( $short_description ) : ?><p class="project-detail__intro mb-4"><?php echo esc_html( $short_description ); ?></p><?php endif; ?>
					<?php if ( $metadata ) : ?><dl class="project-detail__metadata mb-0"><?php foreach ( $metadata as $label => $value ) : ?><div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div><?php endforeach; ?></dl><?php endif; ?>
				</div>
			</header>

			<?php if ( ! empty( $hero_image['ID'] ) || has_post_thumbnail() ) : ?>
				<div class="container"><figure class="project-detail__featured mb-0"><?php if ( ! empty( $hero_image['ID'] ) ) { echo wp_get_attachment_image( (int) $hero_image['ID'], 'full', false, array( 'class' => 'project-detail__featured-image' ) ); } else { the_post_thumbnail( 'full', array( 'class' => 'project-detail__featured-image' ) ); } ?></figure></div>
			<?php endif; ?>

			<div class="container py-5 py-lg-6">
				<div class="row justify-content-between g-5">
					<div class="col-lg-7">
						<?php if ( $description ) : ?><section class="project-detail__section"><h2><?php esc_html_e( 'Il progetto', 'mario_tolvo_portfolio' ); ?></h2><div class="project-detail__copy"><?php echo wp_kses_post( $description ); ?></div></section><?php endif; ?>
						<?php if ( $challenge || $solution || $results ) : ?><div class="project-detail__narrative"><?php if ( $challenge ) : ?><section class="project-detail__section"><h2><?php esc_html_e( 'La sfida', 'mario_tolvo_portfolio' ); ?></h2><?php echo wp_kses_post( wpautop( $challenge ) ); ?></section><?php endif; ?><?php if ( $solution ) : ?><section class="project-detail__section"><h2><?php esc_html_e( 'La soluzione', 'mario_tolvo_portfolio' ); ?></h2><?php echo wp_kses_post( wpautop( $solution ) ); ?></section><?php endif; ?><?php if ( $results ) : ?><section class="project-detail__section"><h2><?php esc_html_e( 'I risultati', 'mario_tolvo_portfolio' ); ?></h2><?php echo wp_kses_post( wpautop( $results ) ); ?></section><?php endif; ?></div><?php endif; ?>
					</div>
					<aside class="col-lg-4">
						<div class="project-detail__sidebar">
							<?php if ( ! is_wp_error( $technologies ) && $technologies ) : ?><section><h2 class="h5"><?php esc_html_e( 'Tecnologie', 'mario_tolvo_portfolio' ); ?></h2><ul class="project-detail__tags list-unstyled mb-0"><?php foreach ( $technologies as $technology ) : ?><li><?php echo esc_html( $technology->name ); ?></li><?php endforeach; ?></ul></section><?php endif; ?>
							<?php if ( $contribution ) : ?><section><h2 class="h5"><?php esc_html_e( 'Il mio contributo', 'mario_tolvo_portfolio' ); ?></h2><ul class="project-detail__contribution mb-0"><?php foreach ( $contribution as $item ) : ?><?php if ( ! empty( $item['activity'] ) ) : ?><li><?php echo esc_html( $item['activity'] ); ?></li><?php endif; ?><?php endforeach; ?></ul></section><?php endif; ?>
							<?php if ( $site_url || $links ) : ?><section><h2 class="h5"><?php esc_html_e( 'Link', 'mario_tolvo_portfolio' ); ?></h2><div class="project-detail__links"><?php if ( $site_url ) : ?><a href="<?php echo esc_url( $site_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Visita il sito', 'mario_tolvo_portfolio' ); ?></a><?php endif; ?><?php foreach ( (array) $links as $link ) : ?><?php if ( ! empty( $link['url'] ) ) : ?><a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $link['text'] ?: $link['url'] ); ?></a><?php endif; ?><?php endforeach; ?></div></section><?php endif; ?>
						</div>
					</aside>
				</div>

				<?php if ( $gallery ) : ?><section class="project-detail__gallery mt-5 pt-lg-4"><h2 class="mb-4"><?php esc_html_e( 'Gallery', 'mario_tolvo_portfolio' ); ?></h2><div class="row g-4"><?php foreach ( $gallery as $gallery_item ) : ?><?php if ( ! empty( $gallery_item['image']['ID'] ) ) : ?><figure class="col-12 col-md-6 mb-0"><?php echo wp_get_attachment_image( (int) $gallery_item['image']['ID'], 'large', false, array( 'class' => 'project-detail__gallery-image' ) ); ?><?php if ( ! empty( $gallery_item['caption'] ) ) : ?><figcaption><?php echo esc_html( $gallery_item['caption'] ); ?></figcaption><?php endif; ?></figure><?php endif; ?><?php endforeach; ?></div></section><?php endif; ?>
			</div>
		</article>
	</main>
<?php endwhile; get_footer();
