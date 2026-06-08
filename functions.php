<?php
/**
 * Asian Caucasian theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'AC_THEME_VERSION', '1.0.0' );
define( 'AC_THEME_DIR', get_template_directory() );
define( 'AC_THEME_URI', get_template_directory_uri() );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	register_nav_menus( [ 'primary' => __( 'Primary Menu', 'asian-caucasian' ) ] );
} );

require_once AC_THEME_DIR . '/inc/enqueue.php';
require_once AC_THEME_DIR . '/inc/cpt-track.php';
require_once AC_THEME_DIR . '/inc/cpt-member.php';
require_once AC_THEME_DIR . '/inc/customizer.php';
require_once AC_THEME_DIR . '/inc/seo-aeo.php';

/**
 * Return all tracks ordered by menu_order then title.
 *
 * @return array<int, array{title:string,file:string,album:string}>
 */
function ac_get_tracks(): array {
	$q = new WP_Query( [
		'post_type'      => 'ac_track',
		'posts_per_page' => -1,
		'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
		'no_found_rows'  => true,
	] );

	$out = [];
	foreach ( $q->posts as $p ) {
		$album_terms = get_the_terms( $p->ID, 'ac_album' );
		$album_slug  = ( $album_terms && ! is_wp_error( $album_terms ) ) ? $album_terms[0]->slug : '';
		$file        = (string) get_post_meta( $p->ID, '_ac_audio_url', true );
		if ( ! $file ) continue;
		$out[] = [
			'title' => get_the_title( $p ),
			'file'  => $file,
			'album' => $album_slug,
		];
	}
	return $out;
}

/**
 * Return album-slug => display name map.
 */
function ac_get_album_names(): array {
	$terms = get_terms( [ 'taxonomy' => 'ac_album', 'hide_empty' => false ] );
	$out   = [];
	if ( ! is_wp_error( $terms ) ) {
		foreach ( $terms as $t ) $out[ $t->slug ] = $t->name;
	}
	return $out;
}
