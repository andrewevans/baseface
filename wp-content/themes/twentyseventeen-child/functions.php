<?php
function my_theme_enqueue_styles() {

    $parent_style = 'twentyseventeen-style'; // This is 'twentyseventeen-style' for the Twenty Seventeen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/*
 * Creates only the exact sizes we want by overlapping with the other sizes that already exist.
 */
function remove__and_add_plugin_image_sizes() {

    remove_image_size('twentyseventeen-featured-image');
    add_image_size('twentyseventeen-featured-image', 1024, 1024);
    remove_image_size('twentyseventeen-thumbnail-avatar');
    add_image_size('twentyseventeen-thumbnail-avatar', 150, 150);

    update_option('medium_large_size_w', '0');
    update_option('medium_large_size_h', '0');
}

add_action('init', 'remove__and_add_plugin_image_sizes');
?>

