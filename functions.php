<?php

/**
 * Exits if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Cheatin&#8217; uh?' );
}

define( 'THISTLE_CHILD_MIN_WP_VERSION', '4.7' );
define( 'THISTLE_CHILD_TEXT_DOMAIN', 'thistle-tc' );
define( 'THISTLE_CHILD_URI',  get_theme_file_uri() );
define( 'THISTLE_CHILD_PATH', get_theme_file_path() );

/**
 * Checks WordPress version to ensure the proper functioning of this theme.
 * This one only works in WordPress 4.7 or later.
 */
if ( version_compare( get_bloginfo( 'version' ), THISTLE_CHILD_MIN_WP_VERSION, '<' ) ) {
    require_once THISTLE_CHILD_PATH . '/includes/back-compat.php';
    return;
}

/**
 * Sets the content width based on the theme's design and stylesheet.
 * This width is also used to oEmbed elements.
 */
function tc_content_width() {
    global $content_width;

    $content_width = 1240;
}
add_action( 'after_setup_theme', 'tc_content_width', 0 );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tc_setup_theme() {
    /**
     * Makes theme available for translation.
     */
    load_child_theme_textdomain( THISTLE_CHILD_TEXT_DOMAIN, THISTLE_CHILD_PATH . '/languages'  );

    /**
     * Registers two custom navigation menus which will be used
     * through `wp_nav_menu()` in two locations.
     */
    register_nav_menus( array(
        'header_menu' => __( 'Main naviagtion', THISTLE_CHILD_TEXT_DOMAIN ),
        'footer_menu' => __( 'Footer navigation', THISTLE_CHILD_TEXT_DOMAIN ),
    ) );
}
add_action( 'after_setup_theme', 'tc_setup_theme', 11 );

/**
 * Redefines the support of Post Thumbnails for PTs.
 *
 * By default, Thistle registers support for Post Thumbnails only on post and page PTs
 * into the `after_setup_theme`. As it would be stupid to redefine
 * the whole `thistle_setup_theme` function, we override support here before
 * everyone (priority 0).
 */
function tc_add_post_thumbnails_support() {
    add_theme_support( 'post-thumbnails', array( 'post', 'page', 'product', 'event' ) );
}
//add_action( 'init', 'tc_add_post_thumbnails_support', 0 );

/**
 * Disables "default" widgets which aren't supported by the theme.
 */
function tc_unregister_wp_widgets() {
    global $wp_widget_factory;

    $wp_supported_widgets = array( 'WP_Widget_Categories', 'WP_Widget_Search', 'WP_Widget_Text' );

    foreach ( $wp_widget_factory->widgets as $class => $object ) {
        if ( ! in_array( $class, $wp_supported_widgets ) ) {
            unregister_widget( $class );
        }
    }
}
//add_action( 'widgets_init', 'tc_unregister_wp_widgets', 1 );

/**
 * Changes TinyMCE configuration.
 *
 * @param $mceInit array An array with TinyMCE config.
 * @return array
 */
function tc_tiny_mce_before_init( $mceInit ) {
	$mceInit['indentation'] = '20px';

	return $mceInit;
}
add_filter( 'tiny_mce_before_init', 'tc_tiny_mce_before_init', 11 );

/**
 * Specifies a map of the text colors that will appear in the grid of
 * the textcolor plugin.
 * By default, the map is empty and the textcolor plugin is pulled out.
 */
function tc_tiny_mce_textcolor_map( $textcolor_map ) {
    return array(
        'f0690d' => 'Orange',
        '30aeab' => 'Blue'
    );
}
//add_filter( 'thistle_tiny_mce_textcolor_map', 'tc_tiny_mce_textcolor_map' );

/**
 * Removes the "WordPress News" widget on the admin panel dashboard for
 * users who are not administrator.
 */
function tc_remove_dashboard_primary_widget() {
    if ( ! current_user_can( 'administrator' ) ) {
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );

        add_action( 'admin_footer-index.php', 'tc_hide_dashboard_primary_help' );
    }
}
add_action( 'wp_dashboard_setup', 'tc_remove_dashboard_primary_widget', 11 );

function tc_hide_dashboard_primary_help() {
?>
    <script>jQuery('#tab-panel-help-content p:nth-child(5)').addClass('hidden');</script>
<?php
}

/**
 * Adds cdn.polyfill.io as ressource hint to notify the client that we'll need it
 * later and helps the browser to resolve the DNS as quickly as possible.
 *
 * Polyfill.io will help us to use some useful JavaScript features like Promise,
 * `Object.assign` or `Array.findIndex` in all browsers :D
 *
 * @link https://cdn.polyfill.io/v2/docs/
 *
 * @param array   URLs to print for ressource hints.
 * @param $string The relation type the URLs are printed for, e.g. 'preconect'.
 * @return array
 */
function tc_prefetch_polyfillio( $urls, $relation_type ) {
    if ( $relation_type == 'dns-prefetch' ) {
        $urls['polyfill_io'] = 'https://cdn.polyfill.io';
    }

    return $urls;
}
add_filter( 'wp_resource_hints', 'tc_prefetch_polyfillio', 11, 2 );

/**
 * Reduces the list of oEmbed providers.
 *
 * @link https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F
 *
 * @param array $providers An array of popular oEmbed providers.
 * @return array
 */
function tc_limit_oembed_providers( $providers ) {
    $allowed_providers = array(
        'YouTube'          => 'https://www.youtube.com/oembed',
        'Vimeo'            => 'https://vimeo.com/api/oembed.{format}',
        'Daylimotion'      => 'https://www.dailymotion.com/services/oembed',
        'Flickr'           => 'https://www.flickr.com/services/oembed',
        'Instagram'        => 'https://api.instagram.com/oembed',
        'Slideshare'       => 'https://www.slideshare.net/api/oembed/2',
        'SoundCloud'       => 'https://soundcloud.com/oembed',
        'Spotify'          => 'https://embed.spotify.com/oembed/',
        'Speaker Deck'     => 'https://speakerdeck.com/oembed.{format}',
        'Facebook (post)'  => 'https://www.facebook.com/plugins/post/oembed.json/',
        'Facebook (video)' => 'https://www.facebook.com/plugins/video/oembed.json/',
        'Twitter'          => 'https://publish.twitter.com/oembed',
        'Giphy'            => 'https://giphy.com/services/oembed'
    );

    $providers = array_filter( $providers, function( $p ) use( $allowed_providers ) {
        return in_array( $p[0], $allowed_providers );
    } );

    return $providers;
}
add_filter( 'oembed_providers', 'tc_limit_oembed_providers', 11 );

/**
 * Increases JPEG quality in the 'edit_image' context.
 *
 * By default, the JPEG quality is 82, so we don't need to reduce it through
 * the `jpeg_quality` filter or/and `wp_editor_set_quality`.
 * But when you edit an image (rotate, crop, etc), the JPEG quality is reduced
 * one more time to 90.
 *
 * @param int    $quality Quality level between 0 (low) and 100 (high) of the JPEG.
 * @param string $context Context of the filter.
 * @return int
 */
function tc_change_edit_jpeg_quality( $quality, $context ) {
    if ( $context == 'edit_image' ) {
        $quality = 100;
    }

    return $quality;
}
add_filter( 'jpeg_quality', 'tc_change_edit_jpeg_quality', 11, 2 );

require_once THISTLE_CHILD_PATH . '/includes/acf.php';
