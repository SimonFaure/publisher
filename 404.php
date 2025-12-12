<?php
get_header();
?>

<div class="container">
    <div class="error-404">
        <header class="page-header">
            <h1 class="page-title"><?php _e('Oops! Page Not Found', 'publisher-pro'); ?></h1>
        </header>

        <div class="page-content">
            <p><?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'publisher-pro'); ?></p>

            <div class="error-search">
                <h2><?php _e('Try searching for what you need:', 'publisher-pro'); ?></h2>
                <?php get_search_form(); ?>
            </div>

            <?php if (class_exists('WooCommerce')) : ?>
                <div class="suggested-products">
                    <h2><?php _e('Or browse some of our books:', 'publisher-pro'); ?></h2>

                    <?php
                    $suggested = new WP_Query(array(
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'orderby' => 'rand',
                    ));

                    if ($suggested->have_posts()) :
                        echo '<ul class="products">';
                        while ($suggested->have_posts()) :
                            $suggested->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        echo '</ul>';
                        wp_reset_postdata();
                    endif;
                    ?>

                    <div class="section-footer">
                        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button">
                            <?php _e('Visit Our Shop', 'publisher-pro'); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.error-404 {
    text-align: center;
    padding: var(--spacing-xxl) 0;
}

.error-404 .page-title {
    font-size: 3rem;
    margin-bottom: var(--spacing-lg);
}

.error-search {
    max-width: 600px;
    margin: var(--spacing-xxl) auto;
}

.suggested-products {
    margin-top: var(--spacing-xxl);
}

.suggested-products h2 {
    margin-bottom: var(--spacing-lg);
}
</style>

<?php
get_footer();
