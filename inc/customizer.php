<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Theme Customizer — all editable text/imagery that isn't a Post or CPT.
 */
add_action( 'customize_register', function ( WP_Customize_Manager $wp ) {

	/* ---------- HERO ---------- */
	$wp->add_section( 'ac_hero', [
		'title'    => __( 'Hero Section', 'asian-caucasian' ),
		'priority' => 30,
	] );

	$wp->add_setting( 'ac_hero_eyebrow', [ 'default' => 'Indianapolis Pop', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp->add_control( 'ac_hero_eyebrow', [ 'label' => 'Eyebrow text', 'section' => 'ac_hero', 'type' => 'text' ] );

	$wp->add_setting( 'ac_hero_subhead', [
		'default' => "Three guys, one questionable band name, and a whole lot of pop music nobody asked for — but everyone keeps listening to.",
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp->add_control( 'ac_hero_subhead', [ 'label' => 'Subheading paragraph', 'section' => 'ac_hero', 'type' => 'textarea' ] );

	$wp->add_setting( 'ac_hero_side_text', [ 'default' => '#7 Indy Pop Charts', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp->add_control( 'ac_hero_side_text', [ 'label' => 'Vertical side text', 'section' => 'ac_hero', 'type' => 'text' ] );

	$wp->add_setting( 'ac_hero_bg_image', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
	$wp->add_control( new WP_Customize_Image_Control( $wp, 'ac_hero_bg_image', [
		'label'   => 'Hero background image (album cover)',
		'section' => 'ac_hero',
	] ) );

	/* ---------- HERO ALBUM CARDS ---------- */
	for ( $i = 1; $i <= 2; $i++ ) {
		$defaults = [
			1 => [ 'label' => 'Christmas Album',  'text' => 'Dasher, Dancer, & Prancer' ],
			2 => [ 'label' => 'Also Streaming',   'text' => 'The American Dream with a Side of Rice' ],
		];
		$wp->add_setting( "ac_hero_album_{$i}_image", [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
		$wp->add_control( new WP_Customize_Image_Control( $wp, "ac_hero_album_{$i}_image", [
			'label' => "Album {$i} thumbnail", 'section' => 'ac_hero',
		] ) );

		$wp->add_setting( "ac_hero_album_{$i}_label", [ 'default' => $defaults[ $i ]['label'], 'sanitize_callback' => 'sanitize_text_field' ] );
		$wp->add_control( "ac_hero_album_{$i}_label", [ 'label' => "Album {$i} label", 'section' => 'ac_hero', 'type' => 'text' ] );

		$wp->add_setting( "ac_hero_album_{$i}_text", [ 'default' => $defaults[ $i ]['text'], 'sanitize_callback' => 'sanitize_text_field' ] );
		$wp->add_control( "ac_hero_album_{$i}_text", [ 'label' => "Album {$i} name", 'section' => 'ac_hero', 'type' => 'text' ] );
	}

	/* ---------- ABOUT ---------- */
	$wp->add_section( 'ac_about', [
		'title'    => __( 'About Section', 'asian-caucasian' ),
		'priority' => 31,
	] );

	$wp->add_setting( 'ac_about_title_html', [
		'default' => 'The Band<br>With That Name',
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp->add_control( 'ac_about_title_html', [ 'label' => 'Section title (HTML allowed)', 'section' => 'ac_about', 'type' => 'textarea' ] );

	$wp->add_setting( 'ac_about_body', [
		'default' => "Yes, we know what you're thinking. <strong>We thought it too.</strong> Then someone said \"what if that was actually a band?\" and here we are — <em>a legitimate pop project</em> out of Indianapolis, Indiana, with a name that makes every first interaction interesting.\n\nAsian Caucasian makes <strong>pop music</strong> — the kind that sneaks into your head during a commute and refuses to leave. We're self-aware enough to find the whole thing funny and serious enough to make songs you'll actually want to play again.\n\nCurrently ranked <em>#7 on the local Indianapolis pop charts</em>. Gunning for #1. Probably.",
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp->add_control( 'ac_about_body', [
		'label' => 'Body copy (one paragraph per blank line)', 'section' => 'ac_about', 'type' => 'textarea',
	] );

	$stat_defaults = [
		1 => [ 'num' => '#7',   'label' => 'Indy Pop Charts' ],
		2 => [ 'num' => 'Pop',  'label' => 'Genre' ],
		3 => [ 'num' => 'Indy', 'label' => 'Home Base' ],
		4 => [ 'num' => '∞',    'label' => 'Awkward Questions About the Name' ],
	];
	foreach ( $stat_defaults as $i => $d ) {
		$wp->add_setting( "ac_stat_{$i}_num", [ 'default' => $d['num'], 'sanitize_callback' => 'sanitize_text_field' ] );
		$wp->add_control( "ac_stat_{$i}_num", [ 'label' => "Stat {$i} value", 'section' => 'ac_about', 'type' => 'text' ] );
		$wp->add_setting( "ac_stat_{$i}_label", [ 'default' => $d['label'], 'sanitize_callback' => 'sanitize_text_field' ] );
		$wp->add_control( "ac_stat_{$i}_label", [ 'label' => "Stat {$i} label", 'section' => 'ac_about', 'type' => 'text' ] );
	}

	/* ---------- MARQUEES ---------- */
	$wp->add_section( 'ac_marquees', [
		'title'    => __( 'Marquees', 'asian-caucasian' ),
		'priority' => 32,
	] );

	$wp->add_setting( 'ac_marquee_top', [
		'default' => 'Asian Caucasian | Indianapolis Pop | #7 Local Charts | New Music Out Now',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp->add_control( 'ac_marquee_top', [ 'label' => 'Top marquee items (separate with |)', 'section' => 'ac_marquees', 'type' => 'textarea' ] );

	$wp->add_setting( 'ac_marquee_bottom', [
		'default' => 'Pop Music | Indianapolis | Late Night Vibes | Good Music | Ridiculous Name | Serious Tunes',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp->add_control( 'ac_marquee_bottom', [ 'label' => 'Bottom marquee items (separate with |)', 'section' => 'ac_marquees', 'type' => 'textarea' ] );

	/* ---------- CONTACT ---------- */
	$wp->add_section( 'ac_contact', [
		'title'    => __( 'Contact Section', 'asian-caucasian' ),
		'priority' => 33,
	] );

	$wp->add_setting( 'ac_contact_title_html', [
		'default' => 'Say Hello<br>(We Dare You)',
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp->add_control( 'ac_contact_title_html', [ 'label' => 'Section title (HTML allowed)', 'section' => 'ac_contact', 'type' => 'textarea' ] );

	$wp->add_setting( 'ac_contact_intro', [
		'default' => "Booking inquiries, press, fan mail, questions about the name — we're reachable. We actually do read these. Usually before the second coffee.",
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp->add_control( 'ac_contact_intro', [ 'label' => 'Intro paragraph', 'section' => 'ac_contact', 'type' => 'textarea' ] );

	$wp->add_setting( 'ac_contact_email', [ 'default' => 'asiancaucasian@gmail.com', 'sanitize_callback' => 'sanitize_email' ] );
	$wp->add_control( 'ac_contact_email', [ 'label' => 'Contact email', 'section' => 'ac_contact', 'type' => 'email' ] );

	$wp->add_setting( 'ac_contact_location', [ 'default' => 'Indianapolis, Indiana', 'sanitize_callback' => 'sanitize_text_field' ] );
	$wp->add_control( 'ac_contact_location', [ 'label' => 'Location', 'section' => 'ac_contact', 'type' => 'text' ] );

	/* ---------- FOOTER ---------- */
	$wp->add_section( 'ac_footer', [
		'title'    => __( 'Footer', 'asian-caucasian' ),
		'priority' => 34,
	] );

	$wp->add_setting( 'ac_footer_tagline', [
		'default' => "Indianapolis Pop · Est. We Don't Talk About It",
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp->add_control( 'ac_footer_tagline', [ 'label' => 'Tagline', 'section' => 'ac_footer', 'type' => 'text' ] );

	$wp->add_setting( 'ac_footer_copy', [
		'default' => '&copy; ' . gmdate( 'Y' ) . " Asian Caucasian. All rights reserved.\nYes, that's really the band name.",
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp->add_control( 'ac_footer_copy', [ 'label' => 'Copyright (one line per blank line)', 'section' => 'ac_footer', 'type' => 'textarea' ] );
} );

/**
 * Helper: split a paragraph block on blank lines.
 *
 * @return string[]
 */
function ac_split_paragraphs( string $text ): array {
	$text  = str_replace( "\r\n", "\n", $text );
	$parts = preg_split( '/\n\s*\n/', trim( $text ) ) ?: [];
	return array_values( array_filter( array_map( 'trim', $parts ), 'strlen' ) );
}

/**
 * Helper: split marquee CSV on pipes.
 *
 * @return string[]
 */
function ac_split_marquee( string $text ): array {
	return array_values( array_filter( array_map( 'trim', explode( '|', $text ) ), 'strlen' ) );
}
