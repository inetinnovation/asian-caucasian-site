<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<main id="primary" class="container" style="padding:8rem 2rem; max-width:760px;">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h1 class="section-title" style="font-size:clamp(2.5rem,6vw,4.5rem);"><?php the_title(); ?></h1>
			<div class="entry-content"><?php the_content(); ?></div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer();
