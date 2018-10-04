<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 */

use Inc2734\WP_Awesome_Widgets\Awesome_Widgets;

new Awesome_Widgets();

add_action(
	'after_setup_theme',
	function() {
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
);

add_filter(
	'inc2734_wp_awesome_widgets_render_widget',
	function( $content ) {
		return str_replace( 'wpaw-carousel__inner', 'wpaw-carousel__inner c-container', $content );
	}
);
