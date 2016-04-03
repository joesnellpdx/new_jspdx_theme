<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package JSPDX Theme
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer section" role="contentinfo">
		<div class="site-info section__inner lc">
			<?php do_action( 'srbt_demo_theme_credits' ); ?>
			<p>Copyright &copy; <?php auto_copyright('2012'); ?> <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
