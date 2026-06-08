<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Asian Caucasian is an Indianapolis pop project. Three guys, one questionable band name, and a whole lot of pop music." />
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav id="main-nav">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>#hero" class="nav-logo">Asian<span>Caucasian</span></a>
	<button class="nav-toggle" id="nav-toggle" aria-label="Toggle menu">
		<span></span><span></span><span></span>
	</button>
	<ul class="nav-links" id="nav-links">
		<li><a href="#about" onclick="closeNav()">About</a></li>
		<li><a href="#music" onclick="closeNav()">Music</a></li>
		<li><a href="#members" onclick="closeNav()">Band</a></li>
	</ul>
</nav>
