<?php
/**
 * Flexible content rendering helpers.
 *
 * @package mario_tolvo_portfolio
 */

if ( ! function_exists( 'mario_tolvo_portfolio_render_flexible_content' ) ) {
	/**
	 * Render flexible content blocks from ACF.
	 */
	function mario_tolvo_portfolio_render_flexible_content() {
		if ( ! function_exists( 'have_rows' ) || ! function_exists( 'the_row' ) ) {
			return;
		}

		if ( have_rows( 'content_blocks' ) ) {
			while ( have_rows( 'content_blocks' ) ) {
				the_row();
				$layout = get_row_layout();

				if ( 'hero' === $layout ) {
					get_template_part( 'template-parts/blocks/hero' );
				} elseif ( 'skills' === $layout ) {
					get_template_part( 'template-parts/blocks/skills' );
				} elseif ( 'text_image' === $layout ) {
					get_template_part( 'template-parts/blocks/text-image' );
				} elseif ( 'contact' === $layout ) {
					get_template_part( 'template-parts/blocks/contact' );
				} elseif ( 'cta_banner' === $layout ) {
					get_template_part( 'template-parts/blocks/cta-banner' );
				} elseif ( 'projects_grid' === $layout ) {
					get_template_part( 'template-parts/blocks/projects-grid' );
				}
			}
		}
	}
}
