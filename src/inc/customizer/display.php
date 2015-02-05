<?php
/**
 * @package Make
 */

if ( ! function_exists( 'ttfmake_css_add_rules' ) ) :
/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * This function reads in the options from theme mods and determines whether a CSS rule is needed to implement an
 * option. CSS is only written for choices that are non-default in order to avoid adding unnecessary CSS. All options
 * are also filterable allowing for more precise control via a child theme or plugin.
 *
 * Note that all CSS for options is present in this function except for the CSS for fonts and the logo, which require
 * a lot more code to implement.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function ttfmake_css_add_rules() {
	/**
	 * Featured image alignment
	 */
	$templates = array(
		'blog',
		'archive',
		'search',
		'post',
		'page'
	);

	foreach ( $templates as $template_name ) {
		$key       = 'layout-' . $template_name . '-featured-images-alignment';
		$default   = ttfmake_get_default( $key );
		$alignment = ttfmake_sanitize_choice( get_theme_mod( $key, $default ), $key );

		if ( $alignment !== $default ) {
			ttfmake_get_css()->add( array(
				'selectors'    => array( '.' . $template_name . ' .entry-header .entry-thumbnail' ),
				'declarations' => array(
					'text-align' => $alignment,
				)
			) );
		}
	}
}
endif;

add_action( 'make_css', 'ttfmake_css_add_rules' );

if ( ! function_exists( 'ttfmake_maybe_add_with_avatar_class' ) ) :
/**
 * Add a class to the bounding div if a post uses an avatar with the author byline.
 *
 * @since  1.0.11.
 *
 * @param  array     $classes    An array of post classes.
 * @param  string    $class      A comma-separated list of additional classes added to the post.
 * @param  int       $post_ID    The post ID.
 * @return array                 The modified post class array.
 */
function ttfmake_maybe_add_with_avatar_class( $classes, $class, $post_ID ) {
	$author_key    = 'layout-' . ttfmake_get_view() . '-post-author';
	$author_option = ttfmake_sanitize_choice( get_theme_mod( $author_key, ttfmake_get_default( $author_key ) ), $author_key );

	if ( 'avatar' === $author_option ) {
		$classes[] = 'has-author-avatar';
	}

	return $classes;
}
endif;

add_filter( 'post_class', 'ttfmake_maybe_add_with_avatar_class', 10, 3 );