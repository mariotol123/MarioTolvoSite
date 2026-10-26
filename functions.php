<?php
// test-theme-active
/**
 * mario_tolvo_portfolio functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mario_tolvo_portfolio
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! class_exists( 'Mario_Tolvo_Portfolio_Nav_Walker' ) ) {
	/**
	 * Custom nav walker for Bootstrap-style menu markup.
	 */
	class Mario_Tolvo_Portfolio_Nav_Walker extends Walker_Nav_Menu {
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n" . $indent . '<ul class="dropdown-menu" role="menu">' . "\n";
		}

		public function end_lvl( &$output, $depth = 0, $args = null ) {
			$indent = str_repeat( "\t", $depth );
			$output .= $indent . '</ul>' . "\n";
		}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$indent = str_repeat( "\t", $depth );
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'nav-item';

			if ( in_array( 'menu-item-has-children', $classes, true ) ) {
				$classes[] = 'dropdown';
			}

			if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current_page_item', $classes, true ) ) {
				$classes[] = 'active';
			}

			$class_names = implode( ' ', array_filter( $classes ) );
			$output     .= $indent . '<li class="' . esc_attr( $class_names ) . '">';

			$link_classes = array( 'nav-link' );
			if ( in_array( 'active', $classes, true ) ) {
				$link_classes[] = 'active';
			}
			if ( in_array( 'dropdown', $classes, true ) ) {
				$link_classes[] = 'dropdown-toggle';
			}

			$link_class = implode( ' ', array_filter( $link_classes ) );
			$attributes = ' class="' . esc_attr( $link_class ) . '"';

			if ( in_array( 'dropdown', $classes, true ) ) {
				$attributes .= ' data-bs-toggle="dropdown"';
			}

			if ( in_array( 'active', $classes, true ) ) {
				$attributes .= ' aria-current="page"';
			}

			$output .= '<a' . $attributes . ' href="' . esc_url( $item->url ) . '">';
			$output .= apply_filters( 'the_title', $item->title, $item->ID );
			$output .= '</a>';
		}

		public function end_el( &$output, $item, $depth = 0, $args = null ) {
			$output .= "</li>\n";
		}
	}
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mario_tolvo_portfolio_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on mario_tolvo_portfolio, use a find and replace
		* to change 'mario_tolvo_portfolio' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'mario_tolvo_portfolio', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'mario_tolvo_portfolio' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'mario_tolvo_portfolio_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Disable the block editor for posts and pages.
	add_filter( 'use_block_editor_for_post', '__return_false', 10 );
	add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );
	add_filter( 'gutenberg_can_edit_post_type', '__return_false', 10 );
	add_filter( 'use_widgets_block_editor', '__return_false' );

	// Load ACF JSON field groups from the theme.
	add_filter( 'acf/settings/save_json', function( $path ) {
		return get_template_directory() . '/acf-json';
	} );
	add_filter( 'acf/settings/load_json', function( $paths ) {
		$paths[] = get_template_directory() . '/acf-json';
		return $paths;
	} );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'mario_tolvo_portfolio_setup' );

// Disable Gutenberg editor for posts and pages at the earliest possible hook.
add_filter( 'use_block_editor_for_post', '__return_false', 10 );
add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );
add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
	return in_array( $post_type, array( 'post', 'page' ), true ) ? false : $use_block_editor;
}, 10, 2 );
add_filter( 'gutenberg_can_edit_post_type', '__return_false', 10 );
add_filter( 'use_widgets_block_editor', '__return_false' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mario_tolvo_portfolio_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mario_tolvo_portfolio_content_width', 640 );
}
add_action( 'after_setup_theme', 'mario_tolvo_portfolio_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mario_tolvo_portfolio_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'mario_tolvo_portfolio' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'mario_tolvo_portfolio' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mario_tolvo_portfolio_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mario_tolvo_portfolio_scripts() {
	wp_enqueue_style(
		'mario_tolvo_portfolio-sora',
		'https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap',
		array(),
		null
	);

	$main_css = get_template_directory() . '/dist/assets/main.css';
	if ( file_exists( $main_css ) ) {
		wp_enqueue_style( 'mario_tolvo_portfolio-main', get_template_directory_uri() . '/dist/assets/main.css', array( 'mario_tolvo_portfolio-sora' ), filemtime( $main_css ) );
	} else {
		wp_enqueue_style( 'mario_tolvo_portfolio-style', get_stylesheet_uri(), array( 'mario_tolvo_portfolio-sora' ), _S_VERSION );
		wp_style_add_data( 'mario_tolvo_portfolio-style', 'rtl', 'replace' );
	}

	$main_js = get_template_directory() . '/dist/assets/main.js';
	if ( file_exists( $main_js ) ) {
		wp_enqueue_script( 'mario_tolvo_portfolio-main', get_template_directory_uri() . '/dist/assets/main.js', array(), filemtime( $main_js ), true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mario_tolvo_portfolio_scripts' );

/**
 * Add connection hints for the Google Fonts stylesheet and font files.
 */
function mario_tolvo_portfolio_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'mario_tolvo_portfolio_resource_hints', 10, 2 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Flexible content helpers.
 */
require get_template_directory() . '/inc/flexible-content.php';

/**
 * Custom post types and taxonomies.
 */
require get_template_directory() . '/inc/post-types.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/**
 * Favicon personalizzata MT
 */
function mario_tolvo_custom_favicon() {
    $favicon_url = get_stylesheet_directory_uri()
        . '/assets/logos/mt-favicon/';
    ?>
    <link rel="icon" type="image/x-icon"
          href="<?php echo esc_url($favicon_url . 'favicon.ico'); ?>">

    <link rel="icon" type="image/png" sizes="32x32"
          href="<?php echo esc_url($favicon_url . 'favicon-32.png'); ?>">

    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo esc_url($favicon_url . 'favicon-16.png'); ?>">

    <link rel="apple-touch-icon" sizes="180x180"
          href="<?php echo esc_url($favicon_url . 'apple-touch-icon.png'); ?>">
    <?php
}

remove_action('wp_head', 'wp_site_icon', 99);
add_action('wp_head', 'mario_tolvo_custom_favicon');
