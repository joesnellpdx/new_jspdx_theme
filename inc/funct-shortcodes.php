<?php
/**
 * JSPDX Theme shortcode functions.
 *
 * @package JSPDX Theme
 */

/**
 * Add shortcode functionality to widget areas
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Gridcontainer shortcode
 */
function gridcontainer( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'class' => '',
		'columns' => '3'
	), $atts));

	return '<div class="'. $class .' g g-' . $columns . 'up">' . do_shortcode($content) . '</div>';
}
add_shortcode('grid_wrap', 'gridcontainer');

/**
 * Gridflex container shortcode (flexbox)
 */
function gridflexcontainer( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'class' => '',
		'columns' => '3'
	), $atts));

	return '<div class="'. $class .' g g-' . $columns . 'up g-flex">' . do_shortcode($content) . '</div>';
}
add_shortcode('grid_flex', 'gridflexcontainer');

/**
 * Nested-grid shortcode
 */
function inner_grid_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'class' => '',
		'columns' => '3'
	), $atts));

	return '<div class="inner-grid '. $class .' g g-' . $columns . 'up">' . do_shortcode($content) . '</div>';
}
add_shortcode('inner_grid', 'inner_grid_shortcode');

/**
 * Grid item shortcode
 */
function griditem_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'class' => '',
		'title' => '',
	), $atts));

	$html = '';
	$html .= '<div class="gi '. $class .'">';
	if(!empty($title)){
		$html .= '<h2 class="title__gi gamma">' . $title . '</h2>';
	}
	$html  .= do_shortcode($content);
	$html .= '</div>';

	return $html;
}
add_shortcode('grid_item', 'griditem_shortcode');

/**
 * Flexbox grid container shortcode
 */
function flexcontainer( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'class' => '',
	), $atts));

	if(!empty($class)){
		$class = ' flex-wrap--' . $class;
	} else {
		$class = '';
	}

	return '<div class="flex-wrap-contain"><div class="flex-wrap' . $class . '">' . do_shortcode($content) . '</div></div>';
}
add_shortcode('flex_wrap', 'flexcontainer');

/**
 * Flexbox grid item shortcode
 */
function flexitem_shortcode( $atts ) {

	extract(shortcode_atts(array(
		'class' => 'md-half',
	), $atts));

	return '<div class="flex-item flex-item--' . $class . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('flex_item', 'flexitem_shortcode');

/**
 * Meta block shortcode
 */
function meta_block_shortcode( $atts, $content ) {

	extract(shortcode_atts(array(
		'class' => '',
	), $atts));

	return '<div class="meta-block">' . do_shortcode($content) . '</div>';
}
add_shortcode('meta_block', 'meta_block_shortcode');

/**
 * Button shortcode
 */
function jspdx_button_shorcode( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link'	=> '#',
		'target'	=> '',
		'class'	=> 'primary',
		'size'	=> '',
		'align'	=> '',
	), $atts));

	//		$style = ($class) ? ' '.$class. ' ' : '';
	$align = ($align) ? ' btn__contain--'.$align : '';
	$size = (!empty($size)) ? ' btn-' . $size : '';
	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$link_content = do_shortcode($content);

	$out = '';
	$out .= '<p class="btn-contain"><a' .$target. ' class="btn btn--' . $class . ' ' .$size. '" href="' .$link. '">' .$link_content. '</a></p>';

	return $out;
}
add_shortcode('button', 'jspdx_button_shorcode');

/**
 * Blockquote shortcode
 */
function blockquote_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'class' => '',
		'align' => '',
	), $atts));

	if(empty($class)){
		$class = '';
	}

	if(!empty($align)){
		$class = $class . ' quote-align quote-align--' . $align;
	}
	$return_html = '<blockquote class="' . $class . '">'.do_shortcode($content).'</blockquote>';

	return $return_html;
}
add_shortcode('quote', 'blockquote_shortcode');

/**
 * Cite shortcode
 */
function cite_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'name' => '',
		'title' => '',
	), $atts));

	$return_html = '';
	if(!empty($name)) {
		$return_html .= '<cite class="cite">';
		$return_html .= '<span class="cite__name">' . $name . '</span>';
		if(!empty($title)) {
			$return_html .= '<span class="cite__title">' . $title . '</span>';
		}
		$return_html .= '</cite>';
	}

	return $return_html;
}
add_shortcode('cite', 'cite_shortcode');

