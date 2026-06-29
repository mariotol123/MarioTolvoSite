<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mario_tolvo_portfolio
 */

?>

	<footer id="colophon" class="site-footer py-4 mt-5">
		<div class="container">
			<div class="site-info text-muted small">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'mario_tolvo_portfolio' ) ); ?>">
					<?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'mario_tolvo_portfolio' ), 'WordPress' );
					?>
				</a>
				<span class="mx-2">|</span>
				<?php
				printf( esc_html__( 'Theme: %s', 'mario_tolvo_portfolio' ), esc_html( wp_get_theme()->get( 'Name' ) ) );
				?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
