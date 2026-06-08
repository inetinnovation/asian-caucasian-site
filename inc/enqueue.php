<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'ac-fonts',
		'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'ac-main',
		AC_THEME_URI . '/assets/css/main.css',
		[ 'ac-fonts' ],
		AC_THEME_VERSION
	);

	// Theme stylesheet (registration file) loaded after main so any future overrides win.
	wp_enqueue_style(
		'ac-theme',
		get_stylesheet_uri(),
		[ 'ac-main' ],
		AC_THEME_VERSION
	);

	wp_enqueue_script(
		'ac-main',
		AC_THEME_URI . '/assets/js/main.js',
		[],
		AC_THEME_VERSION,
		true
	);

	wp_localize_script( 'ac-main', 'acTracks', ac_get_tracks() );
	wp_localize_script( 'ac-main', 'acAlbumNames', ac_get_album_names() );
} );

add_action( 'wp_head', function () {
	// Preconnect to fonts.gstatic for performance.
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1 );
