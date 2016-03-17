<?php

function page_hero() {

	$html = '';
	$html .= '<header class="entry-header">';
		$html .= insert_page_heading();
	$html .= '</header><!-- .entry-header -->';

	return $html;
}

?>