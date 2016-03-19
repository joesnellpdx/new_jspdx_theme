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

function jspdx_register_primary_section_metabox( ) {

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

	$meta_boxes->add_field( array(
		'name'       => __( 'Section Title', 'cmb2' ),
//		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $pd_prefix . 'title',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );

}
add_filter( 'cmb2_init', 'jspdx_register_primary_section_metabox' );

function jspdx_register_repeatable_section_metabox() {

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
		'name'    => __( 'Section Content', 'cmb2' ),
		'id'      => $prefix . 'wysiwyg',
		'type'    => 'wysiwyg',
		'options' => array( 'textarea_rows' => 10, ),
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'    => __( 'Background Color', 'cmb2' ),
		'id'      => $prefix . 'background-wysiwyg',
		'type'    => 'radio',
		'show_option_none' => true,
		'options' => array(
			'background--one' => __( '<span class="opt_paintchip background--one" ></span> Background One', 'cmb2' ),
			'background--two' => __( '<span class="opt_paintchip background--two" ></span> Background Two', 'cmb2' ),
		)
	) );

}
add_filter( 'cmb2_init', 'jspdx_register_repeatable_section_metabox' );

function jspdx_register_page_default_metabox( ) {

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

	$meta_boxes->add_field( array(
		'name'       => __( 'Page Subeader:', 'cmb2' ),
		'desc'       => __( '(optional)', 'cmb2' ),
		'id'         => $pd_prefix . 'subtitle',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
	) );

//	$meta_boxes->add_field( array(
//		'name'    => __( 'Main Bg Image', 'cmb2' ),
//		'id'      => $pd_prefix . 'bg',
//		'type'    => 'file',
//	) );


}
add_filter( 'cmb2_init', 'jspdx_register_page_default_metabox' );

function jspdx_register_fullscreen_metabox( ) {

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
add_filter( 'cmb2_init', 'jspdx_register_fullscreen_metabox' );

function content_areas(){

	global $post;

	$field_data = get_post_meta( get_the_id(), '_sr-content-section', true );

	$count = 0;
	$n = 0;

	foreach ( (array) $field_data as $key => $entry ) {

		$sect_title = $sectioncont = $bg_color =  '';

		if ( isset( $entry['_sr-content-section-title'] ) )
			$sect_title = esc_html( $entry['_sr-content-section-title'] );

		if ( isset( $entry['_sr-content-wysiwyg'] ) )
			$sectioncont = wpautop( $entry['_sr-content-wysiwyg'] );

		if ( isset( $entry['_sr-content-background-wysiwyg'] ) )
			$bg_color = esc_html( $entry['_sr-content-background-wysiwyg'] );

		if(!empty($sectioncont)) {

			$count++;

			$sectionid = $count+1;

			$add_class = '';

			if(!empty($bg_color)){
				$add_class = $add_class . ' ' . $bg_color;
			} else {
				$add_class = $add_class . ' bg-none';
			}

			echo '<section id="section-' . $sectionid . '" class="section section--page' . $add_class . '">';
			echo '<div class="section__inner lc">';
			if(!empty($sect_title)){
				echo '<h1 class="title--section ' . $title_class . '">' . $sect_title . '</h1>';
			}

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

			echo do_shortcode( $newercontent );

			echo '</div>';
			echo '</section>';

		}
	}
}

?>