/**
 * Bubble shortcode
 */
function bubble_func($atts, $content) {
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'align' => '',
		'size' => '',
		'icon' => '',
		'class' => '',
		'linktext' => 'Learn More',
		'style' => '',
		'target' => '',
	), $atts));

	$return_html = '';

	if(!empty($target) && (($target == 'blank') || ($target == '_blank'))){
		$targ = 'target="_blank"';
	} else {
		$targ = '';
	}

	if(!empty($link)){
		$link_class = 'bubble-cta__has-link';
	}
	if(!empty($style)){
		$style_class = 'bubble-cta__' . $style;
	} else {
		$style_class = 'bubble-cta';
	}

	$return_html .= '<div class="' . $style_class . ' '.$align.' '.$size.' ' . $link_class . ' gi">';
	$return_html .= '<div class="gi--inner">';
	if(!empty($icon)){
		$return_html .= '<i class="' . $style_class . '--icon '. $icon .'"></i>';
	}
	$return_html .= '<div class="' . $style_class . '--content">';
	if(!empty($title)){
		$return_html .= '<h3 class="' . $style_class . '--title'.$class.'">'.$title.'</h3>';
	}

	$return_html .= do_shortcode($content);


	if (!empty($link)){
		//		$return_html .= '<div class="bubble-cta--linkcontain button-contain">';
		$return_html .= '<a class="bubble-cta--link ' . $style_class . '--link" href="'. $link .'"  ' . $targ . '>' . $linktext . '</a>';
	}

	$return_html .= '</div>';
	$return_html .= '</div>';
	$return_html .= '</div>';

	return $return_html;
}
add_shortcode('bubble', 'bubble_func');

/**
 * Block shortcode
 */
function block_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'align' => '',
		'size' => '',
		'icon' => '',
		'class' => '',
		'linktext' => 'Learn More',
		'style' => '',
		'target' => '',
	), $atts));

	$return_html = '';

	if(!empty($target) && (($target == 'blank') || ($target == '_blank'))){
		$targ = 'target="_blank"';
	} else {
		$targ = '';
	}

	if(!empty($link)){
		$link_class = 'block--link';
	}
	if(!empty($style)){
		$style_class = 'block--' . $style;
	} else {
		$style_class = 'block';
	}

	$return_html .= '<div class="' . $style_class . ' '.$align.' '.$size.' ' . $link_class . ' gi">';
	if(!empty($icon)){
		$return_html .= '<i class="' . $style_class . '__icon '. $icon .'"></i>';
	}
	$return_html .= '<div class="' . $style_class . '__content">';
	if(!empty($title)){
		$return_html .= '<h3 class="title__gi ' . $style_class . '__title'.$class.'">'.$title.'</h3>';
	}

	$return_html .= do_shortcode($content);


	if (!empty($link)){
		//		$return_html .= '<div class="block-cta--linkcontain button-contain">';
		$return_html .= '<a class="block__link ' . $style_class . '__link" href="'. $link .'"  ' . $targ . '>' . $linktext . '</a>';
	}

	$return_html .= '</div>';
	$return_html .= '</div>';

	return $return_html;
}
add_shortcode('block', 'block_shortcode');

/**
 * Background image shortcode
 */
