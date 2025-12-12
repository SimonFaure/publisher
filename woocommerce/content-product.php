<?php
defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<li <?php wc_product_class('', $product); ?>>
    <div class="product-image-wrapper">
        <a href="<?php echo esc_url(get_permalink()); ?>">
            <?php echo $product->get_image('woocommerce_thumbnail'); ?>
        </a>
        <?php do_action('woocommerce_before_shop_loop_item_title'); ?>
    </div>

    <div class="product-info">
        <h2 class="woocommerce-loop-product__title">
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <?php echo get_the_title(); ?>
            </a>
        </h2>

        <?php
        $author_id = get_post_meta(get_the_ID(), '_book_author_id', true);
        if ($author_id) {
            $author_name = get_the_title($author_id);
            $author_link = get_permalink($author_id);
            echo '<div class="product-author">';
            echo '<a href="' . esc_url($author_link) . '">' . esc_html($author_name) . '</a>';
            echo '</div>';
        }
        ?>

        <?php woocommerce_template_loop_price(); ?>

        <?php woocommerce_template_loop_add_to_cart(); ?>
    </div>
</li>
