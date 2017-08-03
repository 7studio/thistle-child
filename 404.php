<?php get_template_part( 'template-parts/head' ); ?>

<div class="Site">
    <div class="Site-inner">

        <header class="Header">

            <div class="Header-sidesteps">
                <ul class="Header-sidesteps-list">
                    <li><a href="#Nav"><?php _e( 'Skip to main nav', THISTLE_CHILD_TEXT_DOMAIN ); ?></a></li>
                    <li><a href="#Search"><?php _e( 'Skip to search form', THISTLE_CHILD_TEXT_DOMAIN ); ?></a></li>
                </ul>
            </div>

            <div class="Header-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
            </div>

        </header>

        <div class="Body">

            <div class="Content">

                <div class="Wysiwyg">
                    <h2>Désolé, la page que vous recherchez est introuvable&nbsp;!</h2>
                    <p>Il se peut qu'elle n'existe plus ou que l'adresse de la page soit invalide.<br>Toutes nos excuses pour la gêne occasionnée.</p>
                    <p>Pour continuer votre visite, voici quelques pages qui pourraient vous être utiles&nbsp;: </p>
                    <ol id="Nav">
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Notre page d'accueil</a></li>

                        <?php $last_post = array_shift( (get_posts( array( 'numberposts' => 1 ) )) ); ?>
                        <?php if ( $last_post && ! empty( $last_post->post_title ) ) : ?>
                        <li><a href="<?php the_permalink( $last_post ); ?>">Notre dernier article «&nbsp;<?php echo get_the_title( $last_post ); ?>&nbsp;»</a></li>
                        <?php endif; ?>

                        <li>Si vous pensez qu'il devrait y avoir quelque chose ici, <a href="/contact/">contactez-nous</a></li>
                    </ol>
                    <h3>Vous pouvez également rechercher un contenu similaire&nbsp;: </h3>
                </div>

                <?php get_search_form(); ?>

            </div><!-- /.Content -->

        </div><!-- /.Body -->

    </div><!-- /.Site-inner -->
</div><!-- /.Site -->

<?php get_template_part( 'template-parts/footer' ); ?>
