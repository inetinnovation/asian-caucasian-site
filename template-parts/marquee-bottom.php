<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$items = ac_split_marquee( (string) get_theme_mod( 'ac_marquee_bottom', '' ) );
if ( ! $items ) return;
$loop = array_merge( $items, $items, $items );
?>
<div class="marquee-wrap dark">
	<div class="marquee-track" style="animation-direction:reverse;">
		<?php foreach ( $loop as $i => $item ) : ?>
			<span class="<?php echo ( $i % 2 ) ? 'hi' : ''; ?>"><?php echo esc_html( $item ); ?></span><span class="dot">·</span>
		<?php endforeach; ?>
	</div>
</div>
