<?php

if ( ! function_exists( 'get_html_class' ) ) :
/**
 * Retrieve the classes for the html element as an array.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
function get_html_class( $class = '' ) {
	$classes = array();
	if ( ! empty( $class ) ) {
		if ( !is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}
	$classes = array_map( 'esc_attr', $classes );
	/**
	 * Filter the list of CSS html classes for the current post or page.
	 *
	 * @param array  $classes An array of html classes.
	 * @param string $class   A comma-separated list of additional classes added to the html.
	 */
	$classes = apply_filters( 'html_class', $classes, $class );
	return array_unique( $classes );
}
endif;


if ( ! function_exists( 'html_class' ) ) :
/**
 * Display the classes for the html element.
 *
 * @param string|array $class One or more classes to add to the class list.
 */
function html_class( $class = '' ) {
	// Separates classes with a single space, collates classes for html element
	echo 'class="' . join( ' ', get_html_class( $class ) ) . '"';
}
endif;


if ( ! function_exists( 'get_boundary_post_for_type' ) ) :
/**
 * Retrieve boundary post for custom post types.
 *
 * Boundary being either the first or last post by publish date within the constraints specified
 * by $in_same_term or $excluded_terms.
 *
 * Should be added soon in WP Core. https://core.trac.wordpress.org/ticket/27094
 *
 * @param string       $type           Optional. Post type.
 * @param bool         $in_same_term   Optional. Whether returned post should be in a same taxonomy term.
 * @param array|string $excluded_terms Optional. Array or comma-separated list of excluded term IDs.
 * @param bool         $start          Optional. Whether to retrieve first or last post.
 * @param string       $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'category'.
 * @return null|array Array containing the boundary post object if successful, null otherwise.
 */
function get_boundary_post_for_type( $type = null, $in_same_term = false, $excluded_terms = '', $start = true, $taxonomy = 'category' ) {
	$post = get_post();
	if ( ! $post || ! is_single() || is_attachment() || ! taxonomy_exists( $taxonomy ) ) {
		return null;
	}
	$query_args = array(
		'numberposts'            => 1,
		'order'                  => $start ? 'ASC' : 'DESC',
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'suppress_filters'       => false,
	);
	if ( ! $type ) {
		$type = get_post_type( $post );
	}
	if ( $type ) {
		$query_args['post_type'] = $type;
	}
	$term_array = array();
	if ( ! is_array( $excluded_terms ) ) {
		if ( ! empty( $excluded_terms ) ) {
			$excluded_terms = explode( ',', $excluded_terms );
		} else {
			$excluded_terms = array();
		}
	}
	if ( $in_same_term || ! empty( $excluded_terms ) ) {
		if ( $in_same_term ) {
			$term_array = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
		}
		if ( ! empty( $excluded_terms ) ) {
			$excluded_terms = array_map( 'intval', $excluded_terms );
			$excluded_terms = array_diff( $excluded_terms, $term_array );
			$inverse_terms = array();
			foreach ( $excluded_terms as $excluded_term ) {
				$inverse_terms[] = $excluded_term * -1;
			}
			$excluded_terms = $inverse_terms;
		}
		$query_args[ 'tax_query' ] = array( array(
			'taxonomy' => $taxonomy,
			'terms' => array_merge( $term_array, $excluded_terms )
		) );
	}
	return get_posts( $query_args );
}
endif;


if ( ! function_exists( 'youtube_id' ) ) :
/**
 * Get YouTube ID from URL.
 * https://gist.github.com/MarioRicalde/1163103
 * @param  string $url YouTube URL
 * @return string      Video ID
 */
function youtube_id( $url ) {
	// Regular Expression (the magic).
	$regexp = '/^https?:\/\/(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?(?=.*v=([\w\-]+))(?:\S+)?|([\w\-]+))$/i';
		  
	// Match a URL.
	preg_match( $regexp, $url, $matches );
	
	// Remove empty values from the array (regexp shit).
	$matches = array_filter( $matches, function( $var ) {
		return $var !== '';
	} );
	
	// If we have 2 elements in array, it means we got a valid url!
	// $matches[1] is the youtube ID!
	if ( count( $matches ) === 2 ) {
		return $matches[1];
	}
	return null;
}
endif;


/**
 * String split unicode
 * 
 * @see  http://php.net/manual/fr/function.str-split.php
 */
function str_split_unicode( $str, $l = 0 ) {
	if ($l > 0) {
		$ret = array();
		$len = mb_strlen($str, "UTF-8");
		for ($i = 0; $i < $len; $i += $l) {
			$ret[] = mb_substr($str, $i, $l, "UTF-8");
		}
		return $ret;
	}
	return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}


/**
 * Embed oembed HTML
 *
 * @see  https://wordpress.org/support/topic/adding-a-wrapping-div-to-video-embeds/#post-2671537
 */
add_filter('embed_oembed_html', 'pup_embed_oembed_html', 99, 4);

function pup_embed_oembed_html($html, $url, $attr, $post_id) {
	
	return '<div class="embed-container">' . $html . '</div>';
}