<?php get_header() ?>

<?php if ( have_posts() ) : ?>
<div class="Content">

    <?php while ( have_posts() ) : the_post(); ?>
    <main class="Post">
        <h1 class="Post-headline"><?php the_title(); ?></h1>
        <div class="Post-description"><?php the_excerpt(); ?></div>
        <div class="Post-body">
            <div class="Wysiwyg">
                <?php the_content(); ?>
            </div>

        </div>
        <footer class="Post-footer"></footer>
    </main>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>

</div>
<?php endif; ?>

<?php get_footer(); ?>
