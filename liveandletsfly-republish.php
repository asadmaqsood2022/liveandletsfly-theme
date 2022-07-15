<?php

/**
 * Live and Let's Fly Republish Post Submit Box.
 * 
 * @since 1.0.0
 * @author Joshua Fach (jfach@frequentflyerservices.com)
 * 
 * @link https://developer.wordpress.org/reference/hooks/post_submitbox_misc_actions/
 */
function liveandletsfly_republish_post_submitbox() {
	global $post;

	if ( get_post_status() !== 'publish' || get_post_type() !== 'post' ) return;

	$liveandletsfly_republish = get_post_meta( $post->ID, 'liveandletsfly_republish', true );

	wp_nonce_field( 'liveandletsfly_republish_save', 'liveandletsfly_republish_nonce' );

	?>
	<div class="misc-pub-section">
		<input type="checkbox" id="liveandletsfly-republish" name="liveandletsfly_republish" value="1" <?php checked( $liveandletsfly_republish ); ?>>
		<label for="liveandletsfly-republish">Republish</label>
	</div>
	<?php
}
add_action( 'post_submitbox_misc_actions', 'liveandletsfly_republish_post_submitbox' );

/**
 * Live and Let's Fly Republish Post Submit Box Save.
 * 
 * @since 1.0.0
 * @author Joshua Fach (jfach@frequentflyerservices.com)
 */
function liveandletsfly_republish_post_submitbox_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['liveandletsfly_republish_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['liveandletsfly_republish_nonce'], 'liveandletsfly_republish_save' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['liveandletsfly_republish'] ) && ! empty( $_POST['liveandletsfly_republish'] ) ) {
		$liveandletsfly_republish = (bool) $_POST['liveandletsfly_republish'];
		update_post_meta( $post_id, 'liveandletsfly_republish', $liveandletsfly_republish );
	} else {
		delete_post_meta( $post_id, 'liveandletsfly_republish' );
	}
}
add_action( 'save_post', 'liveandletsfly_republish_post_submitbox_save', 10, 1 );

/**
 * Live and Let's Fly Republish The GUID.
 * 
 * @since 1.0.0
 * @author Joshua Fach (jfach@frequentflyerservices.com)
 */
function liveandletsfly_republish_the_guid( $guid, $id ) {
	global $post, $wp_query;

	if ( $wp_query->is_feed() ) {
		$liveandletsfly_republish = get_post_meta( $post->ID, 'liveandletsfly_republish', true );

		if ( $liveandletsfly_republish ) $guid = $post->guid . '?republish=' . strtotime( $post->post_date );
	}

	return $guid;
}
add_filter( 'the_guid', 'liveandletsfly_republish_the_guid', PHP_INT_MAX, 2 );
add_filter( 'get_the_guid', 'liveandletsfly_republish_the_guid', PHP_INT_MAX, 2 );
