<?php
/**
 * Fallback template. Single-page theme — most traffic hits front-page.php;
 * this catches search results, post archives, etc.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>
<main id="primary" class="container" style="padding:8rem 2rem;">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="section-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<h2 class="section-title">Nothing found.</h2>
	<?php endif; ?>
</main>
<?php
get_footer();
