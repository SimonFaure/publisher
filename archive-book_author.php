<?php
get_header();
?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title"><?php _e('Our Authors', 'publisher-pro'); ?></h1>
        <?php
        $description = get_the_archive_description();
        if ($description) {
            echo '<div class="archive-description">' . $description . '</div>';
        }
        ?>
    </div>

    <div class="author-archive">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article class="author-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="author-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('publisher-pro-author'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <h2 class="author-name">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <?php if (has_excerpt()) : ?>
                        <div class="author-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="author-social">
                        <?php
                        $website = get_post_meta(get_the_ID(), '_author_website', true);
                        $twitter = get_post_meta(get_the_ID(), '_author_twitter', true);
                        $facebook = get_post_meta(get_the_ID(), '_author_facebook', true);
                        $instagram = get_post_meta(get_the_ID(), '_author_instagram', true);

                        if ($website) {
                            echo '<a href="' . esc_url($website) . '" target="_blank" rel="noopener" title="' . __('Website', 'publisher-pro') . '">🌐</a>';
                        }
                        if ($twitter) {
                            echo '<a href="https://twitter.com/' . esc_attr($twitter) . '" target="_blank" rel="noopener" title="' . __('Twitter', 'publisher-pro') . '">𝕏</a>';
                        }
                        if ($facebook) {
                            echo '<a href="https://facebook.com/' . esc_attr($facebook) . '" target="_blank" rel="noopener" title="' . __('Facebook', 'publisher-pro') . '">f</a>';
                        }
                        if ($instagram) {
                            echo '<a href="https://instagram.com/' . esc_attr($instagram) . '" target="_blank" rel="noopener" title="' . __('Instagram', 'publisher-pro') . '">📷</a>';
                        }
                        ?>
                    </div>

                    <a href="<?php the_permalink(); ?>" class="button">
                        <?php _e('View Profile', 'publisher-pro'); ?>
                    </a>
                </article>
                <?php
            endwhile;

            the_posts_navigation();

        else :
            ?>
            <p><?php _e('No authors found.', 'publisher-pro'); ?></p>
            <?php
        endif;
        ?>
    </div>
</div>

<?php
get_footer();
