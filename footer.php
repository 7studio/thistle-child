    	</div><!-- /.Body -->

    	<footer class="Footer"
                role="contentinfo"
        >

    		<?php wp_nav_menu( array(
                'theme_location'  => 'footer_menu',
                'container'       => 'nav',
                'container_class' => 'Footer-navigation',
                'menu_class'      => 'Footer-navigation-list',
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                'depth'           => 1,
                'item_spacing'    => 'discard'
            ) ); ?>

    	</footer><!-- /.Footer -->

    </div><!-- /.Site-inner -->
</div><!-- /.Site -->

<?php get_template_part( 'template-parts/footer' ); ?>
