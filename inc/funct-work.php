<?php
/**
 * JSPDX Work post type functions.
 *
 * @package JSPDX Theme
 */

// Register Custom Post Type
function work_post_type() {

	$labels = array(
		'name'                  => _x( 'Works', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Work', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Works', 'text_domain' ),
		'name_admin_bar'        => __( 'Work', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Work', 'text_domain' ),
		'description'           => __( 'Work by Joe Snell', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', ),
		'taxonomies'            => array( 'work-category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-format-gallery',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'work', $args );

}
add_action( 'init', 'work_post_type', 0 );

// Register Custom Taxonomy
function work_category() {

	$labels = array(
		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Work Category', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'work-category', array( 'work' ), $args );

}
add_action( 'init', 'work_category', 0 );

function jspdx_register_work_metabox( ) {

	// Start with an underscore to hide fields from custom fields list
	$wk_prefix = '_work_';

	$meta_boxes = new_cmb2_box( array(
		'id' => 'work',
		'title' => __( 'Work Options', 'cmb2' ),
		'object_types'  => array( 'work', ), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	));

	$meta_boxes->add_field( array(
		'name'       => __( 'Work Description', 'cmb2' ),
//		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $wk_prefix . 'description',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
	) );

	$meta_boxes->add_field( array(
		'name'       => __( 'Work Icon Class', 'cmb2' ),
//		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $wk_prefix . 'icon',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
	) );

	$meta_boxes->add_field( array(
		'name' => __( 'Work URL', 'cmb2' ),
		'id'   => $wk_prefix . 'url',
		'type' => 'text_url',
		// 'protocols' => array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet' ), // Array of allowed protocols
	) );

	$meta_boxes->add_field( array(
		'name'    => __( 'Use direct link in roll.', 'cmb2' ),
		'id'      => $wk_prefix . 'direct',
		'type'    => 'checkbox'
	) );

}
add_filter( 'cmb2_init', 'jspdx_register_work_metabox' );

/**
 * Recent works shortcode
 */
function recent_works_function($atts, $content = null){
	extract(shortcode_atts(array(
		'resource_type'  => '',
		'category' => '',
		'posts_per_page' => 4,
		'orderby' => 'date'
	), $atts));

	if(!empty($category)) {
		$args = array(
			'posts_per_page' => $posts_per_page,
			'ignore_sticky_posts' => true,
			'post_type' => 'work',
			'orderby' => $orderby,
			'order'   => 'DESC',
			'numberposts' => $posts_per_page,
			'category_name' => $category,
		);
	} else {
		$args = array(
			'posts_per_page' => $posts_per_page,
			'ignore_sticky_posts' => true,
			'post_type' => 'work',
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

			$description = get_post_meta( get_the_ID(), '_work_description', true );
			$icon = get_post_meta( get_the_ID(), '_work_icon', true );
			$direct = get_post_meta( get_the_ID(), '_work_direct', true );
			$link = get_post_meta( get_the_ID(), '_work_url', true );

			$img_src = wp_get_attachment_image_url( $image_id, 'rwd-small' );
			$img_fallback = wp_get_attachment_image_url( $image_id, 'large' );
			$srcset_value = wp_get_attachment_image_srcset( $image_id, 'large' );
			$srcset = $srcset_value ? ' srcset="' . esc_attr( $srcset_value ) . '"' : '';
			$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

			if($direct == 'on'){
				$post_link = $link;
				$button_text = 'View Website';
				$target = ' target="_blank"';
			} else {
				$post_link = get_permalink($post->ID);
				$button_text = 'View Project';
				$target = '';
			}

			if(!empty($img_src)) {
				$html .= '<a href="' . $post_link . '" class="block block--mini-post block--link gi' . $size_class . '"' . $target . '>';
				$html .= '<span class="block__img-contain img-fit">';
					$html .= '<img class="block__img" src="' . $img_src . '" ' . $srcset . ' sizes="(min-width: 768px) 500px, 100vw" alt="' . $alt . '" data-fallback-img="' . $img_fallback . '">';
				$html .= '</span>';
				$html .= '<div class="block__logo-contain">';

				if(!empty($icon)) {
					$html .= '<div class="block__logo-wrap">';
					$html .= '<figure class="block__logo fixedratio--two ' . $icon . ' title="' . $post->post_title . '"></figure>';
					$html .= '</div>';
				} else {
					$html .= '<div class="block__logo-wrap--alt">';
					$html .= '<div class="block__title--alt">' . $post->post_title . '</div>';
					$html .= '</div>';
				}

				$html .= '</div>';


				$html .= '<div class="block__content--abs">';

				$html .= '<h1 class="block__title--abs delta">' . $post->post_title . '</h1>';
				if(!empty($description)){
					$html .= '<p class="block__description">' . $description . '</p>';
				}

				$html .= '<span class="block__button btn btn--primary-white btn--small">' . $button_text . '</span>';

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
				$html .= '</div>';

				$html .= '</a>';
			}
		}

		$html .= '</div>';
	}
	wp_reset_postdata();

	return $html;
}
add_shortcode('recent_works', 'recent_works_function');