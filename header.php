<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package JSPDX Theme
 */

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'jspdx_theme' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<a class="site-branding__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<div class="logo">
					<figure class="fixedratio jspdx-icon-logo" title="<?php bloginfo( 'name' ); ?>"></figure>
				</div>
			</a>
			<a class="site-branding__title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<span class="site-title"><?php bloginfo( 'name' ); ?></span>
				<?php $description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<sep>|</sep> <span class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></span>
				<?php
				endif; ?>
			</a>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<a id="nav-open-btn" class="main-nav-trigger" href="#site-navigation" aria-controls="primary-menu">
				<button type="button" class="tcon tcon-menu--xbutterfly" aria-label="toggle menu">
					<span class="tcon-menu__lines" aria-hidden="true"></span>
					<span class="tcon-visuallyhidden"><?php esc_html_e( 'Primary Menu', 'jspdx_theme' ); ?></span>
				</button>
			</a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
