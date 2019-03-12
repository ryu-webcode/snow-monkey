<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 */

use Inc2734\WP_Customizer_Framework\Framework;
use Framework\Helper;

if ( ! is_customize_preview() ) {
	return;
}

$custom_post_types = Helper::get_custom_post_types();

foreach ( $custom_post_types as $custom_post_type ) {
	$custom_post_type_object = get_post_type_object( $custom_post_type );

	Framework::section(
		'design-' . $custom_post_type,
		[
			'title'           => __( 'Page settings', 'snow-monkey' ),
			'description'     => __( 'By the type of page displayed on the preview screen on the right side of the screen, the display setting items switched.', 'snow-monkey' ) . sprintf( __( 'Currently %1$s page settings is displayed.', 'snow-monkey' ), $custom_post_type_object->label ),
			'priority'        => 110,
			'active_callback' => function() use ( $custom_post_type_object ) {
				return is_singular( $custom_post_type_object->name );
			},
		]
	);
}
