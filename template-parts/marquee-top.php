<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$items = ac_split_marquee( (string) get_theme_mod( 'ac_marquee_top', '' ) );
if ( ! $items ) return;
$loop = array_merge( $items, $items, $items, $items );
?>
<div class="marquee-wrap">
	<div class="marquee-track">
		<?php foreach ( $loop as $item ) : ?>
			<span><?php echo esc_html( $item ); ?></span><span class="dot">✦</span>
		<?php endforeach; ?>
	</div>
</div>
