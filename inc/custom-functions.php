<?php

/**
 * JSPDX Theme custom functions and definitions.
 *
 * @package JSPDX Theme
 */

/**
 * Gravity forms scroll to form on confirmation
 */
add_filter( 'gform_confirmation_anchor', '__return_true' );

function gruntscript_to_head_function(){

	$gicon_load_path = '/../assets/grunticon/output/grunticon.loader-file.js';

	if (file_exists(dirname(__FILE__) .$gicon_load_path )){
		$gruntscript = file_get_contents(realpath(dirname(__FILE__) . "/../assets/grunticon/output/grunticon.loader-file.js"));

		if(!empty($gruntscript)) {

			$html = '';
			$html .= '<script>';
			$html .= $gruntscript;
			$html .= 'grunticon(["' . get_stylesheet_directory_uri() . '/assets/grunticon/output/icons.data.svg.css", "' . get_stylesheet_directory_uri() . '/assets/grunticon/output/icons.data.png.css", "' . get_stylesheet_directory_uri() . '/assets/grunticon/output/icons.fallback.css"], grunticon.svgLoadedCallback);';
			$html .= '</script>';
			$html .= '<noscript><link href="' . get_stylesheet_directory_uri() . '/assets/grunticon/output/icons.fallback.css" rel="stylesheet"></noscript>';


			echo $html;
		}
	}
}
add_action('wp_head','gruntscript_to_head_function');

/**
 * Disable open graph in jetpack > conflicts with wordpress seo by Yoast
 */
add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );

/**
 * Fix shortcodes
 */
function jspdx_fix_shortcodes($content){
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $array);
	return $content;
}
add_filter('the_content', 'jspdx_fix_shortcodes');

/**
 * Remove image links
 */
function attachment_image_link_remove_filter( $content ) {
	if( !is_singular( 'talent-profile' ) ) {
		$content = preg_replace(
			array(
				'{<a(.*?)(wp-att|wp-content/uploads)[^>]*><img}',
				'{ wp-image-[0-9]*" /></a>}'
			),
			array( '<img', '" />' ),
			$content
		);

		return $content;
	}
}
add_filter( 'the_content', 'attachment_image_link_remove_filter' );

/**
 * Add body classes
 */
