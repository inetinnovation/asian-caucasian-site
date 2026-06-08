<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * JSON-LD MusicGroup + MusicAlbum schema, llms.txt route, robots meta.
 * Complements Rank Math (which handles Article/sitemap/meta).
 */
add_action( 'wp_head', function () {
	if ( ! is_front_page() ) return;

	$site_name    = get_bloginfo( 'name' );
	$site_url     = home_url( '/' );
	$contact_mail = (string) get_theme_mod( 'ac_contact_email', 'asiancaucasian@gmail.com' );
	$location     = (string) get_theme_mod( 'ac_contact_location', 'Indianapolis, Indiana' );

	$members_q = new WP_Query( [
		'post_type'      => 'ac_member',
		'posts_per_page' => -1,
		'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
		'no_found_rows'  => true,
	] );

	$members = [];
	foreach ( $members_q->posts as $m ) {
		$members[] = [
			'@type' => 'Person',
			'name'  => get_the_title( $m ),
		];
	}

	$album_terms = get_terms( [ 'taxonomy' => 'ac_album', 'hide_empty' => false ] );
	$albums      = [];
	if ( ! is_wp_error( $album_terms ) ) {
		foreach ( $album_terms as $t ) {
			$albums[] = [
				'@type'    => 'MusicAlbum',
				'name'     => $t->name,
				'byArtist' => [ '@type' => 'MusicGroup', 'name' => $site_name ],
			];
		}
	}

	$schema = [
		'@context' => 'https://schema.org',
		'@type'    => 'MusicGroup',
		'name'     => $site_name,
		'url'      => $site_url,
		'email'    => $contact_mail,
		'genre'    => 'Pop',
		'foundingLocation' => [ '@type' => 'Place', 'name' => $location ],
		'member'   => $members,
		'album'    => $albums,
	];

	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) . "</script>\n";
}, 20 );

/**
 * /llms.txt route — citable summary for AI engines.
 * Matched super-early in the request lifecycle to avoid WordPress's
 * canonical-trailing-slash redirect (which would turn /llms.txt into /llms.txt/).
 */
add_action( 'parse_request', function ( WP $wp ) {
	$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : '';
	if ( $path === '/llms.txt' || $path === '/llms.txt/' ) {
		$wp->query_vars['ac_llms'] = 1;
	}
} );

add_filter( 'redirect_canonical', function ( $redirect_url, $requested_url ) {
	$path = wp_parse_url( $requested_url, PHP_URL_PATH );
	if ( $path === '/llms.txt' || $path === '/llms.txt/' ) return false;
	return $redirect_url;
}, 10, 2 );

add_filter( 'query_vars', function ( array $vars ) {
	$vars[] = 'ac_llms';
	return $vars;
} );

add_action( 'template_redirect', function () {
	if ( ! get_query_var( 'ac_llms' ) ) return;

	$name     = get_bloginfo( 'name' );
	$tagline  = (string) get_theme_mod( 'ac_footer_tagline', 'Indianapolis Pop' );
	$location = (string) get_theme_mod( 'ac_contact_location', 'Indianapolis, Indiana' );
	$email    = (string) get_theme_mod( 'ac_contact_email', 'asiancaucasian@gmail.com' );

	$decode = static fn( string $s ): string => html_entity_decode( $s, ENT_QUOTES | ENT_HTML5, 'UTF-8' );

	$albums = get_terms( [ 'taxonomy' => 'ac_album', 'hide_empty' => false ] );
	$album_lines = '';
	if ( ! is_wp_error( $albums ) ) {
		foreach ( $albums as $a ) $album_lines .= '- ' . $decode( $a->name ) . "\n";
	}

	$members_q = new WP_Query( [ 'post_type' => 'ac_member', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ] );
	$member_lines = '';
	foreach ( $members_q->posts as $m ) {
		$role = (string) get_post_meta( $m->ID, '_ac_member_role', true );
		$member_lines .= '- ' . $decode( get_the_title( $m ) ) . ( $role ? " ({$role})" : '' ) . "\n";
	}

	$about_default = (string) get_theme_mod( 'ac_about_body' );
	$about_text    = trim( $decode( wp_strip_all_tags( $about_default ) ) );

	header( 'Content-Type: text/plain; charset=utf-8' );
	echo "# " . $decode( $name ) . "\n\n";
	echo '> ' . $decode( $tagline ) . '. Based in ' . $decode( $location ) . ".\n\n";
	if ( $about_text !== '' ) echo "## About\n\n{$about_text}\n\n";
	echo "## Albums\n\n{$album_lines}\n";
	echo "## Members\n\n{$member_lines}\n";
	echo "## Contact\n\n- Email: {$email}\n- Location: " . $decode( $location ) . "\n- Website: " . home_url( '/' ) . "\n";
	exit;
} );

/**
 * Flush rewrite rules once after activation so /llms.txt resolves.
 */
add_action( 'after_switch_theme', function () {
	flush_rewrite_rules( false );
} );
