<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<footer>
	<div class="footer-inner">
		<div class="footer-logo">Asian<span>Caucasian</span></div>
		<p class="footer-tagline"><?php echo esc_html( get_theme_mod( 'ac_footer_tagline', "Indianapolis Pop · Est. We Don't Talk About It" ) ); ?></p>
		<div class="footer-divider"></div>
		<p class="footer-copy">
			<?php
			$copy_lines = ac_split_paragraphs( (string) get_theme_mod( 'ac_footer_copy', '' ) );
			$lines_html = [];
			foreach ( $copy_lines as $line ) $lines_html[] = wp_kses_post( $line );
			echo implode( '<br>', $lines_html );
			?>
		</p>
	</div>
</footer>

<button id="back-top" aria-label="Back to top" onclick="window.scrollTo({top:0,behavior:'smooth'})">↑</button>

<?php wp_footer(); ?>
</body>
</html>