function responsive_image_inline_bg($atts, $content){

	extract( shortcode_atts( array(
		'id' => '',
		'src' => '',
		'caption' => '',
		'container' => '',
	), $atts ) );

	$container_class = '.' . $container;

	if($id != '') {
		$img_ID = $id;
	} else {
		$img_ID = get_attachment_id_from_src($src);
	}

	// $img_ID = get_attachment_id_from_src($src);


	$image_small = wp_get_attachment_image_src( $img_ID, 'rwd-small' );
	$image_smallx2 = wp_get_attachment_image_src( $img_ID, 'rwd-medium' );
	$image_medium = wp_get_attachment_image_src( $img_ID, 'rwd-medium' );
	$image_mediumx2 = wp_get_attachment_image_src( $img_ID, 'rwd-mediumx2' );
	$image_large = wp_get_attachment_image_src( $img_ID, 'rwd-large' );
	$image_largex2 = wp_get_attachment_image_src( $img_ID, 'rwd-largex2' );
	$image_extralarge = wp_get_attachment_image_src( $img_ID, 'rwd-xl' );
	$image_extralargex2 = wp_get_attachment_image_src( $img_ID, 'rwd-xlx2' );
	$image_full = wp_get_attachment_image_src( $img_ID, 'full' );

	$image_alt_text = get_post_meta( $img_ID , '_wp_attachment_image_alt', true);

	$output = '';
	$output .= '<style>';
	$output .= $container_class . ' {';
	$output .= 'background-image: url(' . $image_small[0] . ')';
	$output .= '}';
//	$output .= '@media only screen and (-webkit-min-device-pixel-ratio: 2),';
//	$output .= 'only screen and (min--moz-device-pixel-ratio: 2),';
//	$output .= 'only screen and (-moz-min-device-pixel-ratio: 2),';
//	$output .= 'only screen and (-o-min-device-pixel-ratio: 2/1),';
//	$output .= 'only screen and (min-device-pixel-ratio: 2),';
//	$output .= 'only screen and (min-resolution: 192dpi),';
//	$output .= 'only screen and (min-resolution: 2dppx) {';
//	$output .= $container_class . ' {';
//	$output .= 'background-image: url(' . $image_smallx2[0] . ')';
//	$output .= '}';
//	$output .= '}';
	$output .= '@media only screen and (min-width: 400px) {';
	$output .= $container_class . ' {';
	$output .= 'background-image: url(' . $image_medium[0] . ')';
	$output .= '}';
	$output .= '}';
//	$output .= '@media only screen and (-webkit-min-device-pixel-ratio: 2) and (min-width: 400px),';
//	$output .= 'only screen and (min--moz-device-pixel-ratio: 2) and (min-width: 400px),';
//	$output .= 'only screen and (-moz-min-device-pixel-ratio: 2) and (min-width: 400px),';
//	$output .= 'only screen and (-o-min-device-pixel-ratio: 2/1) and (min-width: 400px),';
//	$output .= 'only screen and (min-device-pixel-ratio: 2) and (min-width: 400px),';
//	$output .= 'only screen and (min-resolution: 192dpi) and (min-width: 400px),';
//	$output .= 'only screen and (min-resolution: 2dppx) and (min-width: 400px) {';
//	$output .= $container_class . ' {';
//	$output .= 'background-image: url(' . $image_mediumx2[0] . ')';
//	$output .= '}';
//	$output .= '}';
	$output .= '@media only screen and (min-width: 800px) {';
	$output .= $container_class . ' {';
	$output .= 'background-image: url(' . $image_large[0] . ')';
	$output .= '}';
	$output .= '}';
//	$output .= '@media only screen and (-webkit-min-device-pixel-ratio: 2) and (min-width: 800px),';
//	$output .= 'only screen and (min--moz-device-pixel-ratio: 2) and (min-width: 800px),';
//	$output .= 'only screen and (-moz-min-device-pixel-ratio: 2) and (min-width: 800px),';
//	$output .= 'only screen and (-o-min-device-pixel-ratio: 2/1) and (min-width: 800px),';
//	$output .= 'only screen and (min-device-pixel-ratio: 2) and (min-width: 800px),';
//	$output .= 'only screen and (min-resolution: 192dpi) and (min-width: 800px),';
//	$output .= 'only screen and (min-resolution: 2dppx) and (min-width: 800px) {';
//	$output .= $container_class . ' {';
//	$output .= 'background-image: url(' . $image_largex2[0] . ')';
//	$output .= '}';
//	$output .= '}';
	$output .= '@media only screen and (min-width: 1200px) {';
	$output .= $container_class . ' {';
	$output .= 'background-image: url(' . $image_extralarge[0] . ')';
	$output .= '}';
	$output .= '}';
//	$output .= '@media only screen and (-webkit-min-device-pixel-ratio: 2) and (min-width: 1200px),';
//	$output .= 'only screen and (min--moz-device-pixel-ratio: 2) and (min-width: 1200px),';
//	$output .= 'only screen and (-moz-min-device-pixel-ratio: 2) and (min-width: 1200px),';
//	$output .= 'only screen and (-o-min-device-pixel-ratio: 2/1) and (min-width: 1200px),';
//	$output .= 'only screen and (min-device-pixel-ratio: 2) and (min-width: 1200px),';
//	$output .= 'only screen and (min-resolution: 192dpi) and (min-width: 1200px),';
//	$output .= 'only screen and (min-resolution: 2dppx) and (min-width: 1200px) {';
//	$output .= $container_class . ' {';
//	$output .= 'background-image: url(' . $image_full[0] . ')';
//	$output .= '}';
//	$output .= '}';
	$output .= '</style>';

	$output .= '<div class="rimginbg ' . $container . ' background-image">';
//	$output .= '<span class="rimginbg__inner"></span>';
	if(!empty($content)){
		$output .= do_shortcode($content);
	}
	$output .= '</div>';

	return $output;
}
add_shortcode('rimginbg', 'responsive_image_inline_bg');

