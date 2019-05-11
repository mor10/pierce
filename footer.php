<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

wp_rig()->print_styles( 'wp-rig-footer' );

?>

	<footer id="colophon" class="site-footer">
		<?php
		if ( wp_rig()->is_secondary_sidebar_active() ) {
			echo '<aside class="site-footer__widgets">';
			wp_rig()->display_secondary_sidebar();
			echo '</aside>';
		}
		?>
		<?php get_template_part( 'template-parts/footer/info' ); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
