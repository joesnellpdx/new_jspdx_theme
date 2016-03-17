<?php

/**
 * JSPDX Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package JSPDX Theme
 */

if ( ! function_exists( 'jspdx_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function jspdx_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on JSPDX Theme, use a find and replace
		 * to change 'jspdx_theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'jspdx_theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'post-thumbnails' );
			set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions
		}

		/**
		 * Custom Image Sizes
		 */
		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'rwd-small', 400, 200 );
			add_image_size( 'rwd-medium', 800, 400 );
			add_image_size( 'rwd-large', 1200, 600 );
			add_image_size( 'rwd-mediumx2', 1600, 800 );
			add_image_size( 'rwd-xl', 2000, 1000 );
			add_image_size( 'rwd-largex2', 2400, 1200 );
			add_image_size( 'rwd-xlx2', 4000, 2000 );
		}

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'jspdx_theme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'jspdx_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		/**
		 * Add ie conditional html5 shim to header
		 */
		function add_ie_html5_shim () {
			echo '<!--[if lt IE 9]>';
			echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
			echo '<![endif]-->';
		}
		add_action('wp_head', 'add_ie_html5_shim');

		/**
		 * Add custom fonts
		 */
		function add_custom_fonts(){
//		echo '<link href="http://fonts.googleapis.com/css?family=Raleway:400,700|Open+Sans:300italic,600italic,600,300" rel="stylesheet" type="text/css">';
//	echo '<link rel="stylesheet" href="">';
		}
		add_action('wp_head', 'add_custom_fonts');
	}
endif;
add_action( 'after_setup_theme', 'jspdx_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jspdx_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'jspdx_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'jspdx_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jspdx_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'jspdx_theme' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer', 'jspdx_theme' ),
		'id'            => 'footer-main',
		'class'			=> 'footer-main',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'jspdx_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jspdx_theme_scripts() {
	wp_enqueue_style( 'srbt_theme-style', get_stylesheet_directory_uri().'/style.css', null, '1.0', 'all' );

//	wp_enqueue_script( 'jspdx_theme-navigation', get_template_directory_uri() . '/assets/js/vendor/navigation.js', array(), '20151215', true );
//
//	wp_enqueue_script( 'jspdx_theme-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/vendor/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( !is_admin() ) {
		wp_enqueue_script('modernizr-custom', get_template_directory_uri() . '/assets/js/vendor/modernizr-custom.min.js', false, '2.7.2' );
		wp_enqueue_script('sr_scripts', get_template_directory_uri() . '/assets/js/init.min.js', array('jquery'), NULL, true );
	}
}
add_action( 'wp_enqueue_scripts', 'jspdx_theme_scripts' );

function load_custom_wp_admin_style(){
	wp_enqueue_style( 'sr-admin-css', get_template_directory_uri() . '/style--admin.css' );
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');

/**
 * Remove actions
 */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

