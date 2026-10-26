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

	<header id="masthead" class="site-header fixed-top py-3">
		<div class="container">
			<div class="row align-items-center g-3">
				<div class="col-12 col-lg-4">
					
<div class="site-branding d-flex align-items-center gap-3">
    <a
        href="<?php echo esc_url( home_url( '/' ) ); ?>"
        class="custom-logo-link mt-header-logo"
        rel="home"
        aria-label="<?php echo esc_attr( 'Vai alla homepage di ' . get_bloginfo( 'name' ) ); ?>"
    >
        <img
            src="<?php echo esc_url( get_template_directory_uri() . '/assets/logos/mt-favicon/favicon-512.png' ); ?>"
            alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
            class="custom-logo mt-header-logo__image"
            width="52"
            height="52"
            decoding="async"
        >
    </a>
</div>

				</div>

				<div class="col-12 col-lg-8">
					<nav id="site-navigation" class="main-navigation d-flex">
						<button class="menu-toggle btn btn-outline-secondary btn-sm d-lg-none" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'mario_tolvo_portfolio' ); ?></button>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'nav gap-3 flex-wrap justify-content-lg-end mb-0',
								'container'      => false,
								'fallback_cb'    => false,
								'walker'         => new Mario_Tolvo_Portfolio_Nav_Walker(),
							)
						);
						?>
					</nav>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->
