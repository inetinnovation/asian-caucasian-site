<?php
/**
 * Front page — single-page layout for asiancaucasianmusic.com.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

get_template_part( 'template-parts/hero' );
get_template_part( 'template-parts/marquee', 'top' );
get_template_part( 'template-parts/about' );
get_template_part( 'template-parts/music' );
get_template_part( 'template-parts/marquee', 'bottom' );
get_template_part( 'template-parts/members' );
get_template_part( 'template-parts/contact' );

get_footer();
