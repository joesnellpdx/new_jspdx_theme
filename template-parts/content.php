<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package JSPDX Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php echo page_hero(); ?>
	<div id="content" class="content-wrapper">

		<section id="section-1" class="entry-content section section--post">
			<div class="section__inner lc">
				<div class="section__content">
				   <?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php jspdx_theme_posted_on(); ?>
					</div><!-- .entry-meta -->
					<?php
					endif; ?>

						<?php
						the_content( sprintf(
						/* translators: %s: Name of current post. */
							wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'jspdx_theme' ), array( 'span' => array( 'class' => array() ) ) ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						) );

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jspdx_theme' ),
							'after'  => '</div>',
						) );
						?>

				</div>
			</div>
		</section>
		<footer class="entry-footer">
			<div class="entry-footer__inner lc">
				<?php jspdx_theme_entry_footer(); ?>
			</div>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
