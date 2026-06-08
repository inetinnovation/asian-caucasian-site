<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$bg     = (string) get_theme_mod( 'ac_hero_bg_image', '' );
$album1 = [
	'image' => (string) get_theme_mod( 'ac_hero_album_1_image', '' ),
	'label' => (string) get_theme_mod( 'ac_hero_album_1_label', 'Christmas Album' ),
	'text'  => (string) get_theme_mod( 'ac_hero_album_1_text', 'Dasher, Dancer, & Prancer' ),
];
$album2 = [
	'image' => (string) get_theme_mod( 'ac_hero_album_2_image', '' ),
	'label' => (string) get_theme_mod( 'ac_hero_album_2_label', 'Also Streaming' ),
	'text'  => (string) get_theme_mod( 'ac_hero_album_2_text', 'The American Dream with a Side of Rice' ),
];
?>
<section id="hero">
	<div class="hero-bg">
		<?php if ( $bg ) : ?>
			<img class="hero-bg-img bg-back" src="<?php echo esc_url( $bg ); ?>" alt="" />
		<?php elseif ( $album1['image'] ) : ?>
			<img class="hero-bg-img bg-back" src="<?php echo esc_url( $album1['image'] ); ?>" alt="" />
		<?php endif; ?>
		<?php if ( $album2['image'] ) : ?>
			<img class="hero-bg-img bg-front" src="<?php echo esc_url( $album2['image'] ); ?>" alt="" />
		<?php endif; ?>
	</div>

	<div class="hero-content">
		<p class="hero-eyebrow reveal"><?php echo esc_html( get_theme_mod( 'ac_hero_eyebrow', 'Indianapolis Pop' ) ); ?></p>
		<h1 class="hero-title">
			<span class="line-1 reveal delay-1">Asian</span>
			<span class="line-2 reveal delay-2">Caucasian</span>
		</h1>
		<hr class="hero-rule reveal delay-2" />
		<p class="hero-sub reveal delay-3">
			<?php echo wp_kses_post( get_theme_mod( 'ac_hero_subhead', '' ) ); ?>
		</p>
		<div class="hero-cta reveal delay-4">
			<a href="#music" class="btn btn-primary">
				<svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
				Play Music
			</a>
			<a href="#members" class="btn btn-ghost">About the Band</a>
		</div>
	</div>

	<?php if ( $album1['image'] || $album2['image'] ) : ?>
	<div class="hero-bottom reveal delay-4">
		<?php foreach ( [ $album1, $album2 ] as $a ) : if ( ! $a['image'] ) continue; ?>
			<div class="album-mini">
				<img src="<?php echo esc_url( $a['image'] ); ?>" alt="<?php echo esc_attr( $a['text'] ); ?>" />
				<div>
					<div class="album-mini-label"><?php echo esc_html( $a['label'] ); ?></div>
					<div class="album-mini-text"><?php echo esc_html( $a['text'] ); ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<div class="hero-side">
		<div class="side-line"></div>
		<span class="side-text"><?php echo esc_html( get_theme_mod( 'ac_hero_side_text', '#7 Indy Pop Charts' ) ); ?></span>
		<div class="side-line"></div>
	</div>
</section>
