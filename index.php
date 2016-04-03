<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package JSPDX Theme
 */

get_header(); ?>

	<div id="primary" class="content-area">
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
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
