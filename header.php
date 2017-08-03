<?php get_template_part( 'template-parts/head' ); ?>

<div class="Site">
    <div class="Site-inner">

        <header class="Header"
                role="banner"
        >

            <div class="Header-sidesteps">
                <ul class="Header-sidesteps-list">
                    <li><a href="#Nav"><?php _e( 'Skip to main nav', THISTLE_CHILD_TEXT_DOMAIN ); ?></a></li>
                    <li><a href="#Content"><?php _e( 'Skip to main content', THISTLE_CHILD_TEXT_DOMAIN ); ?></a></li>
                    <li><a href="#Search"><?php _e( 'Skip to search form', THISTLE_CHILD_TEXT_DOMAIN ); ?></a></li>
                </ul>
            </div>

            <div class="Header-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
            </div>

            <div class="Header-search">
                <?php get_search_form(); ?>
            </div>

            <?php if ( has_nav_menu( 'header_menu' ) ) : ?>
            <nav class="Header-navigation"
                 id="Nav"
                 role="navigation"
            >
                <?php wp_nav_menu( array(
                    'theme_location'  => 'header_menu',
                    'container'       => false,
                    'menu_class'      => 'Header-navigation-list',
                    'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                    'depth'           => 2,
                    'item_spacing'    => 'discard'
                ) ); ?>
            </nav>
            <?php endif; ?>

        </header><!-- /.Header -->

        <div class="Body">
