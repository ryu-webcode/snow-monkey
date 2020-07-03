<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 * @version 10.10.6
 */

use Framework\Controller\Controller;

global $wp_query;

$_post_type = $wp_query->get( 'post_type' );
$_post_type = $_post_type ? $_post_type : 'any';

query_posts(
	array_merge(
		$wp_query->query,
		[
			'post_type' => $_post_type,
		]
	)
);

Controller::layout( get_theme_mod( 'archive-page-layout' ) );
if ( have_posts() ) {
	Controller::render( 'archive', 'search' );
} else {
	Controller::render( 'no-match' );
}
