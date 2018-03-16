<?php

/**
 * @param $value - array of related posts of same post type as $post_id
 * @param $post_id - this post'd ID that is getting edited
 * @param $field - related posts of same post type field info
 * @return mixed
 *
 * Update each post that is added to the $post_id's related posts of same post type.
 */
function bidirectional_acf_update_value( $value, $post_id, $field  ) {
    $field_name = $field['name'];
    $field_key = $field['key'];
    $global_name = 'is_updating_same_post_type_' . $field_name;

    // bail early if this filter was triggered from the update_field() function called within the loop below
    // - this prevents an inifinte loop
    if( !empty($GLOBALS[ $global_name ]) ) return $value;

    // set global variable to avoid inifite loop
    // - could also remove_filter() then add_filter() again, but this is simpler
    $GLOBALS[ $global_name ] = 1;

    // loop over selected posts and add this $post_id
    if( is_array($value) ) {

        foreach( $value as $post_id2 ) {

            // load existing related posts
            $value2 = get_field($field_name, $post_id2, false);

            // allow for selected posts to not contain a value
            if( empty($value2) ) {

                $value2 = array();
            }

            // bail early if the current $post_id is already found in selected post's $value2
            if( in_array($post_id, $value2) ) continue;

            // append the current $post_id to the selected post's 'related_posts' value
            $value2[] = (string) $post_id;

            // update the selected post's value (use field's key for performance)
            update_field($field_key, $value2, $post_id2);
        }
    }

    // find posts which have been removed
    $old_value = get_field($field_name, $post_id, false);

    if( is_array($old_value) ) {

        foreach( $old_value as $post_id2 ) {

            // bail early if this value has not been removed
            if( is_array($value) && in_array($post_id2, $value) ) continue;

            // load existing related posts
            $value2 = get_field($field_name, $post_id2, false);

            // bail early if no value
            if( empty($value2) ) continue;

            // find the position of $post_id within $value2 so we can remove it
            $pos = array_search($post_id, $value2);

            // remove
            unset( $value2[ $pos] );

            // update the un-selected post's value (use field's key for performance)
            update_field($field_key, $value2, $post_id2);
        }
    }

    // reset global varibale to allow this filter to function as per normal
    $GLOBALS[ $global_name ] = 0;

    // return
    return $value;
}

/**
 * @param $related_records_list
 * @param $record_id_being_updated
 * @param $field_of_records_list
 * @param $field_post_name
 * @param $post_type_being_updated
 * @param $field_to_update_inverse_rel
 * @return mixed
 *
 * Generic inverse relationships updates.
 */
function bidirectional_acf_update_value_update($related_records_list, $record_id_being_updated, $field_of_records_list, $field_post_name, $post_type_being_updated, $field_to_update_inverse_rel) {
    $field_artist = get_field_object($field_to_update_inverse_rel);
    $field_name = $field_artist['name']; // meta field 'related_posts' name
    $field_key = $field_artist['key'];
    $global_name = 'is_updating_' . $field_name;

    // bail early if this filter was triggered from the update_field() function called within the loop below
    // - this prevents an infinite loop
    if( !empty($GLOBALS[ $global_name ]) ) return $related_records_list;

    // set global variable to avoid infinite loop
    // - could also remove_filter() then add_filter() again, but this is simpler
    $GLOBALS[ $global_name ] = 1;

    // loop over this post's related_artists and add this $post_id to those artist's related_posts
    if( is_array($related_records_list) ) {

        // $artist_id is each related_artist's artist ID
        foreach( $related_records_list as $post_id ) {

            // load existing artist's related_posts
            $post_artists = get_field($field_name, $post_id, false);

            // allow for selected posts to not contain a value
            if( empty($post_artists) ) {

                $post_artists = array();
            }

            // bail early if the current $post_id is already found in selected artist's $value2
            if( in_array($record_id_being_updated, $post_artists) ) continue;

            // append the current $post_id to the selected artist's 'related_posts' value
            $post_artists[] = $record_id_being_updated;

            // update the selected artist's value (use field's key for performance)
            update_field($field_key, $post_artists, $post_id);
        }
    }

    // find the related_artists' values which have been removed by looking at
    // current post's related_artists before it has been updated
    $old_related_posts = get_field($field_post_name, $record_id_being_updated, false);

    if( is_array($old_related_posts) ) {

        foreach( $old_related_posts as $old_related_post ) {

            // bail early if this value has not been removed
            if( is_array($related_records_list) && in_array($old_related_post, $related_records_list) ) continue;

            // load this loop's artist's existing related_posts
            $old_related_artist = get_field($field_name, $old_related_post, false);

            // bail early if no value
            if( empty($old_related_artist) ) continue;

            // find the position of $post_id within $value2 so we can remove it
            $pos = array_search($record_id_being_updated, $old_related_artist);

            // remove
            unset( $old_related_artist[ $pos] );

            // update the un-selected post's value (use field's key for performance)
            update_field($field_key, $old_related_artist, $old_related_post);
        }
    }

    // reset global varibale to allow this filter to function as per normal
    $GLOBALS[ $global_name ] = 0;

    // return
    return $related_records_list;}

