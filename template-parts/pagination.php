<?php if ( $wp_query->max_num_pages > 1 ) : ?>
<div class="Pagination"
     data-current="<?php echo esc_attr( max( 1, get_query_var( 'paged' ) ) ); ?>"
     data-count="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
>
    <?php echo paginate_links(); ?>
</div>
<?php endif; ?>
