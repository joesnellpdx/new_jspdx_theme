<?php

function page_hero() {

	$html = '';
	if ( has_post_thumbnail() ) {
		global $post, $wp_query;
		if(is_home()){
			$the_page_id = $wp_query->queried_object->ID;
		} else {
			$the_page_id = $post->ID;
		}

		$image_id = get_post_thumbnail_id( $the_page_id );
		$img_src = wp_get_attachment_image_url( $image_id, 'rwd-small' );
		$img_fallback = wp_get_attachment_image_url( $image_id, 'large' );
		$srcset_value = wp_get_attachment_image_srcset( $image_id, 'large' );
		$srcset = $srcset_value ? ' srcset="' . esc_attr( $srcset_value ) . '"' : '';
		$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

		$html .= '<div id="page-hero" class="page-hero">';
		$html .= '<div class="page-hero__img-contain img-fit">';
		$html .= '<img class="page-hero__img" src="' . $img_src . '" ' . $srcset . ' sizes="(min-width: 768px) 500px, 100vw" alt="' . $alt . '" data-fallback-img="' . $img_fallback . '">';
		$html .= '</div>';

		$html .= '</div>';
		$html .= '<header class="entry-header">';

		$html .= '<div class="section__inner lc">';
		$html .= insert_page_heading();
		$html .= '</div>';
		$html .= '</header><!-- .entry-header -->';
	} else {
		$html .= '<header class="entry-header">';
		$html .= '<div class="section__inner lc">';
		$html .= insert_page_heading();
		$html .= '</div>';
		$html .= '</header><!-- .entry-header -->';
	}

	return $html;
}

