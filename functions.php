<?php

/**
 * Implement theme functions.
 */
require get_template_directory() . '/inc/theme-functions.php';

/**
 * Implement custom functions.
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Implement page content functions.
 */
require get_template_directory() . '/inc/custom-page-content.php';

/**
 * Implement post types.
 */
require get_template_directory() . '/inc/funct-work.php';

/**
 * Implement page hero functions.
 */
require get_template_directory() . '/inc/custom-page-hero.php';

/**
 * Implement shortcode functions.
 */
require get_template_directory() . '/inc/funct-shortcodes.php';

/**
 * Implement custom form functions.
 */
require get_template_directory() . '/inc/custom-form-functions.php';
