<?php
get_header();
?>

<div class="container">
    <div class="content-area">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php
                        if (is_singular()) :
                            the_title('<h1 class="entry-title">', '</h1>');
                        else :
                            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                        endif;
                        ?>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        if (is_singular()) {
                            the_content();
                        } else {
                            the_excerpt();
                        }
                        ?>
                    </div>

                    <?php if (!is_singular()) : ?>
                        <div class="entry-footer">
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="button">
                                <?php _e('Read More', 'publisher-pro'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </article>
                <?php
            endwhile;

            the_posts_navigation();

        else :
            ?>
            <p><?php _e('No content found.', 'publisher-pro'); ?></p>
            <?php
        endif;
        ?>
    </div>
</div>

<?php
get_footer();
