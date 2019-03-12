<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 */

use Inc2734\Mimizuku_Core\Core;
use Framework\Helper;

/**
* Uses composer autoloader
*/
require_once( get_template_directory() . '/vendor/autoload.php' );

/**
 * Adjusted due to different directory structure in development and release
 */
spl_autoload_register(
	function( $class ) {
		if ( 0 !== strpos( $class, 'Framework\\' ) ) {
			return;
		}

		$class = str_replace( '\\', '/', $class );
		$file  = get_template_directory() . '/' . $class . '.php';
		if ( file_exists( $file ) ) {
			require_once( $file );
		}
	}
);

/**
 * Make theme available for translation
 *
 * @return void
 */
load_theme_textdomain( 'snow-monkey', get_template_directory() . '/languages' );

/**
 * Loads snow-monkey Bootstrap
 */
new Core();

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = apply_filters( 'snow_monkey_content_width', 1220 );
}

/**
 * Loads theme setup files
 */
$includes = [
	'/app/setup',
	'/app/widget',
];
foreach ( $includes as $include ) {
	Helper::load_theme_files( __DIR__ . $include, true );
}

/**
 * Loads customizer
 */
add_action(
	'init',
	function() {
		$includes = [
			'/app/customizer',
		];
		foreach ( $includes as $include ) {
			Helper::load_theme_files( __DIR__ . $include );
		}
	}
);

/**
 * Output comment for get_template_part()
 */
if ( defined( 'WP_DEBUG' ) && WP_DEBUG && ! is_customize_preview() ) {
	$slugs = [];
	$files = Helper::glob_recursive( get_template_directory() );
	if ( is_child_theme() ) {
		$files = array_merge( $files, Helper::glob_recursive( get_stylesheet_directory() ) );
	}

	foreach ( $files as $file ) {
		$slug = str_replace( [ get_template_directory() . '/', get_stylesheet_directory() . '/', '.php' ], '', $file );
		$slugs[ $slug ] = $slug;
	}

	foreach ( $slugs as $slug ) {
		add_action(
			'get_template_part_' . $slug,
			function( $slug, $name ) {
				if ( $name ) {
					$slug = $slug . '-' . $name;
				}

				printf( "\n" . '<!-- Start : %1$s -->' . "\n", esc_html( $slug ) );
			},
			10,
			2
		);
	}
}
