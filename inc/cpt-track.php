<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Track CPT + Album taxonomy + Audio File URL meta box.
 */
add_action( 'init', function () {
	register_post_type( 'ac_track', [
		'labels' => [
			'name'               => __( 'Tracks', 'asian-caucasian' ),
			'singular_name'      => __( 'Track', 'asian-caucasian' ),
			'add_new_item'       => __( 'Add New Track', 'asian-caucasian' ),
			'edit_item'          => __( 'Edit Track', 'asian-caucasian' ),
			'all_items'          => __( 'All Tracks', 'asian-caucasian' ),
			'menu_name'          => __( 'Tracks', 'asian-caucasian' ),
		],
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-format-audio',
		'menu_position'       => 21,
		'supports'            => [ 'title', 'page-attributes' ],
		'has_archive'         => false,
		'rewrite'             => false,
		'exclude_from_search' => true,
	] );

	register_taxonomy( 'ac_album', 'ac_track', [
		'labels' => [
			'name'          => __( 'Albums', 'asian-caucasian' ),
			'singular_name' => __( 'Album', 'asian-caucasian' ),
			'menu_name'     => __( 'Albums', 'asian-caucasian' ),
		],
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => false,
	] );
} );

/* Audio URL meta box on Track edit screen. */
add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'ac_track_audio',
		__( 'Audio File', 'asian-caucasian' ),
		'ac_track_audio_meta_box',
		'ac_track',
		'normal',
		'high'
	);
} );

function ac_track_audio_meta_box( WP_Post $post ): void {
	$url = (string) get_post_meta( $post->ID, '_ac_audio_url', true );
	wp_nonce_field( 'ac_track_audio_save', 'ac_track_audio_nonce' );
	?>
	<p>
		<label for="ac_audio_url"><strong><?php esc_html_e( 'Audio file URL (MP3)', 'asian-caucasian' ); ?></strong></label><br>
		<input type="url" id="ac_audio_url" name="ac_audio_url" value="<?php echo esc_attr( $url ); ?>" class="widefat" placeholder="https://asiancaucasianmusic.com/wp-content/uploads/music/song.mp3">
	</p>
	<p>
		<button type="button" class="button" id="ac_audio_pick"><?php esc_html_e( 'Choose from Media Library', 'asian-caucasian' ); ?></button>
	</p>
	<script>
	(function(){
		var btn = document.getElementById('ac_audio_pick');
		if (!btn || !window.wp || !wp.media) return;
		var frame;
		btn.addEventListener('click', function(e){
			e.preventDefault();
			if (frame) { frame.open(); return; }
			frame = wp.media({ title: 'Choose audio file', library: { type: 'audio' }, multiple: false, button: { text: 'Use this audio' } });
			frame.on('select', function(){
				var att = frame.state().get('selection').first().toJSON();
				document.getElementById('ac_audio_url').value = att.url;
			});
			frame.open();
		});
	})();
	</script>
	<?php
}

add_action( 'save_post_ac_track', function ( int $post_id ): void {
	if ( ! isset( $_POST['ac_track_audio_nonce'] ) ) return;
	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['ac_track_audio_nonce'] ) ), 'ac_track_audio_save' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$raw = isset( $_POST['ac_audio_url'] ) ? wp_unslash( $_POST['ac_audio_url'] ) : '';
	$url = esc_url_raw( $raw );
	if ( $url ) {
		update_post_meta( $post_id, '_ac_audio_url', $url );
	} else {
		delete_post_meta( $post_id, '_ac_audio_url' );
	}
}, 10, 1 );

/* Enqueue WP media uploader on Track edit screen. */
add_action( 'admin_enqueue_scripts', function ( string $hook ) {
	if ( $hook !== 'post.php' && $hook !== 'post-new.php' ) return;
	$screen = get_current_screen();
	if ( $screen && $screen->post_type === 'ac_track' ) wp_enqueue_media();
} );