function page_bodyclass() {  // add class to <body> tag
	global $wp_query;
	$page = '';
	if (is_front_page() ) {
		$page = 'home';
	} elseif (is_page()) {
		$page = $wp_query->query_vars["pagename"];
	}
	if ($page)
		echo 'class= "'. $page. '"';
}
function add_body_class( $classes ){
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter( 'body_class', 'add_body_class' );

/**
 * Embed video function - add video class
 */
function my_embed_oembed_html($html, $url, $attr, $post_id) {
	return '<div class="jspdx-video">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);

/**
 * Add youtube video parameters to default embed code
 */
function remove_youtube_controls($code){
	if(strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false){
		$return = preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&modestbranding=1&origin=" . get_bloginfo('url') . "&showinfo=0&rel=0", $code);
		return $return;
	}
	return $code;
}

/**
 * Get youtube video ID from URL
 */
function youtube_id_from_url($url) {
	$pattern =
		'%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
	;
	$result = preg_match($pattern, $url, $matches);
	if (false !== $result) {
		return $matches[1];
	}
	return false;
}

/**
 * Insert Page Heading
 */
function insert_page_heading(){

	$hero = '';
	$title = '';

	global $post, $wp_query;
	if(is_home()){
		$the_page_id = $wp_query->queried_object->ID;
	} else {
		$the_page_id = $post->ID;
	}

	$h_title = get_post_meta( $the_page_id, '_hero_title', true );
	$h_subtitle = get_post_meta( $the_page_id, '_hero_subtitle', true );

	if(!$h_title){
		$title .= get_the_title($the_page_id);
	} else {
		$title .= $h_title;

	}
	$title_class = '';

	if(!empty($h_subtitle)){
		$sub_title .= '<span class="title__subheading">' . $h_subtitle . '</span>';
	} else {
		$sub_title = '';
	}

	if ( is_category() ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Category: ' . $add_icon . single_cat_title
			("", false) .
			'</h1>';

	elseif ( is_tag() ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Tag: ' . $add_icon . single_tag_title("", false) . '</h1>';

	elseif ( is_author("", false) ) :
		/* Queue the first post, that way we know
		 * what author we're dealing with (if that is the case).
		*/
		the_post();
		$hero .= '<h1 class="entry-title title' . $title_class . '">Author: ' . $add_icon . get_the_author() . '</h1>';

		/* Since we called the_post() above, we need to
		 * rewind the loop back to the beginning that way
		 * we can run the loop properly, in full.
		 */
		rewind_posts();

	elseif ( is_day() ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Archive: ' . $add_icon . get_the_date() . '</h1>';

	elseif ( is_month() ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Archive: ' . $add_icon . get_the_date('F Y') . '</h1>';

	elseif ( is_year() ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Archive: ' . $add_icon . get_the_date( 'Y' ) . '</h1>';

	elseif ( is_search() ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Search: ' . $add_icon . get_search_query() . '</h1>';

	elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Asides</h1>';

	elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Images</h1>';

	elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Videos</h1>';

	elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Quotes</h1>';

	elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Links</h1>';

	elseif ( is_tax() ) :
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$hero .= '<h1 class="entry-title title' . $title_class . '">' . $add_icon . $term->name . '</h1>';

	elseif( is_post_type_archive()) :
		$hero .= '<h1 class="entry-title title' . $title_class . '">Archive: ' . $add_icon . post_type_archive_title("", false) . '</h1>';

	else :
		$hero .= '<h1 class="entry-title title' . $title_class . '">' . $add_icon . $title . $sub_title . '</h1>';

	endif;

	return $hero;

}

/**
 * Remove Read More Jump Link
 */
function jspdx_remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}

/**
 * Primary Nav Walker
 */
class jspdx_walker extends Walker_Nav_Menu {
//	function start_lvl( &$output, $depth = 0, $args = array() ) {
//		$output .= "\n" . $indent . '<ul class="sub-menu"><li class="sub-menu-close"><a class="sub-menu-close-link" href="#outer-wrap"><i class="sr-icon-close3"></i></a></li>' . "\n";
//	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<div class='sub-menu-wrap'><ul class='sub-menu'>\n";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div>\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="nav-menu__item ' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		if ( ('primary' == $args->theme_location) || ('secondary' == $args->theme_location) ) {
			$submenus = 0 == $depth || 1 == $depth ? get_posts( array( 'post_type' => 'nav_menu_item', 'numberposts' => 1, 'meta_query' => array( array( 'key' => '_menu_item_menu_item_parent', 'value' => $item->ID, 'fields' => 'ids' ) ) ) ) : false;
			$output .= $indent . '<li' . $id . $value . $class_names .' aria-haspopup="true">';

		} else {

			$output .= $indent . '<li' . $id . $value . $class_names .'>';
			$attributes = '';
		}

		$attributes  .= ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$submenus = 0 == $depth || 1 == $depth ? get_posts( array( 'post_type' => 'nav_menu_item', 'numberposts' => 1, 'meta_query' => array( array( 'key' => '_menu_item_menu_item_parent', 'value' => $item->ID, 'fields' => 'ids' ) ) ) ) : false;

		if(!empty($submenus)){
			if($depth == 0){
				$link_class .= ' nav-menu__link--parent';
			} elseif ($depth == 1){
				$link_class .= ' nav-menu__link--parent-sub';
			} else {
				$link_class = '';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a class="nav-menu__link' . $link_class . '" '. $attributes .'><span>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

		if ( ('primary' == $args->theme_location) || ('secondary' == $args->theme_location) ) {
			$item_output .= ! empty( $submenus ) ? ( 1 >= $depth ? '</span><i class="sr-icon-arrow-right5"></i>' : '' ) : '';
			$item_output .= '</a>';
		} else {
			$item_output .= '</span></a>';
		}
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**
 * Social menu walker - icons
 */
class Social_Icon_Menu extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$output .= $indent . '<div id="menu-item-'. $item->ID . '"' . $value .' class="social-icon-reorder-item">';

		$item_output = $args->before;
		$item_output .= $args->link_before;

		$item_output .='<a class="menu_item_wrapper" title="'. $item->post_name .'" href="'. $item->url .'" target="_blank">';
		$item_output .='<i class="'. $item->classes[0] .'"></i>';
		$item_output .='</a>';

		$item_output .= $args->link_after;
		$item_output .= $args->after;

		$item_output .= '</div>';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
	}
}

/**
 * Add parent menu item class
 */
function add_menu_parent_class( $items ) {
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'menu-parent-item';
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );

/**
 * Add search box to menu
 */
//function add_search_box_to_menu( $items, $args ) {
//	if( $args->theme_location == 'secondary' ) {
//		$html = '';
//		$html .= '<li class="nav-menu__item nav-menu__search menu-item ">';
//		$html .= '<a class="nav-menu__link nav-menu__link--parent nav-menu__link--parent-search"><span>Search</span><i class="sr-icon-arrow-right5"></i></a>';
//		$html .= '<div class="sub-menu-wrap">';
//		$html .= '<ul class="sub-menu">';
//		$html .= '<li class="nav-menu__item menu-item">';
//		$html .= get_search_form( false );
//		$html .= '</li>';
//		$html .= '</ul>';
//		$html .= '</div>';
//		$html .= '</li>';
//		$html .= $items;
//		return $html ;
//	}
//
//	return $items;
//}
//add_filter('wp_nav_menu_items','add_search_box_to_menu', 10, 2);

/**
 * Allow SVG Uploads
 */
function custom_upload_mimes ( $existing_mimes=array() ) {
	$existing_mimes['svg'] = 'mime/type';
	return $existing_mimes;
}
add_filter('upload_mimes', 'custom_upload_mimes');

/**
 * Add custom admin logo
 */
// custom admin login logo
function custom_login_logo() {
	echo '<style type="text/css">
	#login h1 a { background: transparent url('.get_bloginfo('stylesheet_directory').'/assets/images/custom-login-logo.png);background-repeat: no-repeat;
background-size: contain;
background-position: center;width:100%; }
	</style>';
}
add_action('login_head', 'custom_login_logo');

/**
 * Flushe rewrite rules on every page to make sure changes take
 * DO NOT KEEP ACTIVE
 */
function flushRules(){
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
// add_filter('wp_loaded','flushRules');

/**
 * UTILITY FUNCTIONS
 */

/**
 * Get ID by slug
 */
function get_ID_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

/**
 * Get topmost parent
 */
function get_topmost_parent($post_id){
	$parent_id = get_post($post_id)->post_parent;
	if($parent_id == 0){
		return $post_id;
	}else{
		return get_topmost_parent($parent_id);
	}
}

/**
 * Truncate functions
 */
function truncate ($str, $length=10, $trailing='...') {
	/*
	** $str -String to truncate
	** $length - length to truncate
	** $trailing - the trailing character, default: "..."
	*/

	// take off chars for the trailing
	$length-=mb_strlen($trailing);
	if (mb_strlen($str)> $length)
	{
		// string exceeded length, truncate and add trailing dots
		return mb_substr($str,0,$length).$trailing;
	}
	else
	{
		// string was already short enough, return the string
		$res = $str;
	}
	return $res;
}

function jspdx_truncate($string, $width, $trailing='...') {
	$mywords = explode(" ", $string);
	$finalstring = "";
	foreach($mywords as $word) {
		if(strlen($finalstring) <= $width) {
			$finalstring = $finalstring . " " . $word;
		} else {
			$finalstring = $finalstring . $trailing;
			break;
		}
	}
	return $finalstring;
}

function sentenceTruncate($string, $limit, $break=".", $pad="...") {
	// return with no change if string is shorter than $limit
	if(strlen($string) <= $limit) return $string;

	// is $break present between $limit and the end of the string?
	if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		if($breakpoint < strlen($string) - 1) {
			$string = substr($string, 0, $breakpoint + 1) . $pad;
		}
	}

	return $string;
}

/**
 * Customize search form
 */
function my_search_form( $form ) {
	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __( 'Search for:' ) . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Search" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__( '&#xe922;' ) .'" />
    </div>
    </form>';

	return $form;
}
add_filter( 'get_search_form', 'my_search_form' );

/**
 * New excerpt more
 */
function new_excerpt_more($more) {
	global $post;
	return ' ...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/**
 * Excerpt length
 */
function custom_excerpt_length( $length ) {
	return 85;
}
// add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Auto copyright
 */
function auto_copyright($year = 'auto'){
	if(intval($year) == 'auto'){ $year = date('Y'); }
	if(intval($year) == date('Y')){ echo intval($year); }
	if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); }
	if(intval($year) > date('Y')){ echo date('Y'); }
}

/**
 * Get image ID from URL
 */
function get_attachment_id_from_src($url) {
	global $wpdb;
	$prefix = $wpdb->prefix;

	if (strpos($url, 'http') === 0) {
		$img_source = $url;
	} else {
		$img_source = site_url() . $url;
	}

	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $img_source ));
	return $attachment[0];
}

/**
 * CMB2 Metabox Bootstrap Function - Get the bootstrap!
 */
if ( file_exists(  __DIR__ . '/cmb2/init.php' ) ) {
	require_once  __DIR__ . '/cmb2/init.php';
} elseif ( file_exists(  __DIR__ . '/CMB2/init.php' ) ) {
	require_once  __DIR__ . '/CMB2/init.php';
}

/**
 * Filter Yoast Meta Priority - move below meta boxes
 */
add_filter( 'wpseo_metabox_prio', function() { return 'low';});

/**
 * Image compression to fo with the RICG plugin
 */
function custom_theme_setup() {
	add_theme_support( 'advanced-image-compression' );
}
add_action( 'after_setup_theme', 'custom_theme_setup' );

add_filter("gform_submit_button", "form_submit_button", 10, 2);
function form_submit_button($button, $form){
	return "<p class='btn-wrap text-center'><button class='gform-submit button btn btn-primary' id='gform_submit_button_{$form["id"]}' type='submit'><span>Submit</span></button></p>";
}

/**
 * Sanitize text field in CMB2 Metabox
 */
function jspdx_sanitize_text_callback( $value, $field_args, $field ) {

	$value = strip_tags( $value, '<p><a><br><br/><span><strong><small>' );

	return $value;
}