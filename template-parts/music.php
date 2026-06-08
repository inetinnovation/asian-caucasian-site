<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$albums = get_terms( [ 'taxonomy' => 'ac_album', 'hide_empty' => false ] );
?>
<section id="music">
	<div class="container">
		<p class="section-label reveal">// Music</p>
		<h2 class="section-title reveal delay-1">Listen Up</h2>

		<div class="album-tabs reveal delay-2">
			<button class="album-tab active" data-filter="all">All Tracks</button>
			<?php if ( ! is_wp_error( $albums ) ) : foreach ( $albums as $a ) : ?>
				<button class="album-tab" data-filter="<?php echo esc_attr( $a->slug ); ?>"><?php echo esc_html( $a->name ); ?></button>
			<?php endforeach; endif; ?>
		</div>

		<div class="ac-player reveal delay-3">
			<div class="now-playing">
				<div class="np-controls">
					<button class="np-btn" id="prev-btn" aria-label="Previous">
						<svg viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3.5 6 8.5 6V6z"/></svg>
					</button>
					<button class="np-btn play-btn" id="play-btn" aria-label="Play">
						<svg class="icon-play" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
						<svg class="icon-pause" viewBox="0 0 24 24" style="display:none"><path d="M6 19h4V5H6zm8-14v14h4V5z"/></svg>
					</button>
					<button class="np-btn" id="next-btn" aria-label="Next">
						<svg viewBox="0 0 24 24"><path d="M6 18l8.5-6L6 6v12zm2 0h2V6h-2z" transform="scale(-1,1) translate(-24,0)"/></svg>
					</button>
				</div>
				<div class="np-info">
					<div class="np-title" id="np-title">Select a track</div>
					<div class="np-album" id="np-album">Asian Caucasian</div>
				</div>
				<div class="np-time"><span id="time-current">0:00</span> / <span id="time-total">0:00</span></div>
				<div class="np-volume">
					<svg viewBox="0 0 24 24" id="vol-icon"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
					<input type="range" class="volume-slider" id="vol-slider" min="0" max="1" step="0.05" value="0.8" />
				</div>
			</div>
			<div class="progress-wrap">
				<div class="progress-bar" id="progress-bar">
					<div class="progress-fill" id="progress-fill"></div>
				</div>
			</div>
			<ul class="track-list" id="track-list"></ul>
		</div>
	</div>
</section>
