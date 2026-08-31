<?php
/**
 * Custom post types and taxonomies.
 *
 * @package mario_tolvo_portfolio
 */

/**
 * Register Projects custom post type and related taxonomies.
 */
function mario_tolvo_portfolio_register_projects() {
	$project_labels = array(
		'name'                  => esc_html__( 'Progetti', 'mario_tolvo_portfolio' ),
		'singular_name'         => esc_html__( 'Progetto', 'mario_tolvo_portfolio' ),
		'menu_name'             => esc_html__( 'Progetti', 'mario_tolvo_portfolio' ),
		'name_admin_bar'        => esc_html__( 'Progetto', 'mario_tolvo_portfolio' ),
		'add_new'               => esc_html__( 'Aggiungi nuovo', 'mario_tolvo_portfolio' ),
		'add_new_item'          => esc_html__( 'Aggiungi nuovo progetto', 'mario_tolvo_portfolio' ),
		'new_item'              => esc_html__( 'Nuovo progetto', 'mario_tolvo_portfolio' ),
		'edit_item'             => esc_html__( 'Modifica progetto', 'mario_tolvo_portfolio' ),
		'view_item'             => esc_html__( 'Vedi progetto', 'mario_tolvo_portfolio' ),
		'all_items'             => esc_html__( 'Tutti i progetti', 'mario_tolvo_portfolio' ),
		'search_items'          => esc_html__( 'Cerca progetti', 'mario_tolvo_portfolio' ),
		'not_found'             => esc_html__( 'Nessun progetto trovato.', 'mario_tolvo_portfolio' ),
		'not_found_in_trash'    => esc_html__( 'Nessun progetto trovato nel cestino.', 'mario_tolvo_portfolio' ),
		'featured_image'        => esc_html__( 'Featured image progetto', 'mario_tolvo_portfolio' ),
		'set_featured_image'    => esc_html__( 'Imposta featured image', 'mario_tolvo_portfolio' ),
		'remove_featured_image' => esc_html__( 'Rimuovi featured image', 'mario_tolvo_portfolio' ),
		'use_featured_image'    => esc_html__( 'Usa come featured image', 'mario_tolvo_portfolio' ),
	);

	register_post_type(
		'progetto',
		array(
			'labels'             => $project_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'progetti' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-portfolio',
			'supports'           => array( 'title', 'thumbnail' ),
			'taxonomies'         => array( 'categoria_progetto', 'tecnologia' ),
		)
	);

	register_taxonomy(
		'categoria_progetto',
		array( 'progetto' ),
		array(
			'labels'            => array(
				'name'              => esc_html__( 'Categorie Progetti', 'mario_tolvo_portfolio' ),
				'singular_name'     => esc_html__( 'Categoria Progetto', 'mario_tolvo_portfolio' ),
				'search_items'      => esc_html__( 'Cerca categorie progetto', 'mario_tolvo_portfolio' ),
				'all_items'         => esc_html__( 'Tutte le categorie progetto', 'mario_tolvo_portfolio' ),
				'parent_item'       => esc_html__( 'Categoria genitore', 'mario_tolvo_portfolio' ),
				'parent_item_colon' => esc_html__( 'Categoria genitore:', 'mario_tolvo_portfolio' ),
				'edit_item'         => esc_html__( 'Modifica categoria progetto', 'mario_tolvo_portfolio' ),
				'update_item'       => esc_html__( 'Aggiorna categoria progetto', 'mario_tolvo_portfolio' ),
				'add_new_item'      => esc_html__( 'Aggiungi nuova categoria progetto', 'mario_tolvo_portfolio' ),
				'new_item_name'     => esc_html__( 'Nome nuova categoria progetto', 'mario_tolvo_portfolio' ),
				'menu_name'         => esc_html__( 'Categorie Progetti', 'mario_tolvo_portfolio' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'categorie-progetti' ),
		)
	);

	register_taxonomy(
		'tecnologia',
		array( 'progetto' ),
		array(
			'labels'            => array(
				'name'                       => esc_html__( 'Tecnologie', 'mario_tolvo_portfolio' ),
				'singular_name'              => esc_html__( 'Tecnologia', 'mario_tolvo_portfolio' ),
				'search_items'               => esc_html__( 'Cerca tecnologie', 'mario_tolvo_portfolio' ),
				'popular_items'              => esc_html__( 'Tecnologie più usate', 'mario_tolvo_portfolio' ),
				'all_items'                  => esc_html__( 'Tutte le tecnologie', 'mario_tolvo_portfolio' ),
				'edit_item'                  => esc_html__( 'Modifica tecnologia', 'mario_tolvo_portfolio' ),
				'update_item'                => esc_html__( 'Aggiorna tecnologia', 'mario_tolvo_portfolio' ),
				'add_new_item'               => esc_html__( 'Aggiungi nuova tecnologia', 'mario_tolvo_portfolio' ),
				'new_item_name'              => esc_html__( 'Nome nuova tecnologia', 'mario_tolvo_portfolio' ),
				'separate_items_with_commas' => esc_html__( 'Separa le tecnologie con virgole', 'mario_tolvo_portfolio' ),
				'add_or_remove_items'        => esc_html__( 'Aggiungi o rimuovi tecnologie', 'mario_tolvo_portfolio' ),
				'choose_from_most_used'      => esc_html__( 'Scegli tra le tecnologie più usate', 'mario_tolvo_portfolio' ),
				'menu_name'                  => esc_html__( 'Tecnologie', 'mario_tolvo_portfolio' ),
			),
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'tecnologie' ),
		)
	);
}
add_action( 'init', 'mario_tolvo_portfolio_register_projects' );

/**
 * Create the default project taxonomy terms from the project brief.
 */
function mario_tolvo_portfolio_insert_default_project_terms() {
	$default_terms = array(
		'categoria_progetto' => array(
			'Sito Corporate',
			'E-commerce',
			'Blog / Magazine',
			'Landing Page',
			'Web App',
			'Altro',
		),
		'tecnologia'         => array(
			'WordPress',
			'PHP',
			'JavaScript',
			'React',
			'Laravel',
			'Shopify',
			'SCSS / CSS',
			'MySQL',
			'GSAP',
			'ACF',
			'Elementor',
			'Avada',
			'WooCommerce',
			'Altro',
		),
	);

	foreach ( $default_terms as $taxonomy => $terms ) {
		foreach ( $terms as $term_name ) {
			if ( ! term_exists( $term_name, $taxonomy ) ) {
				wp_insert_term( $term_name, $taxonomy );
			}
		}
	}
}
add_action( 'init', 'mario_tolvo_portfolio_insert_default_project_terms', 20 );

/**
 * Flush permalinks when switching to this theme so the new archive/single URLs work.
 */
function mario_tolvo_portfolio_rewrite_flush() {
	mario_tolvo_portfolio_register_projects();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'mario_tolvo_portfolio_rewrite_flush' );
