<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package JSPDX Theme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<header class="entry-header">
				<div class="section__inner lc">
					<h1 class="entry-title title"><?php esc_html_e( 'I really want to do something fun on my 404 page... but time! Grrr.', 'jspdx_theme' ); ?></h1>
				</div>
			</header><!-- .page-header -->

			<section id="content" class="error-404 not-found content-wrapper">


				<div id="section-1" class="entry-content section section--page">
					<div class="section__inner lc">
					<p><?php esc_html_e( 'Bummer you can\'t find what you are looking for or... don\'t say it... something\'s broken? Try back at the home page or search for something below. Sorry!', 'jspdx_theme' ); ?></p>

					<?php
						get_search_form();
					?>




					</div>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