/**
 * Recent posts shortcode
 */
function posts_view_function($num){

	$html = '';
	$i = $num;

	$wide_vars = array(1, 4);
	if(in_array($i, $wide_vars)){
		$size_class = ' gi-2-3';
	} else {
		$size_class = '';
	}

	$image_id = get_post_thumbnail_id( $post->ID );
	if ( empty( $image_id ) ) {
		$image_id = get_post_thumbnail_id( get_option( 'page_on_front' ) );
	}

	$img_src = wp_get_attachment_image_url( $image_id, 'rwd-small' );
	$img_fallback = wp_get_attachment_image_url( $image_id, 'large' );
	$srcset_value = wp_get_attachment_image_srcset( $image_id, 'large' );
	$srcset = $srcset_value ? ' srcset="' . esc_attr( $srcset_value ) . '"' : '';
	$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
//	if(!empty($img_src)) {
		$html .= '<a href="' . get_permalink($post->ID) . '" class="block block--mini-post block--link gi' . $size_class . '">';
		$html .= '<span class="block__img-contain img-fit">';
		$html .= '<img class="block__img" src="' . $img_src . '" ' . $srcset . ' sizes="(min-width: 768px) 500px, 100vw" alt="' . $alt . '" data-fallback-img="' . $img_fallback . '">';
		$html .= '</span>';
		$html .= '<div class="block__logo-contain">';


		$html .= '<div class="block__logo-wrap--alt">';
		$html .= '<div class="block__title--alt">' . get_the_title() . '</div>';
		$html .= '</div>';

		$html .= '</div>';


		$html .= '<article id="post-' . $post->ID . '" class="block__content--abs">';

		$html .= '<h1 class="block__title--abs delta">' . get_the_title() . '</h1>';
		if ( has_excerpt( $post->ID ) ) {
			$html .= '<p class="block__description">' . jspdx_truncate(get_the_excerpt(), 60, '...') . '</p>';
		}

		$html .= '<span class="block__button btn btn--primary-white btn--small">Read More</span>';

//				$html .= '<p class="block__footer">';
//				$categories = get_the_category($recent["ID"]);
//				if ( ! empty( $categories ) ) {
//					foreach( $categories as $category ) {
//						if($category == 'undefined'){
//							// do nothing
//						} else {
//							$html .= '<span><a class="block__footer-link" href="' . get_category_link( $category->term_id ) . '" alt="View all posts in ' . $category->name . '" title="View all posts in ' . $category->name . '" data-post-cat="' . $category->term_id . '">' . $category->name . '</a></span>';
//						}
//					}
//				}
//				$html .= '</p>';
		$html .= '</article>';

		$html .= '</a>';
//	}

	echo $html;
}

/**
 * Recent posts shortcode
 */
