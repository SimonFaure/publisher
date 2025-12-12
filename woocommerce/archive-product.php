<?php
get_header('shop');
?>

<div class="container">
    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
        <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
    <?php endif; ?>

    <?php do_action('woocommerce_archive_description'); ?>

    <div class="shop-layout">
        <aside class="shop-sidebar">
            <div class="filter-sidebar">
                <h3><?php _e('Filter Products', 'publisher-pro'); ?></h3>

                <div class="active-filters"></div>

                <form id="product-filter-form">
                    <div class="filter-section">
                        <h4 class="filter-title"><?php _e('Genre', 'publisher-pro'); ?></h4>
                        <select id="filter-genre" name="genre">
                            <option value=""><?php _e('All Genres', 'publisher-pro'); ?></option>
                            <?php
                            $genres = get_terms(array(
                                'taxonomy' => 'book_genre',
                                'hide_empty' => true,
                            ));
                            foreach ($genres as $genre) {
                                echo '<option value="' . esc_attr($genre->slug) . '">' . esc_html($genre->name) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="filter-section">
                        <h4 class="filter-title"><?php _e('Author', 'publisher-pro'); ?></h4>
                        <select id="filter-author" name="author">
                            <option value=""><?php _e('All Authors', 'publisher-pro'); ?></option>
                            <?php
                            $authors = get_posts(array(
                                'post_type' => 'book_author',
                                'posts_per_page' => -1,
                                'orderby' => 'title',
                                'order' => 'ASC'
                            ));
                            foreach ($authors as $author) {
                                echo '<option value="' . esc_attr($author->ID) . '">' . esc_html($author->post_title) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="filter-section">
                        <h4 class="filter-title"><?php _e('Series', 'publisher-pro'); ?></h4>
                        <select id="filter-series" name="series">
                            <option value=""><?php _e('All Series', 'publisher-pro'); ?></option>
                            <?php
                            $series = get_terms(array(
                                'taxonomy' => 'book_series',
                                'hide_empty' => true,
                            ));
                            foreach ($series as $serie) {
                                echo '<option value="' . esc_attr($serie->slug) . '">' . esc_html($serie->name) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <button type="button" class="button clear-filters">
                        <?php _e('Clear Filters', 'publisher-pro'); ?>
                    </button>
                </form>
            </div>
        </aside>

        <div class="shop-main">
            <div class="shop-controls">
                <?php woocommerce_result_count(); ?>

                <div class="woocommerce-ordering">
                    <select id="product-sort" name="orderby">
                        <option value="date"><?php _e('Newest', 'publisher-pro'); ?></option>
                        <option value="title"><?php _e('Title: A-Z', 'publisher-pro'); ?></option>
                        <option value="price"><?php _e('Price: Low to High', 'publisher-pro'); ?></option>
                        <option value="price-desc"><?php _e('Price: High to Low', 'publisher-pro'); ?></option>
                    </select>
                </div>
            </div>

            <?php
            if (woocommerce_product_loop()) {
                woocommerce_product_loop_start();

                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();
                        do_action('woocommerce_shop_loop');
                        wc_get_template_part('content', 'product');
                    }
                }

                woocommerce_product_loop_end();

                do_action('woocommerce_after_shop_loop');
            } else {
                do_action('woocommerce_no_products_found');
            }
            ?>
        </div>
    </div>
</div>

<?php
get_footer('shop');
