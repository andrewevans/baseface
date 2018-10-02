<?php
add_filter('admin_init', 'my_general_settings_register_fields');

function my_general_settings_register_fields()
{
    register_setting('general', 'my_homepage_list', 'esc_attr');
    add_settings_field('my_homepage_list', '<label for="my_homepage_list">'.__('Homepage SKUs' , 'my_homepage_list' ).'</label>' , 'my_general_settings_fields_html', 'general');
}

function my_general_settings_fields_html()
{
    $value = preg_replace('/\s+/', '', get_option( 'my_homepage_list', '' ));
    echo '<input type="text" id="my_homepage_list" name="my_homepage_list" value="' . $value . '" class="regular-text code" style="width: 90%" />';
}

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

add_filter( 'gform_field_value_ad_path', 'populate_ad_path' );
function populate_ad_path( $value ) {
    return $_COOKIE['ad_path'];
}

add_filter( 'gform_form_post_get_meta', 'populate_artwork_data' );
function populate_artwork_data( $form ) {

if (! isset($_GET['artwork_sku']) || $_GET['artwork_sku'] == '') {
return $form;
}
    $args = array(
        'posts_per_page'   => 5,
        'offset'           => 0,
        'category'         => '',
        'category_name'    => '',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'include'          => '',
        'exclude'          => '',
        'meta_key'         => '_sku',
        'meta_value'       => $_GET['artwork_sku'],
        'post_type'        => 'product',
        'post_mime_type'   => '',
        'post_parent'      => '',
        'author'	   => '',
        'author_name'	   => '',
        'post_status'      => 'publish',
        'suppress_filters' => true
    );
    $posts = get_posts( $args );

    //Creating drop down item array.
    $items = array();

    //Adding initial blank value.
    $items[] = array( 'text' => '', "value" => '' );

    //Adding post titles to the items array
    foreach ( $posts as $post )
        $items[] = array( 'value' => $post->post_title, 'text' => $post->post_title );

    //TODO: These IDs need to be populated by a config
    $forms = [];
    $forms['bestoffer']['id'] = 3;
    $forms['bestoffer']['artwork_title'] = 10;
    $forms['bestoffer']['artwork_artist'] = 11;

    $forms['contact']['id'] = 1;
    $forms['contact']['artwork_title'] = 7;
    $forms['contact']['artwork_artist'] = 8;

    foreach ( $form['fields'] as &$field ) {

        switch ($form['id']) {
            case $forms['bestoffer']['id']:
                if ( $field->id == $forms['bestoffer']['artwork_title'] ) {
                    $field->defaultValue = $post->post_title;
                }

                if ( $field->id == $forms['bestoffer']['artwork_artist'] ) {
                    $single_artist = get_post(get_post_meta( $post->ID, 'single_artist', true ));
                    $field->defaultValue = $single_artist->post_title;
                }
                break;

            case $forms['contact']['id']:
                if ( $field->id == $forms['contact']['artwork_title'] ) {
                    $field->defaultValue = $post->post_title;
                }

                if ( $field->id == $forms['contact']['artwork_artist'] ) {
                    $single_artist = get_post(get_post_meta( $post->ID, 'single_artist', true ));
                    $field->defaultValue = $single_artist->post_title;
                }
                break;

            default:
                break;
        }
    }

    return $form;
}

/**
 * Best offers that are below half of the regular price are invalid.
 */
add_filter( 'gform_field_validation_3_13', 'bestoffer_validation', 10, 4 );
function bestoffer_validation( $result, $value, $form, $field ) {

    $args = array(
        'posts_per_page'   => 5,
        'offset'           => 0,
        'category'         => '',
        'category_name'    => '',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'include'          => '',
        'exclude'          => '',
        'meta_key'         => '_sku',
        'meta_value'       => $_GET['artwork_sku'],
        'post_type'        => 'product',
        'post_mime_type'   => '',
        'post_parent'      => '',
        'author'	   => '',
        'author_name'	   => '',
        'post_status'      => 'publish',
        'suppress_filters' => true
    );
    $posts = get_posts( $args );

    $price = (int) get_post_meta( $posts[0]->ID, '_regular_price', true);

    if ( $price !== '' && $price > 0 && $result['is_valid'] && intval( $value ) < ($price / 2) ) {
        $result['is_valid'] = false;
        $result['message'] = 'Your offer is too low. Please enter another best offer.';
    }

    return $result;
}
?>
