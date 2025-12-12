<?php
get_header();
?>

<div class="container">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article class="author-details">
            <div class="author-header">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="author-avatar">
                        <?php the_post_thumbnail('publisher-pro-author'); ?>
                    </div>
                <?php endif; ?>

                <div class="author-info">
                    <h1 class="author-name"><?php the_title(); ?></h1>

                    <div class="author-social">
                        <?php
                        $website = get_post_meta(get_the_ID(), '_author_website', true);
                        $twitter = get_post_meta(get_the_ID(), '_author_twitter', true);
                        $facebook = get_post_meta(get_the_ID(), '_author_facebook', true);
                        $instagram = get_post_meta(get_the_ID(), '_author_instagram', true);

                        if ($website) {
                            echo '<a href="' . esc_url($website) . '" target="_blank" rel="noopener">🌐 ' . __('Website', 'publisher-pro') . '</a>';
                        }
                        if ($twitter) {
                            echo '<a href="https://twitter.com/' . esc_attr($twitter) . '" target="_blank" rel="noopener">𝕏 Twitter</a>';
                        }
                        if ($facebook) {
                            echo '<a href="https://facebook.com/' . esc_attr($facebook) . '" target="_blank" rel="noopener">f Facebook</a>';
                        }
                        if ($instagram) {
                            echo '<a href="https://instagram.com/' . esc_attr($instagram) . '" target="_blank" rel="noopener">📷 Instagram</a>';
                        }
                        ?>
                    </div>

                    <?php if (get_the_content()) : ?>
                        <div class="author-bio">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="author-bibliography">
                <h2><?php _e('Books by', 'publisher-pro'); ?> <?php the_title(); ?></h2>

                <?php
                $author_books = new WP_Query(array(
                    'post_type' => 'product',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => '_book_author_id',
                            'value' => get_the_ID(),
                            'compare' => '='
                        )
                    ),
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($author_books->have_posts()) :
                    echo '<ul class="products">';
                    while ($author_books->have_posts()) :
                        $author_books->the_post();
                        wc_get_template_part('content', 'product');
                    endwhile;
                    echo '</ul>';
                    wp_reset_postdata();
                else :
                    echo '<p>' . __('No books found by this author yet.', 'publisher-pro') . '</p>';
                endif;
                ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</div>

<?php
get_footer();
