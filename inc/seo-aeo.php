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
 */
add_action( 'init', function () {
	add_rewrite_rule( '^llms\.txt$', 'index.php?ac_llms=1', 'top' );
} );

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

	$albums = get_terms( [ 'taxonomy' => 'ac_album', 'hide_empty' => false ] );
	$album_lines = '';
	if ( ! is_wp_error( $albums ) ) {
		foreach ( $albums as $a ) $album_lines .= "- {$a->name}\n";
	}

	$members_q = new WP_Query( [ 'post_type' => 'ac_member', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ] );
	$member_lines = '';
	foreach ( $members_q->posts as $m ) {
		$role = (string) get_post_meta( $m->ID, '_ac_member_role', true );
		$member_lines .= '- ' . get_the_title( $m ) . ( $role ? " ({$role})" : '' ) . "\n";
	}

	header( 'Content-Type: text/plain; charset=utf-8' );
	echo "# {$name}\n\n";
	echo "> {$tagline}. Based in {$location}.\n\n";
	echo "## About\n\n";
	echo wp_strip_all_tags( (string) get_theme_mod( 'ac_about_body', '' ) ) . "\n\n";
	echo "## Albums\n\n{$album_lines}\n";
	echo "## Members\n\n{$member_lines}\n";
	echo "## Contact\n\n- Email: {$email}\n- Location: {$location}\n- Website: " . home_url( '/' ) . "\n";
	exit;
} );

/**
 * Flush rewrite rules once after activation so /llms.txt resolves.
 */
add_action( 'after_switch_theme', function () {
	flush_rewrite_rules( false );
} );
