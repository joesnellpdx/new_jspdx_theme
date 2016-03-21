<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package JSPDX Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php echo page_hero(); ?>

	<section id="section-1" class="entry-content section section--page">
		<div class="section__inner lc">
		<?php
			$p_title = get_post_meta( get_the_id(), '_psect_title', true );

			if(!empty($p_title)){ ?>
				<h1 class="section__title"><?php echo $p_title; ?></h1>
			<?php }
			?>

				<div class="section__content">

			<?php

			the_content();

			?>
				</div>
			<?php

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jspdx_theme' ),
				'after'  => '</div>',
			) );
		?>
		</div>
	</section><!-- .entry-content -->

	<?php echo content_areas(); ?>

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'jspdx_theme' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