function recent_posts_function($atts, $content = null){
	extract(shortcode_atts(array(
		'resource_type'  => '',
		'category' => '',
		'posts_per_page' => 7,
		'orderby' => 'date'
	), $atts));

	if(!empty($category)) {
		$args = array(
			'posts_per_page' => $posts_per_page,
			'ignore_sticky_posts' => true,
			'post_type' => 'post',
			'orderby' => $orderby,
			'order'   => 'DESC',
			'numberposts' => $posts_per_page,
			'category_name' => $category,
		);
	} else {
		$args = array(
			'posts_per_page' => $posts_per_page,
			'ignore_sticky_posts' => true,
			'post_type' => 'post',
			'orderby' => $orderby,
			'order'   => 'DESC',
			'numberposts' => $posts_per_page,
		);
	}

	$the_query = new WP_Query( $args );

	$i = '';
	$html = '';

	// The Loop
	if ( $the_query->have_posts() ) {
		global $post;

		$html .= '<div class="recent-post-wrap g-flex g g-3up" >';

		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			global $post;

			$i ++;
			$wide_vars = array(1, 4);
			if(in_array($i, $wide_vars)){
				$size_class = ' gi-2-3';
			} else {
				$size_class = '';
			}


			$image_id = get_post_thumbnail_id( $post->ID );
			if ( empty( $image_id ) ) {
				$image_id = get_post_thumbnail_id( get_option( 'page_on_front' ) );
			}

			$img_src = wp_get_attachment_image_url( $image_id, 'rwd-small' );
			$img_fallback = wp_get_attachment_image_url( $image_id, 'large' );
			$srcset_value = wp_get_attachment_image_srcset( $image_id, 'large' );
			$srcset = $srcset_value ? ' srcset="' . esc_attr( $srcset_value ) . '"' : '';
			$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

			$html .= '<article class="block block--mini-post block--link gi' . $size_class . '">';

			$html .= '<span class="block__img-contain img-fit" href="' . get_permalink($post->ID) . '">';
			if(!empty($img_src)) {
				$html .= '<img class="block__img" src="' . $img_src . '" ' . $srcset . ' sizes="(min-width: 768px) 500px, 100vw" alt="' . $alt . '" data-fallback-img="' . $img_fallback . '">';
			}
			$html .= '</span>';
			$html .= '<div class="block__content--abs">';

			$html .= '<a class="block__link" href="' . get_permalink($post->ID) . '"><h1 class="title__block zeta">' .   $post->post_title.'</h1></a>';

			$html .= '<p class="block__footer">';
			$categories = get_the_category($recent["ID"]);
			if ( ! empty( $categories ) ) {
				foreach( $categories as $category ) {
					if($category == 'undefined'){
						// do nothing
					} else {
						$html .= '<span><a class="block__footer-link" href="' . get_category_link( $category->term_id ) . '" alt="View all posts in ' . $category->name . '" title="View all posts in ' . $category->name . '" data-post-cat="' . $category->term_id . '">' . $category->name . '</a></span>';
					}
				}
			}
			$html .= '</p>';
			$html .= '</div>';

			$html .= '</article>';
		}

		$html .= '</div>';
	}
	wp_reset_postdata();

	return $html;
}
add_shortcode('recent_posts', 'recent_posts_function');

/**
 * Accordion shortcode
 */
function jspdx_accordion_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'title' 	=> '',
		'link' 		=> '',
		'linktext' 	=> ''
	), $atts));

	$return_html = '<div class="jspdx-accordion accordion-container">';
	$return_html .= '<div class="accordion-header accordion-trigger">';
	$return_html .= '<h2 class="accordion-title"><i class="open jspdx-icon-plus3"></i><i class="close jspdx-icon-minus3"></i>'.$title.'</h2>';
	$return_html .= '</div>';
	$return_html .= '<div class="accordion-content">';
	$return_html .= do_shortcode($content);
	$return_html .= $linktext != ''?'<p class="accordion-link"><a href="'.$link.'">'.$linktext.'</a></p>':'';
	$return_html .= '<p class="accordion-trigger accordion-close"><i class="jspdx-icon-minus-circle2"></i> Close</p>';
	$return_html .= '</div>';
	$return_html .= '</div>';

	return $return_html;
}
add_shortcode('accordion', 'jspdx_accordion_shortcode');

/**
 * Init shortcode shortcode
 */
function init_shortcode_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'name' => ''
	), $atts));


	ob_start();
	echo do_shortcode( '['.$name.']' );
	$return_html.= ob_get_contents();
	ob_end_clean();

	return $return_html;
}
add_shortcode('init_shortcode', 'init_shortcode_shortcode');

/**
 * Insert icon shortcode
 */
function insert_icon_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'class' 	=> ''
	), $atts));

	$icon = '';
	$icon .= '<i class="' . $class . '">' . do_shortcode($content) . '</i>';

	return $icon;
}
add_shortcode('icon', 'insert_icon_shortcode');

