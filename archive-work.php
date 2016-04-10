<?php
/**
 * The template for displaying archive pages.
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

						<div class="blog-contain section__inner-content g-flex g g-3up" data-postype="work">
							<?php echo post_type_ajax_view_function(); ?>
						</div> <!-- section-content -->

					</div>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();