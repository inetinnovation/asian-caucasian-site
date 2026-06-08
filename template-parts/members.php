<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$q = new WP_Query( [
	'post_type'      => 'ac_member',
	'posts_per_page' => -1,
	'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
	'no_found_rows'  => true,
] );
if ( ! $q->have_posts() ) return;
?>
<section id="members">
	<div class="container">
		<p class="section-label reveal">// The People</p>
		<h2 class="section-title reveal delay-1">Meet the Band</h2>
		<div class="members-grid">
			<?php $i = 0; while ( $q->have_posts() ) : $q->the_post(); $i++;
				$role = (string) get_post_meta( get_the_ID(), '_ac_member_role', true );
			?>
				<div class="member-card reveal delay-<?php echo (int) min( $i, 4 ); ?>">
					<div class="member-avatar">
						<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'medium', [ 'alt' => esc_attr( get_the_title() ) ] );
						} ?>
					</div>
					<div class="member-name"><?php the_title(); ?></div>
					<?php if ( $role ) : ?>
						<div class="member-role"><?php echo esc_html( $role ); ?></div>
					<?php endif; ?>
					<p class="member-bio"><?php echo esc_html( get_the_excerpt() ); ?></p>
				</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
