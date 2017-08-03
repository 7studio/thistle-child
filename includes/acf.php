<?php

/**
 * Hides the ACF menu for all users who have not the administrator role.
 *
 * @param bool $show Show/hide ACF menu item. Default to true.
 * @return bool
 */
function tc_acf_hide_option_page( $show ) {
    return current_user_can( 'administrator' );
}
add_filter( 'acf/settings/show_admin', 'tc_acf_hide_option_page', 11 );

/**
 * Formats the value of a field before it is returned to the template with the
 * same process like the title or the excerpt of a post.
 *
 * The filter has the priority 9 in order to be applied just before the ACF one
 * and doesn't strip `<br>` or `<p>` for the textarea fields.
 *
 * @param mixed $value   The value which was loaded from the database.
 * @param mixed $post_id The post ID from which the value was loaded.
 * @param array $field   An array containing all the field settings for
 *                       the field which was used to upload the attachment.
 * @return mixed
 */
function tc_acf_format_value( $value, $post_id, $field ) {
    $value = wp_strip_all_tags( $value );
    $value = wptexturize( $value );
    $value = convert_chars( $value );

    return $value;
}
add_filter( 'acf/format_value/type=textarea', 'tc_acf_format_value', 9, 3 );
add_filter( 'acf/format_value/type=text', 'tc_acf_format_value', 9, 3 );
