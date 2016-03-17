<?php

function page_hero() {

	$html = '';
	$html .= '<header class="entry-header">';
		$html .= '<div class="section__inner lc">';
			$html .= insert_page_heading();
		$html .= '</div>';
	$html .= '</header><!-- .entry-header -->';

	return $html;
}

?>