/**
 * JSPDX video shortcode
 */
function jspdx_video_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'url' 	=> ''
	), $atts));

	global $wp_embed;
	$post_embed = $wp_embed->run_shortcode('[embed]' . $url . '[/embed]');

	$html = '';
	$html .= $post_embed;

	return $html;
}
add_shortcode('embed_video', 'jspdx_video_shortcode');

/**
 * Insert google maps shortcode
 */
function google_maps_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'icon' => '',
		'class' => '',
		'linktext' => ''
	), $atts));

	$return_html ='';
	$return_html .= '<div class="gmap' . $class . '">';
	$return_html .= do_shortcode($content);
	$return_html .= '</div>';

	return $return_html;
}
add_shortcode('googlemap', 'google_maps_shortcode');

/**
 * Search widget shortcode
 */
function search_widget_shortcode( $atts, $content = null ){
	extract(shortcode_atts(array(
		'width' => 'normal',
		'type' => '',
	), $atts));

	$search = '';
//	$search .= get_search_form($echo = false);

	$search .= '<form id="blog-search-filter" class="blog-search-filter">';

	if($type == 'archive'){
		if(is_category()){
			$search .= '<a href="/blog/" class="btn btn--primary btn--fw">Search Blog</a>';
		} else {

			$search .= '<div class="blog-search-filter__list">';
			$search .= '<h3 class="heading-block delta">Archives</h3>';
			$search .= '<ul class="b-list">';
			$search .= wp_get_archives( array(
				'type' => 'monthly',
				'echo' => false
			) );
			$search .= '</ul>';
			$search .= '</div>';
		}

	}elseif($type == 'search'){
		$search .= '<div id="blog-keyword-search" class="blog-keyword-search">';
		$search .= '<label class="screen-reader-text" for="s">Search for:</label>';
		$search .= '<input type="text" value="" name="s" id="s" placeholder="Search site">';
		$search .= '<input type="submit" id="searchsubmit" value="&#xe922;">';
		$search .= '</div>';
	} else {

		// keyword search

		$search .= '<div id="blog-keyword-search" class="blog-keyword-search">';
		$search .= '<label class="screen-reader-text" for="s">Search for:</label>';
		$search .= '<input type="text" value="" name="s" id="s" placeholder="Search blog">';
		$search .= '<input type="submit" id="searchsubmit" value="&#xe922;">';
		$search .= '</div>';

		$post_cats = array(
			'orderby'    => 'name',
			'order'      => 'ASC',
			'taxonomy'   => 'category',
			'hide_empty' => 0
		);

		$apost_cat = '';

		if ( isset( $_REQUEST['post_cat'] ) ) {
			$apost_cat = $_REQUEST['post_cat'];
		} else if ( isset( $_REQUEST['postcat'] ) ) {
			$apost_cat = $_REQUEST['postcat'];
		} else if ( isset( $_COOKIE['post-cat'] ) ) {
			$apost_cat = $_COOKIE['post-cat'];
		}

		$categories = get_categories( $post_cats );
		$search .= '<div class="blog-search-filter__list">';
		$search .= '<h3 class="heading-block delta">Category</h3>';
		$search .= '<ul>';
		foreach ( $categories as $category ) {
			if ( $category->name == 'Uncategorized' || $category->count < 1 ) {
				// do nothing
			} else {
				if ( $category->term_id == $apost_cat ) {
					$input_checked = 'checked="checked"';
				} else {
					$input_checked = '';
				}
				$search .= '<li><input id="cat-' . $category->term_id . '" type="checkbox" name="post_cat[]" value="' . $category->term_id . '" ' . $input_checked . '></input><label for="cat-' . $category->term_id . '">' . $category->name . '</label></li>';
			}
		}
		$search .= '</ul>';
		$search .= '</div>';
	}

	$search .= '</form>';


	$s_contain = '';
	$s_contain .= '<div class="search-accordion jspdx-container">';
	$s_contain .= '<button class="search-accordion__trigger jspdx-trigger btn--primary">Filter Blog</button>';
	$s_contain .= '<div class="search-accordion__container jspdx-container">';
	$s_contain .= $search;
	$s_contain .= '</div>';
	$s_contain .= '</div>';


	return $s_contain;
}
add_shortcode('search_widget', 'search_widget_shortcode');

