<?php
/**
 * JSPDX Theme custom form functions.
 *
 * @package JSPDX Theme
 */

/**
 * Gravity form custom select
 */
add_filter( 'gform_field_content', function ( $field_content, $field ) {

	if ( $field->type == 'select' ) {
		return str_replace( 'ginput_container','ginput_container ginput_container--select srbt-select', $field_content );
	}

	return $field_content;
}, 10, 2 );