<?php
get_header();

$term = get_queried_object();
?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title"><?php echo esc_html($term->name); ?></h1>
        <?php if ($term->description) : ?>
            <div class="archive-description">
                <?php echo wpautop($term->description); ?>
            </div>
        <?php endif; ?>
    </div>

    <?php publisher_pro_breadcrumbs(); ?>

    <?php
    if (have_posts()) :
        echo '<ul class="products">';
        while (have_posts()) :
            the_post();
            wc_get_template_part('content', 'product');
        endwhile;
        echo '</ul>';

        the_posts_navigation();
    else :
        echo '<p>' . __('No products found in this genre.', 'publisher-pro') . '</p>';
    endif;
    ?>
</div>

<?php
get_footer();