/**
 * Tabs shortcodes
 */

/**
 * Tabs group function
 */
$tabs_divs = '';

function tabs_group($atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));

	global $tabs_divs;

	$tabs_divs = '';

	$output = '<div id="" class="jspdx-tabs">';
	$output .= '<div class="jspdx-tabs__inner">';
	$output.= '<span class="jspdx-tabs__title">' . $title . '</span>';
	$output.= '<ul class="jspdx-tabs__ul">'.do_shortcode($content).'</ul>';
	$output .= '<div class="jspdx-tabs__items">'.$tabs_divs.'</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}

/**
 * Tab function
 */
function tab($atts, $content = null) {
	global $tabs_divs;

	extract(shortcode_atts(array(
		'id' => '',
		'title' => '',
		'icon' => ''
	), $atts));

	if(empty($id))
		$id = 'side-tab'.rand(100,999);

	$output = '
		        <li class="jspdx-tabs__tab">
		            <a href="#'.$id.'" class="jspdx-tabs__tab-link"><i class="' . $icon . '"></i>'.$title.'</a>
		        </li>
		    ';

	$tabs_divs .= '<div id="'.$id.'" class="jspdx-tab-item">';
	$tabs_divs .= '<div class="jspdx-tab-item__inner">';
	$tabs_divs .= '<div class="jspdx-tab-item__title-contain">';
	$tabs_divs .= '<h2 class="jspdx-tab-item__title">' . $title . '</h2>';
	$tabs_divs .= '</div>';
	$tabs_divs .= '<div class="jspdx-tab-item__content-contain">';
	$tabs_divs .= do_shortcode($content);
	//	$tabs_divs .= '<a href="#tab-side-container" class="jspdx-tab-item__close btn-primary btn-small" data-tab-id="' . $id . '">X Close</a>';
	$tabs_divs .= '</div>';

	$tabs_divs .= '</div>';
	$tabs_divs .= '</div>';

	return $output;
}

add_shortcode('tabs', 'tabs_group');
add_shortcode('tab', 'tab');

/**
 * Responsive table shortcode
 *
 * use with the shortcode function below like this:
 * [rwd_table headers="Specialty:Referral Bonus"]
 * [rwd_table_item data="Registered Nurse:$1000"]
 * [rwd_table_item data="Physical Therapist:$1000"]
 * [/rwd_table]
 *
 */
function responsive_table_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'headers' => '',
	), $atts));

	global $headers_array;

	$rwd_table_items = '';

	$headers_array = explode(':', $headers);

	$output = '<div id="" class="jspdx-rwd-table">';
	if(!empty($title)){
		$output.= '<span class="jspdx-rwd-table__title">' . $title . '</span>';
	}
	$output .= '<table class="jspdx-rwd-table__table">';
	$output .= '<tbody>';
	$output .= '<tr>';
	foreach ($headers_array as $item_title) {
		$output.= '<th class="jspdx-rwd-table__head">' . $item_title . '</th>';
	}
	$output .= '</tr>';
	$output.= do_shortcode($content);
	$output .= '</tbody>';
	$output .= '</table>';
	$output .= '</div>';

	return $output;
}

/**
 * Responsive table item shortcode
 */
function responsive_table_item_shortcode($atts, $content = null) {
	global $headers_array;

	extract(shortcode_atts(array(
		'id' => '',
		'title' => '',
		'icon' => '',
		'data' => '',
	), $atts));

	$items_array = explode(':', $data);
	$output = '';

	$output .= '<tr>';
	foreach ($items_array as $key=>$item) {
		$output .= '<td data-th="' . $headers_array[$key] . '"><span>' . $item . '</span></td>';
	}
	$output .= '</tr>';

	return $output;
}

add_shortcode('rwd_table', 'responsive_table_shortcode');
add_shortcode('rwd_table_item', 'responsive_table_item_shortcode');

/**
* Hide email from Spam Bots using a shortcode.
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address.
 */
function wpcodex_hide_email_shortcode( $atts , $content = null ) {
	if ( ! is_email( $content ) ) {
		return;
	}

	return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
}
add_shortcode( 'email', 'wpcodex_hide_email_shortcode' );