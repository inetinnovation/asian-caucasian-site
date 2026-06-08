<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Member CPT — title (name), featured image (avatar), excerpt (bio), Role meta.
 */
add_action( 'init', function () {
	register_post_type( 'ac_member', [
		'labels' => [
			'name'          => __( 'Members', 'asian-caucasian' ),
			'singular_name' => __( 'Member', 'asian-caucasian' ),
			'add_new_item'  => __( 'Add New Member', 'asian-caucasian' ),
			'edit_item'     => __( 'Edit Member', 'asian-caucasian' ),
			'menu_name'     => __( 'Members', 'asian-caucasian' ),
		],
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-groups',
		'menu_position'       => 22,
		'supports'            => [ 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ],
		'has_archive'         => false,
		'rewrite'             => false,
		'exclude_from_search' => true,
	] );
} );

add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'ac_member_role',
		__( 'Role', 'asian-caucasian' ),
		'ac_member_role_meta_box',
		'ac_member',
		'side',
		'default'
	);
} );

function ac_member_role_meta_box( WP_Post $post ): void {
	$role = (string) get_post_meta( $post->ID, '_ac_member_role', true );
	wp_nonce_field( 'ac_member_role_save', 'ac_member_role_nonce' );
	?>
	<p>
		<label for="ac_member_role"><?php esc_html_e( 'Shown under name on the site.', 'asian-caucasian' ); ?></label>
		<input type="text" id="ac_member_role" name="ac_member_role" value="<?php echo esc_attr( $role ); ?>" class="widefat" placeholder="Vocals / Producer">
	</p>
	<?php
}

add_action( 'save_post_ac_member', function ( int $post_id ): void {
	if ( ! isset( $_POST['ac_member_role_nonce'] ) ) return;
	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['ac_member_role_nonce'] ) ), 'ac_member_role_save' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$role = sanitize_text_field( wp_unslash( $_POST['ac_member_role'] ?? '' ) );
	if ( $role !== '' ) {
		update_post_meta( $post_id, '_ac_member_role', $role );
	} else {
		delete_post_meta( $post_id, '_ac_member_role' );
	}
}, 10, 1 );
