<?php
/*
Plugin Name: Admin Filter BY Custom Fields
Plugin URI: http://en.bainternet.info
Description: answer to http://wordpress.stackexchange.com/q/45436/2487
Version: 1.0
Author: Bainternet
Author URI: http://en.bainternet.info
*/
function get_artists()
{
    $args = array(
        'post_type'        => 'artist',
        'posts_per_page'	=> -1,
        'offset'    => 1,
        'meta_key'			=> 'last_name',
        'orderby'			=> 'meta_value',
        'order'            => 'ASC',
        'post_status'      => 'publish',
    );

    // TODO This does not return any posts on the admin filtered products page
    $artists = get_posts( $args );

    // Include meta data with each artist
    $artists = array_map(function($artist) {
        $artist->meta = get_post_meta($artist->ID);

        return $artist;
    }, $artists);

    return $artists;
}

/**
 * First create the dropdown
 * make sure to change POST_TYPE to the name of your custom post type
 *
 * @author Ohad Raz
 *
 * @return void
 */
function wpse45436_admin_posts_filter_restrict_manage_posts(){
    global $post;

    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if ('product' == $type){

        //change this to the list of values you want to show
        //in 'label' => 'value' format
        $values = [];

        $artists = get_artists();

        foreach ($artists as $artist) {
            $values[$artist->meta['last_name'][0] . ', ' . $artist->meta['first_name'][0]] = $artist->ID;
        }

        ?>
        <select name="ADMIN_FILTER_FIELD_VALUE">
            <option value=""><?php _e('Filter By Artist', 'wose45436'); ?></option>
            <?php
            $current_v = isset($_GET['ADMIN_FILTER_FIELD_VALUE'])? $_GET['ADMIN_FILTER_FIELD_VALUE']:'';
            foreach ($values as $label => $value) {
                printf
                (
                    '<option value="%s"%s>%s</option>',
                    $value,
                    $value == $current_v? ' selected="selected"':'',
                    $label
                );
            }
            ?>
        </select>
        <?php
    }
}

add_action( 'restrict_manage_posts', 'wpse45436_admin_posts_filter_restrict_manage_posts' );

/**
 * if submitted filter by post meta
 *
 * make sure to change META_KEY to the actual meta key
 * and POST_TYPE to the name of your custom post type
 * @author Ohad Raz
 * @param  (wp_query object) $query
 *
 * @return Void
 */
function wpse45436_posts_filter( $query ){
    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'product' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['ADMIN_FILTER_FIELD_VALUE']) && $_GET['ADMIN_FILTER_FIELD_VALUE'] != '') {
        $query->query_vars['meta_key'] = 'single_artist';
        $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
    }
}

add_filter( 'parse_query', 'wpse45436_posts_filter' );
