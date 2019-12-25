<?php
add_action( 'admin_enqueue_scripts', 'enqueue_scripts' );

function enqueue_scripts() {
    $screen = get_current_screen();

    if ($screen->post_type !== 'product') {

        return; // Only applies to product editing
    }

    wp_enqueue_script( 'ajax-script', plugins_url( '/js/artist-mediums.js', __FILE__ ), array('jquery') );
    wp_enqueue_style('ajax-css', plugins_url('/css/artist-mediums.css', __FILE__ ));
}

/**
 * Returns term IDs, that are associated with the artist chosen, in JSON format
 * to AJAX requests.
 */
function change_artist() {
    global $wpdb;

    $artist_id = $_POST['artist_id']; // Artist ID

    $args = ['fields' => 'tt_ids']; // Only return the IDs

    // Get all the term IDs that are associated with this artist
    $terms_ids = wp_get_post_terms( $artist_id, 'mediums', $args );

    // TODO Needs to return an updated terms section that is formatted by WP

    wp_send_json($terms_ids); // return term IDs in JSON format to AJAX request

    wp_die();
}

if ( is_admin() ) {
    // TODO Action needs to be exact string as frontend.
    add_action( 'wp_ajax_change_artist', 'change_artist' );
}
