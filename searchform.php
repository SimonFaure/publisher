<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php _e('Search for:', 'publisher-pro'); ?></span>
        <input type="search"
               class="search-field"
               placeholder="<?php _e('Search...', 'publisher-pro'); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s" />
    </label>
    <input type="hidden" name="post_type" value="product" />
    <button type="submit" class="search-submit">
        <?php _e('Search', 'publisher-pro'); ?>
    </button>
</form>
