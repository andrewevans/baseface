<?php
add_action( 'admin_enqueue_scripts', 'enqueue_scripts' );

function enqueue_scripts($hook) {
    if( 'post.php' != $hook ) {
        // Only applies to post editing
        return;
    }

    wp_enqueue_script( 'ajax-script', plugins_url( '/js/artist-mediums.js', __FILE__ ), array('jquery') );
    wp_enqueue_style('ajax-css', plugins_url('/css/artist-mediums.css', __FILE__ ));

    // in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
    wp_localize_script( 'ajax-script', 'ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
}

function change_artist() {
    global $wpdb;

    $artist_id = $_POST['artist_id'];

    $args = array(
        'post_type' => 'artist',
        'p' => $artist_id,
    );

    $terms = wp_get_post_terms( $artist_id, 'mediums', $args );

    $terms_ids = array_map(function($term) {
        return $term->term_id;
    }, $terms);

    wp_send_json($terms_ids);

    wp_die();
}

if ( is_admin() ) {
    add_action( 'wp_ajax_change_artist', 'change_artist' );
}

