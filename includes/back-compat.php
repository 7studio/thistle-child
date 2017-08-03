<?php
/**
 * Thistle child back compat functionality
 *
 * Prevents Thistle child from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 */

/**
 * Prevents from switching to Thistle on old versions of WordPress.
 *
 * Switches to the default theme.
 */
function thistle_switch_theme() {
    switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

    unset( $_GET['activated'] );

    add_action( 'admin_notices', 'thistle_upgrade_notice' );
}
add_action( 'after_switch_theme', 'thistle_switch_theme' );

/**
 * Returns the message for an old version of WordPress.
 *
 * @global string $wp_version WordPress version.
 *
 * @return string Message for an old versions of WordPress.
 */
function thistle_back_compat_message() {
    return sprintf( __( "Thistle Child requires at least WordPress version %1$s. You are running version %2$s. Please upgrade and try again.", THISTLE_CHILD_TEXT_DOMAIN ), THISTLE_CHILD_MIN_WP_VERSION, get_bloginfo( 'version' ) );
}

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Thistle on WordPress versions prior to 4.7.
 */
function thistle_upgrade_notice() {
    printf( '<div class="error"><p>%s</p></div>', thistle_back_compat_message() );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 */
function thistle_customize() {
    wp_die( thistle_back_compat_message(), '', array( 'back_link' => true ) );
}
add_action( 'load-customize.php', 'thistle_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 */
function thistle_preview() {
    if ( isset( $_GET['preview'] ) ) {
        wp_die( thistle_back_compat_message() );
    }
}
add_action( 'template_redirect', 'thistle_preview' );
