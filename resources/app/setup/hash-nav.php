<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 */

use Framework\Helper;

add_action(
	'wp_footer',
	function() {
		Helper::get_template_part( 'template-parts/overlay-search-box' );
		Helper::get_template_part( 'template-parts/widget-area/overlay' );
	}
);
