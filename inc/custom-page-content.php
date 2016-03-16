<?php
/**
 * JSPDX Theme custom page content functions.
 *
 * @package JSPDX Theme
 */

// hide the editor on pages
function hide_page_stuff() {
	remove_post_type_support( 'page', 'comments' );
	// Get the Post ID.
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	if( !isset( $post_id ) ) return;

	// Get the name of the Page Template file.
	$template_file = get_post_meta($post_id, '_wp_page_template', true);

	if($template_file == 'template-full-screen.php'){ // edit the template name
		remove_post_type_support('page', 'editor');
	}
}
add_action('init', 'hide_page_stuff');

function sr_register_primary_section_metabox( ) {

	// Start with an underscore to hide fields from custom fields list
	$pd_prefix = '_psect_';

	$meta_boxes = new_cmb2_box( array(
		'id' => 'primary_section',
		'title' => __( 'Primary Section Options', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'show_on'      => array( 'key' => 'page-template', 'value' => array( 'default', ''), ),
		'context' => 'normal',
		'priority' => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	));

//	$meta_boxes->add_field( array(
//		'name'       => __( 'Section Header', 'cmb2' ),
////		'desc'       => __( 'field description (optional)', 'cmb2' ),
//		'id'         => $pd_prefix . 'title',
//		'type'       => 'text',
//		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
//		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
//		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
//		// 'on_front'        => false, // Optionally designate a field to wp-admin only
//		// 'repeatable'      => true,
//	) );

	$meta_boxes->add_field( array(
		'name' => __( 'Section title', 'cmb2' ),
		'desc' => 'Page subtitle.',
		'id'   => $pd_prefix . 'section-subtitle',
		'type' => 'text',
	) );

	$meta_boxes->add_field( array(
		'name'    => __( 'Custom style', 'cmb2' ),
		'id'      => $pd_prefix. 'style',
		'type'    => 'radio',
		'show_option_none' => true,
		'options' => array(
			'wide' => __( 'Wide Content (not fullwidth)', 'cmb2' ),
			'fullwidth' => __( 'Fullwidth Content', 'cmb2' ),
		)
	) );
//	$meta_boxes->add_field( array(
//		'name'    => __( 'Image Overlay', 'cmb2' ),
//		'id'      => $pd_prefix . 'overlay',
//		'type'    => 'radio',
//		'desc' => 'background-color-overlay',
//		'show_option_none' => true,
//		'options' => array(
////			'nooverlay' => __( 'No overlay', 'cmb2' ),
//			'primary' => __( '<span class="opt_paintchip primarybkgd" ></span> Primary Color', 'cmb2' ),
//			'third' => __( '<span class="opt_paintchip thirdbkgd" ></span> Secondary Color', 'cmb2' ),
//			'gray' => __( '<span class="opt_paintchip graybkgd" ></span> Gray ', 'cmb2' ),
//		)
//	) );

//	$meta_boxes->add_field( array(
//		'name'    => __( 'Remove section padding (full-width)', 'cmb2' ),
//		'id'      => $pd_prefix . 'nopadding',
//		'type'    => 'checkbox'
//	) );

}
add_filter( 'cmb2_init', 'sr_register_primary_section_metabox' );

function sr_register_repeatable_section_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_sr-content-';

	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Additional content sections', 'cmb2' ),
		'object_types' => array( 'page', ),
		'show_on'      => array( 'key' => 'page-template', 'value' => array( 'default', ''), ),
	) );

	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'section',
		'type'        => 'group',
		'description' => __( 'Additional Page Section', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Section {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Section', 'cmb2' ),
			'remove_button' => __( 'Remove Section', 'cmb2' ),
			'sortable'      => true, // beta
		),
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Section title', 'cmb2' ),
		'id'   => $prefix . 'section-title',
		'desc' => 'Creates hero title block above content.',
		'type' => 'text',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Section subtitle', 'cmb2' ),
		'id'   => $prefix . 'section-subtitle',
		'desc' => 'Section title not required to use subtitle.',
		'type' => 'text',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'    => __( 'Section Content', 'cmb2' ),
		'id'      => $prefix . 'wysiwyg',
		'type'    => 'wysiwyg',
		'options' => array( 'textarea_rows' => 10, ),
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'    => __( 'Section Title Background Image', 'cmb2' ),
		'id'      => $prefix . 'bg',
		'type'    => 'file',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'    => __( 'Background Color', 'cmb2' ),
		'id'      => $prefix . 'background-wysiwyg',
		'type'    => 'radio',
		'show_option_none' => true,
		'options' => array(
			'seventhbkgd' => __( '<span class="opt_paintchip seventhbkgd" ></span> Option One', 'cmb2' ),
			'eighthbkgd' => __( '<span class="opt_paintchip eighthbkgd" ></span> Option Two', 'cmb2' ),
			'ninthbkgd' => __( '<span class="opt_paintchip ninthbkgd" ></span> Option Three ', 'cmb2' ),
		)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'    => __( 'Custom style', 'cmb2' ),
		'id'      => $prefix . 'style',
		'type'    => 'radio',
		'show_option_none' => true,
		'options' => array(
			'wide' => __( 'Wide Content (not fullwidth)', 'cmb2' ),
			'fullwidth' => __( 'Fullwidth Content', 'cmb2' ),
		)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Wistia ID', 'cmb2' ),
		'id'      => $prefix . 'wistia',
		'description' => __( 'Wistia ID should look like this: cxn20upvi8.<br>Video thumbnail will replace any background image added above. Wistia video will override youtube url (below).', 'cmb2' ),
		'type' => 'text',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Youtube URL', 'cmb2' ),
		'id'      => $prefix . 'youtube',
		'description' => __( 'URL should look like this: https://youtu.be/XQu8TTBmGhA.<br>Video thumbnail will replace any background image added above.', 'cmb2' ),
		'type' => 'text_url',
	) );

}
add_filter( 'cmb2_init', 'sr_register_repeatable_section_metabox' );

