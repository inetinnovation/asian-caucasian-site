<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<main id="primary" class="container" style="padding:10rem 2rem; text-align:center;">
	<p class="section-label" style="justify-content:center;">// 404</p>
	<h1 class="section-title">Lost the beat.</h1>
	<p style="margin:1.5rem 0 2rem; color: var(--muted);">That page isn't here. Try the front door.</p>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">Back to Home</a>
</main>
<?php get_footer();
