<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$paragraphs = ac_split_paragraphs( (string) get_theme_mod( 'ac_about_body', '' ) );
?>
<section id="about">
	<div class="container">
		<div class="about-inner">
			<div class="about-text reveal-left">
				<p class="section-label">// About</p>
				<h2 class="section-title"><?php echo wp_kses_post( get_theme_mod( 'ac_about_title_html', 'The Band<br>With That Name' ) ); ?></h2>
				<?php foreach ( $paragraphs as $p ) : ?>
					<p><?php echo wp_kses_post( $p ); ?></p>
				<?php endforeach; ?>
			</div>
			<div class="about-stats reveal-right">
				<?php for ( $i = 1; $i <= 4; $i++ ) :
					$num   = get_theme_mod( "ac_stat_{$i}_num", '' );
					$label = get_theme_mod( "ac_stat_{$i}_label", '' );
					if ( ! $num && ! $label ) continue; ?>
					<div class="stat-card delay-<?php echo (int) $i; ?>">
						<div class="stat-num"><?php echo esc_html( $num ); ?></div>
						<div class="stat-label"><?php echo esc_html( $label ); ?></div>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</div>
</section>
