<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mario_tolvo_portfolio
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'mario_tolvo_portfolio' ); ?></a>

	<header id="masthead" class="site-header py-3 border-bottom">
		<div class="container">
			<div class="row align-items-center g-3">
				<div class="col-12 col-lg-4">
					<div class="site-branding d-flex align-items-center gap-3">
						<?php the_custom_logo(); ?>
						<div>
							<?php
							if ( is_front_page() && is_home() ) :
								?>
								<h1 class="site-title h4 mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php
							else :
								?>
								<p class="site-title h4 mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
							endif;
							$mario_tolvo_portfolio_description = get_bloginfo( 'description', 'display' );
							if ( $mario_tolvo_portfolio_description || is_customize_preview() ) :
								?>
								<p class="site-description small text-muted mb-0"><?php echo $mario_tolvo_portfolio_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-8">
					<nav id="site-navigation" class="main-navigation d-flex justify-content-lg-end">
						<button class="menu-toggle btn btn-outline-secondary btn-sm d-lg-none" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'mario_tolvo_portfolio' ); ?></button>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'nav gap-3 flex-wrap justify-content-lg-end mb-0',
								'container'      => false,
								'fallback_cb'    => false,
							)
						);
						?>
					</nav>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->