function sr_register_page_default_metabox( ) {

	// Start with an underscore to hide fields from custom fields list
	$pd_prefix = '_hero_';

	$meta_boxes = new_cmb2_box( array(
		'id' => 'page_hero',
		'title' => __( 'Hero Section Content Options', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'show_on'      => array( 'key' => 'page-template', 'value' => array( 'default'), ),
		'context' => 'normal',
		'priority' => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	));

	$meta_boxes->add_field( array(
		'name'       => __( 'Page Header (h1) - Page Title will be used if left blank:', 'cmb2' ),
//		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $pd_prefix . 'title',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

//	$meta_boxes->add_field( array(
//		'name'    => __( 'Hero Content', 'cmb2' ),
//		'id'      => $pd_prefix . 'content',
//		'type'    => 'wysiwyg',
//		'options' => array( 'textarea_rows' => 5, ),
//		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
//	) );

	$meta_boxes->add_field( array(
		'name'    => __( 'Main Bg Image', 'cmb2' ),
		'id'      => $pd_prefix . 'bg',
		'type'    => 'file',
	) );

//	$meta_boxes->add_field( array(
//		'name'    => __( 'Replace main image with slider.', 'cmb2' ),
//		'desc'       => __( 'May only work on home page.', 'cmb2' ),
//		'id'      => $pd_prefix . 'slider',
//		'type'    => 'checkbox'
//	) );


}
add_filter( 'cmb2_init', 'sr_register_page_default_metabox' );

function sr_register_fullscreen_metabox( ) {

	// Start with an underscore to hide fields from custom fields list
	$pd_prefix = '_hero_';

	$meta_boxes = new_cmb2_box( array(
		'id' => 'page_hero_fullscreen',
		'title' => __( 'Hero Section Content Options', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'show_on'      => array( 'key' => 'page-template', 'value' => array( 'template-fullscreen.php'), ),
		'context' => 'normal',
		'priority' => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	));

	$meta_boxes->add_field( array(
		'name'       => __( 'Page Header (h1) - Page Title will be used if left blank:', 'cmb2' ),
//		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $pd_prefix . 'title',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

	$meta_boxes->add_field( array(
		'name'    => __( 'Hero Content', 'cmb2' ),
		'id'      => $pd_prefix . 'content',
		'type'    => 'wysiwyg',
		'options' => array( 'textarea_rows' => 5, ),
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$meta_boxes->add_field( array(
		'name'    => __( 'Main Bg Image', 'cmb2' ),
		'id'      => $pd_prefix . 'bg',
		'type'    => 'file',
	) );

	$meta_boxes->add_field( array(
		'name'    => __( 'Replace main image with slider.', 'cmb2' ),
		'desc'       => __( 'May only work on home page.', 'cmb2' ),
		'id'      => $pd_prefix . 'slider',
		'type'    => 'checkbox'
	) );


}
add_filter( 'cmb2_init', 'sr_register_fullscreen_metabox' );

function content_areas(){

	global $post;

	$field_data = get_post_meta( get_the_id(), '_sr-content-section', true );

	$count = 0;
	$n = 0;

	foreach ( (array) $field_data as $key => $entry ) {

		$sect_title = $sect_subtitle = $sectioncont = $bg_color = $sect_border = $sect_img_id = $youtube_url = $sect_style = $wistia_id = '';

		if ( isset( $entry['_sr-content-section-title'] ) )
			$sect_title = esc_html( $entry['_sr-content-section-title'] );

		if ( isset( $entry['_sr-content-section-subtitle'] ) )
			$sect_subtitle = esc_html( $entry['_sr-content-section-subtitle'] );

		if ( isset( $entry['_sr-content-wysiwyg'] ) )
			$sectioncont = wpautop( $entry['_sr-content-wysiwyg'] );

		if ( isset( $entry['_sr-content-background-wysiwyg'] ) )
			$bg_color = esc_html( $entry['_sr-content-background-wysiwyg'] );

		if ( isset( $entry['_sr-content-style'] ) )
			$sect_style = esc_html( $entry['_sr-content-style'] );

		if ( isset( $entry['_sr-content-bg_id'] ) )
			$sect_img_id = esc_html( $entry['_sr-content-bg_id'] );

		if ( isset( $entry['_sr-content-youtube'] ) )
			$youtube_url = esc_html( $entry['_sr-content-youtube'] );

		if ( isset( $entry['_sr-content-wistia'] ) )
			$wistia_id = esc_html( $entry['_sr-content-wistia'] );


		if(!empty($sectioncont)) {

			$count++;

			$sectionid = $count+1;

			$add_class = '';

			if((!empty($sect_style))) {
				$add_class = $add_class . ' section--' . $sect_style;
			}
			if(!empty($bg_color)){
				$add_class = $add_class . ' ' . $bg_color;
			} else {
				$add_class = $add_class . ' bg-none';
			}

			echo '<div id="section-' . $sectionid . '" class="section section--page' . $add_class . '">';
			if(!empty($sect_title)){
				if(!empty($wistia_id)) {

					echo '<div class="section__hero section__hero--wistia-contain">';
					echo do_shortcode('[wistia id="' . $wistia_id . '" pop="true"]');
					echo '<div class="section__title-wrap lc--nopad">';
					echo '<div class="section__title-contain">';
					echo '<h1 class="section__title ' . $title_class . '">' . $sect_title . '</h1>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				} elseif(!empty($youtube_url)) {
					$video_ID = youtube_id_from_url($youtube_url);

					$video_content = file_get_contents("http://youtube.com/get_video_info?video_id=".$video_ID);
					parse_str($video_content, $video_info);
					$video_title =  $video_info['title'];

					echo '<div class="section__hero section__hero--video-contain" data-video-url="' . $youtube_url . '">';
					echo '<img src="http://img.youtube.com/vi/' . $video_ID . '/hqdefault.jpg" alt="Video: ' . $video_title . '">';
					echo '<div class="section__title-wrap lc--nopad">';
					echo '<div class="section__title-contain">';
					echo '<h1 class="section__title ' . $title_class . '">' . $sect_title . '</h1>';
					echo '</div>';
					echo '</div>';
					global $wp_embed;
					$video_embed .= $wp_embed->run_shortcode('[embed ]'. $youtube_url . '[/embed]');

					$videohtml .=  '<div class="section__hero-videopop is-vishidden">' . $video_embed . '</div>';
					echo $videohtml;
					echo '</div>';
				} elseif(!empty($sect_img_id)){
					$img_src      = wp_get_attachment_image_url( $sect_img_id, 'rwd-small' );
					$img_fallback = wp_get_attachment_image_url( $sect_img_id, 'full' );
					$srcset_value = wp_get_attachment_image_srcset( $sect_img_id, 'large' );
					$srcset       = $srcset_value ? ' srcset="' . esc_attr( $srcset_value ) . '"' : '';
					$alt          = get_post_meta( $sect_img_id, '_wp_attachment_image_alt', true );

					echo '<div class="section__hero section__hero--img-contain img-fit">';
					echo '<img src="' . $img_src . '" ' . $srcset . ' sizes="100vw" alt="' . $alt . '" data-fallback-img="' . $img_fallback . '">';
					echo '<div class="section__title-wrap lc--nopad">';
					echo '<div class="section__title-contain">';
					echo '<h1 class="section__title ' . $title_class . '">' . $sect_title .
						'</h1>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				} else {
					echo '<div class="section__hero">';
					echo '<div class="section__title-wrap lc--nopad">';
					echo '<div class="section__title-contain">';
					echo '<h1 class="section__title ' . $title_class . '">' . $sect_title .
						'</h1>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}
			}

			echo '<div class="section__inner">';

			$array = array (
				'<p>[' => '[',
				']</p>' => ']',
				']<br />' => ']'
			);

			$newcontent = strtr($sectioncont, $array);
			$newercontent = preg_replace(
				array('{<a(.*?)(wp-att|wp-content/uploads)[^>]*><img}',
					'{ wp-image-[0-9]*" /></a>}'),
				array('<img','" />'),
				$newcontent);


			echo '<div class="section__inner-content-contain">';
			echo '<div class="section__inner-content">';

			if(!empty($sect_subtitle)){
				echo '<h2 class="subheading">' . $sect_subtitle . '</h2>';
			}

			echo do_shortcode( $newercontent );
			echo '</div>';
			echo '</div>';

			echo '</div>';

			echo '</div>';

		}

	}
}

?>