<div class="Search"
     id="search"
     role="search"
>
    <form action="<?php echo esc_url( get_search_link() ); ?>">
        <fieldset>
            <legend class="u-hidden"><?php _e( 'Search by keywords on this site', THISTLE_CHILD_TEXT_DOMAIN ); ?></legend>
            <div>
                <label class="u-hidden" for="searchS"><?php _e( 'Keywords to search', THISTLE_CHILD_TEXT_DOMAIN ); ?></label>
                <input type="search"
                       name="s"
                       value="<?php the_search_query(); ?>"
                       placeholder="<?php esc_attr_e( 'Enter your keywords…', THISTLE_CHILD_TEXT_DOMAIN ); ?>"
                       id="searchS"
                >
            </div>
        </fieldset>
        <button type="submit">
            <svg>
                <title><?php _e( 'Search', THISTLE_CHILD_TEXT_DOMAIN ); ?></title>
                <use xlink:href="#SearchIcon"></use>
            </svg>
        </button>
    </form>
</div>
