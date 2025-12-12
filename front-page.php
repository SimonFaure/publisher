<?php
get_header();
?>

<div class="homepage">
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1><?php bloginfo('name'); ?></h1>
                <p class="hero-description"><?php bloginfo('description'); ?></p>
                <div class="hero-actions">
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button">
                        <?php _e('Browse Books', 'publisher-pro'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="featured-categories">
        <div class="container">
            <div class="category-grid">
                <?php
                $product_categories = array(
                    array('slug' => 'books', 'name' => __('Books', 'publisher-pro'), 'icon' => '📚'),
                    array('slug' => 'ebooks', 'name' => __('eBooks', 'publisher-pro'), 'icon' => '📱'),
                    array('slug' => 'audiobooks', 'name' => __('Audiobooks', 'publisher-pro'), 'icon' => '🎧'),
                    array('slug' => 'board-games', 'name' => __('Board Games', 'publisher-pro'), 'icon' => '🎲'),
                    array('slug' => 'art', 'name' => __('Art & Posters', 'publisher-pro'), 'icon' => '🎨'),
                );

                foreach ($product_categories as $cat) {
                    $term = get_term_by('slug', $cat['slug'], 'product_cat');
                    $link = $term ? get_term_link($term) : get_permalink(wc_get_page_id('shop'));
                    ?>
                    <a href="<?php echo esc_url($link); ?>" class="category-card">
                        <span class="category-icon"><?php echo $cat['icon']; ?></span>
                        <h3><?php echo esc_html($cat['name']); ?></h3>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <section class="new-releases">
        <div class="container">
            <h2 class="section-title"><?php _e('New Releases', 'publisher-pro'); ?></h2>

            <?php
            $new_products = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 8,
                'orderby' => 'date',
                'order' => 'DESC',
                'meta_query' => array(
                    array(
                        'key' => '_stock_status',
                        'value' => 'instock',
                    )
                )
            ));

            if ($new_products->have_posts()) :
                echo '<ul class="products">';
                while ($new_products->have_posts()) :
                    $new_products->the_post();
                    wc_get_template_part('content', 'product');
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
            endif;
            ?>

            <div class="section-footer">
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button">
                    <?php _e('View All Products', 'publisher-pro'); ?>
                </a>
            </div>
        </div>
    </section>

    <section class="featured-authors">
        <div class="container">
            <h2 class="section-title"><?php _e('Featured Authors', 'publisher-pro'); ?></h2>

            <?php
            $featured_authors = get_posts(array(
                'post_type' => 'book_author',
                'posts_per_page' => 6,
                'orderby' => 'rand',
            ));

            if ($featured_authors) :
                echo '<div class="author-archive">';
                foreach ($featured_authors as $author) :
                    setup_postdata($author);
                    ?>
                    <article class="author-card">
                        <?php if (has_post_thumbnail($author->ID)) : ?>
                            <div class="author-thumbnail">
                                <a href="<?php echo get_permalink($author->ID); ?>">
                                    <?php echo get_the_post_thumbnail($author->ID, 'publisher-pro-author'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <h3 class="author-name">
                            <a href="<?php echo get_permalink($author->ID); ?>">
                                <?php echo get_the_title($author->ID); ?>
                            </a>
                        </h3>

                        <?php if (has_excerpt($author->ID)) : ?>
                            <div class="author-excerpt">
                                <?php echo get_the_excerpt($author->ID); ?>
                            </div>
                        <?php endif; ?>

                        <a href="<?php echo get_permalink($author->ID); ?>" class="button">
                            <?php _e('View Profile', 'publisher-pro'); ?>
                        </a>
                    </article>
                    <?php
                endforeach;
                echo '</div>';
                wp_reset_postdata();
            endif;
            ?>

            <div class="section-footer">
                <a href="<?php echo esc_url(get_post_type_archive_link('book_author')); ?>" class="button">
                    <?php _e('View All Authors', 'publisher-pro'); ?>
                </a>
            </div>
        </div>
    </section>

    <?php
    $series = get_terms(array(
        'taxonomy' => 'book_series',
        'hide_empty' => true,
        'number' => 1,
    ));

    if ($series && !is_wp_error($series)) :
        $featured_series = $series[0];
        ?>
        <section class="featured-series">
            <div class="container">
                <h2 class="section-title"><?php _e('Featured Series', 'publisher-pro'); ?></h2>

                <div class="series-item">
                    <div class="series-header">
                        <h3 class="series-title"><?php echo esc_html($featured_series->name); ?></h3>
                    </div>

                    <?php if ($featured_series->description) : ?>
                        <div class="series-description">
                            <?php echo wpautop($featured_series->description); ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    $series_products = new WP_Query(array(
                        'post_type' => 'product',
                        'posts_per_page' => 6,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'book_series',
                                'field' => 'term_id',
                                'terms' => $featured_series->term_id,
                            )
                        ),
                    ));

                    if ($series_products->have_posts()) :
                        echo '<ul class="products series-products">';
                        while ($series_products->have_posts()) :
                            $series_products->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                        echo '</ul>';
                        wp_reset_postdata();
                    endif;
                    ?>

                    <a href="<?php echo esc_url(get_term_link($featured_series)); ?>" class="button">
                        <?php _e('View Full Series', 'publisher-pro'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (is_active_sidebar('homepage-newsletter')) : ?>
        <section class="newsletter-section">
            <div class="container">
                <?php dynamic_sidebar('homepage-newsletter'); ?>
            </div>
        </section>
    <?php endif; ?>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, #f8f8f8 0%, #ffffff 100%);
    padding: var(--spacing-xxl) 0;
    text-align: center;
    margin-bottom: var(--spacing-xxl);
}

.hero-content h1 {
    font-size: 3rem;
    margin-bottom: var(--spacing-md);
}

.hero-description {
    font-size: 1.25rem;
    color: var(--color-text);
    margin-bottom: var(--spacing-lg);
}

.hero-actions {
    display: flex;
    gap: var(--spacing-md);
    justify-content: center;
}

.featured-categories {
    margin-bottom: var(--spacing-xxl);
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--spacing-lg);
}

.category-card {
    background: var(--color-background);
    border: 1px solid var(--color-border);
    border-radius: 8px;
    padding: var(--spacing-xl);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.category-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.category-icon {
    font-size: 3rem;
    display: block;
    margin-bottom: var(--spacing-md);
}

.category-card h3 {
    margin: 0;
    color: var(--color-text-dark);
}

.new-releases,
.featured-authors,
.featured-series {
    margin-bottom: var(--spacing-xxl);
}

.section-title {
    text-align: center;
    font-size: 2rem;
    margin-bottom: var(--spacing-xl);
}

.section-footer {
    text-align: center;
    margin-top: var(--spacing-xl);
}

.newsletter-section {
    background: #f8f8f8;
    padding: var(--spacing-xxl) 0;
    margin-top: var(--spacing-xxl);
}

@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2rem;
    }

    .hero-description {
        font-size: 1rem;
    }

    .category-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }

    .category-icon {
        font-size: 2rem;
    }
}
</style>

<?php
get_footer();
