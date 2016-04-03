<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package JSPDX Theme
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			echo page_hero(); ?>

			<section id="content" class="content-wrapper">

				<div id="section-1" class="entry-content section section--page">
					<div class="section__inner lc">

						<?php if ( have_posts() ) : ?>

						<div class="post-wrap g-flex g g-3up" >

							<?php
							/* Start the Loop */
							$i = '';
							while ( have_posts() ) : the_post();
								$i ++;
								$wide_vars = array(1, 4);
								if(in_array($i, $wide_vars)){
									$size_class = ' gi-2-3';
								} else {
									$size_class = '';
								}
								posts_view_function($i);


							endwhile; ?>
						</div>

					</div>
				</div>
			</section>

			<div class="page-extras lc">

				<?php the_posts_navigation( array(
					'prev_text' => __( 'Older', 'textdomain' ),
					'next_text' => __( 'Newer', 'textdomain' ),
				) );

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
//get_sidebar();
get_footer();