/**
 * @param $related_records_list - array of related_artists
 * @param $record_id_being_updated - this post's ID that is getting edited
 * @param $field_of_records_list - related_artists field info
 * @return mixed
 *
 * Update each post who is added to an artist's related_posts by getting each
 * post, and updating its related_artists by adding/removing this artist to that
 * post's related_artists.
 */
// artist is edited...                               'new related_posts'      'id of artist'       'field for related_posts used for seeing old rel_posts'
// job is to update each post in the list
function bidirectional_acf_update_value_many_many( $related_records_list, $record_id_being_updated, $field_of_records_list ) {
    $field_post_name = $field_of_records_list['name'];
    $post_type_being_updated = get_post_type($record_id_being_updated);

    if (($field_post_name === 'related_posts' && $post_type_being_updated === 'post') ||
        ($field_post_name === 'related_artists' && $post_type_being_updated === 'artist') ||
        ($field_post_name === 'related_people' && $post_type_being_updated === 'person') ||
        ($field_post_name === 'related_products' && $post_type_being_updated === 'product')
    ) {
        return bidirectional_acf_update_value( $related_records_list, $record_id_being_updated, $field_of_records_list  );
    }

    switch (get_post_type($record_id_being_updated)) {
        case 'post':
            $field_to_update_inverse_rel = 'related_posts';
            remove_filter('acf/update_value/name=related_posts', 'bidirectional_acf_update_value_many_many');
            // this func triggered by updating posts so if it itself is a post, then use the self-relating func
            //return bidirectional_acf_update_value( $related_records_list, $record_id_being_updated, $field_of_records_list  );
            break;

        case 'artist':
            $field_to_update_inverse_rel = 'related_artists';
            remove_filter('acf/update_value/name=related_artists', 'bidirectional_acf_update_value_many_many');
            break;

        case 'person':
            $field_to_update_inverse_rel = 'related_people';
            remove_filter('acf/update_value/name=related_people', 'bidirectional_acf_update_value_many_many');
            break;

        case 'product':
            $field_to_update_inverse_rel = 'related_products';
            remove_filter('acf/update_value/name=related_products', 'bidirectional_acf_update_value_many_many');
            break;

        default:
            $field_to_update_inverse_rel = '';
            break;
    }

    return bidirectional_acf_update_value_update($related_records_list, $record_id_being_updated, $field_of_records_list, $field_post_name, $post_type_being_updated, $field_to_update_inverse_rel);
}

add_filter('acf/update_value/name=related_posts', 'bidirectional_acf_update_value_many_many', 10, 3);
add_filter('acf/update_value/name=related_artists', 'bidirectional_acf_update_value_many_many', 11, 3);
add_filter('acf/update_value/name=related_people', 'bidirectional_acf_update_value_many_many', 13, 3);
add_filter('acf/update_value/name=related_products', 'bidirectional_acf_update_value_many_many', 12, 3);
