<?php get_header() ?>

<?php if ( have_posts() ) : ?>
<div class="Content">

	<?php while ( have_posts() ) : the_post(); ?>
	<main class="Page">
        <h1 class="Page-name"><?php the_title(); ?></h1>
        <div class="Page-description"><?php the_excerpt(); ?></div>
        <div class="Page-body">
            <div class="Wysiwyg">
                <?php the_content(); ?>
            </div>

        </div>
        <footer class="Page-footer"></footer>
    </main>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>

</div>
<?php endif; ?>

<?php get_footer(); ?>
