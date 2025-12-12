<?php
defined('ABSPATH') || exit;

global $product;

do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form();
    return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

    <div class="single-product-layout">
        <div class="product-images">
            <?php do_action('woocommerce_before_single_product_summary'); ?>
            <?php woocommerce_show_product_images(); ?>

            <?php
            $back_cover = get_post_meta(get_the_ID(), '_back_cover_image', true);
            if ($back_cover) :
                ?>
                <div class="back-cover-image" style="margin-top: var(--spacing-md);">
                    <h4><?php _e('Back Cover', 'publisher-pro'); ?></h4>
                    <img src="<?php echo esc_url($back_cover); ?>" alt="<?php _e('Back Cover', 'publisher-pro'); ?>" style="width: 100%; border-radius: 4px;">
                </div>
                <?php
            endif;
            ?>
        </div>

        <div class="product-summary">
            <?php woocommerce_template_single_title(); ?>

            <?php
            $contributors = get_post_meta(get_the_ID(), '_contributors', true);
            if (is_array($contributors) && !empty($contributors)) {
                $role_labels = array(
                    'writer' => __('Writer', 'publisher-pro'),
                    'illustrator' => __('Illustrator', 'publisher-pro'),
                    'model_maker' => __('Model Maker', 'publisher-pro'),
                    'corrector' => __('Corrector', 'publisher-pro'),
                    'graphist' => __('Graphic Designer', 'publisher-pro'),
                    'voice_actor' => __('Voice Actor', 'publisher-pro'),
                );

                echo '<div class="product-contributors">';
                foreach ($contributors as $contributor) {
                    if (!empty($contributor['person_id']) && !empty($contributor['role'])) {
                        $person_name = get_the_title($contributor['person_id']);
                        $person_link = get_permalink($contributor['person_id']);
                        $role_name = isset($role_labels[$contributor['role']]) ? $role_labels[$contributor['role']] : $contributor['role'];

                        echo '<div class="contributor-item">';
                        echo '<strong>' . esc_html($role_name) . ':</strong> ';
                        echo '<a href="' . esc_url($person_link) . '">' . esc_html($person_name) . '</a>';
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            ?>

            <?php woocommerce_template_single_rating(); ?>

            <?php woocommerce_template_single_price(); ?>

            <?php woocommerce_template_single_excerpt(); ?>

            <?php
            $has_ebook = get_post_meta(get_the_ID(), '_has_ebook', true);
            $ebook_format = get_post_meta(get_the_ID(), '_ebook_format', true);
            $has_audiobook = get_post_meta(get_the_ID(), '_has_audiobook', true);
            $audiobook_duration = get_post_meta(get_the_ID(), '_audiobook_duration', true);

            if ($has_ebook || $has_audiobook) :
                ?>
                <div class="product-formats">
                    <?php if ($has_ebook) : ?>
                        <div class="format-badge ebook-badge">
                            <span class="format-icon">📱</span>
                            <span class="format-text"><?php _e('eBook Available', 'publisher-pro'); ?></span>
                            <?php if ($ebook_format) : ?>
                                <span class="format-detail"><?php echo strtoupper(esc_html($ebook_format)); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($has_audiobook) : ?>
                        <div class="format-badge audiobook-badge">
                            <span class="format-icon">🎧</span>
                            <span class="format-text"><?php _e('Audiobook Available', 'publisher-pro'); ?></span>
                            <?php if ($audiobook_duration) : ?>
                                <span class="format-detail"><?php echo esc_html($audiobook_duration); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
            endif;

            $audio_sample = get_post_meta(get_the_ID(), '_audio_sample', true);
            if ($audio_sample) :
                ?>
                <div class="audio-preview-section">
                    <h4><?php _e('Listen to Sample', 'publisher-pro'); ?></h4>
                    <audio controls style="width: 100%; max-width: 500px;">
                        <source src="<?php echo esc_url($audio_sample); ?>" type="audio/mpeg">
                        <?php _e('Your browser does not support the audio element.', 'publisher-pro'); ?>
                    </audio>
                </div>
                <?php
            endif;

            $preview_content = get_post_meta(get_the_ID(), '_book_preview_content', true);
            $preview_pdf = get_post_meta(get_the_ID(), '_book_preview_pdf', true);

            if ($preview_content || $preview_pdf) :
                ?>
                <div class="book-preview-section">
                    <h4><?php _e('Read Sample Chapter', 'publisher-pro'); ?></h4>
                    <button type="button" class="button preview-button read-preview-btn" data-product-id="<?php echo get_the_ID(); ?>">
                        <?php _e('Read Sample', 'publisher-pro'); ?>
                    </button>
                </div>
                <?php
            endif;
            ?>

            <?php woocommerce_template_single_add_to_cart(); ?>

            <?php woocommerce_template_single_meta(); ?>

            <?php
            $series_terms = get_the_terms(get_the_ID(), 'book_series');
            if ($series_terms && !is_wp_error($series_terms)) {
                echo '<div class="product-meta">';
                echo __('Series:', 'publisher-pro') . ' ';
                $series_links = array();
                foreach ($series_terms as $term) {
                    $series_links[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
                }
                echo implode(', ', $series_links);
                echo '</div>';
            }

            $genre_terms = get_the_terms(get_the_ID(), 'book_genre');
            if ($genre_terms && !is_wp_error($genre_terms)) {
                echo '<div class="product-meta">';
                echo __('Genre:', 'publisher-pro') . ' ';
                $genre_links = array();
                foreach ($genre_terms as $term) {
                    $genre_links[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
                }
                echo implode(', ', $genre_links);
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <div class="woocommerce-tabs">
        <ul class="tabs">
            <li class="description_tab">
                <a href="#tab-description"><?php _e('Description', 'publisher-pro'); ?></a>
            </li>
            <li class="additional_information_tab">
                <a href="#tab-additional_information"><?php _e('Book Details', 'publisher-pro'); ?></a>
            </li>
            <?php if ($author_id) : ?>
                <li class="author_tab">
                    <a href="#tab-author"><?php _e('About the Author', 'publisher-pro'); ?></a>
                </li>
            <?php endif; ?>
            <?php if (comments_open()) : ?>
                <li class="reviews_tab">
                    <a href="#tab-reviews"><?php _e('Reviews', 'publisher-pro'); ?> (<?php echo $product->get_review_count(); ?>)</a>
                </li>
            <?php endif; ?>
        </ul>

        <div id="tab-description" class="woocommerce-Tabs-panel">
            <?php the_content(); ?>
        </div>

        <div id="tab-additional_information" class="woocommerce-Tabs-panel">
            <table class="book-details-table">
                <?php
                $isbn = get_post_meta(get_the_ID(), '_book_isbn', true);
                $pages = get_post_meta(get_the_ID(), '_book_pages', true);
                $pub_date = get_post_meta(get_the_ID(), '_book_publication_date', true);
                $dimensions = get_post_meta(get_the_ID(), '_book_dimensions', true);

                if ($isbn) {
                    echo '<tr><th>' . __('ISBN', 'publisher-pro') . '</th><td>' . esc_html($isbn) . '</td></tr>';
                }
                if ($pages) {
                    echo '<tr><th>' . __('Pages', 'publisher-pro') . '</th><td>' . esc_html($pages) . '</td></tr>';
                }
                if ($pub_date) {
                    echo '<tr><th>' . __('Publication Date', 'publisher-pro') . '</th><td>' . esc_html(date_i18n(get_option('date_format'), strtotime($pub_date))) . '</td></tr>';
                }
                if ($dimensions) {
                    echo '<tr><th>' . __('Dimensions', 'publisher-pro') . '</th><td>' . esc_html($dimensions) . '</td></tr>';
                }
                ?>
            </table>
        </div>

        <?php if ($author_id) : ?>
            <div id="tab-author" class="woocommerce-Tabs-panel">
                <div class="author-tab-content">
                    <?php
                    $author_post = get_post($author_id);
                    if ($author_post) {
                        echo '<h3>' . esc_html($author_post->post_title) . '</h3>';

                        if (has_post_thumbnail($author_id)) {
                            echo '<div class="author-thumbnail">';
                            echo get_the_post_thumbnail($author_id, 'thumbnail');
                            echo '</div>';
                        }

                        echo '<div class="author-bio">' . wpautop($author_post->post_content) . '</div>';

                        echo '<a href="' . esc_url(get_permalink($author_id)) . '" class="button">' . __('View All Books by This Author', 'publisher-pro') . '</a>';
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (comments_open()) : ?>
            <div id="tab-reviews" class="woocommerce-Tabs-panel">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>
    </div>

    <?php do_action('woocommerce_after_single_product_summary'); ?>

</div>

<?php if ($preview_content || $preview_pdf) : ?>
    <div id="book-preview-modal-<?php echo get_the_ID(); ?>" class="book-preview-modal">
        <div class="preview-content">
            <button class="preview-close">&times;</button>
            <h2><?php _e('Book Preview', 'publisher-pro'); ?></h2>
            <h3><?php the_title(); ?></h3>

            <div class="preview-body">
                <?php if ($preview_pdf) : ?>
                    <p>
                        <a href="<?php echo esc_url($preview_pdf); ?>" target="_blank" class="button">
                            <?php _e('Open PDF Preview', 'publisher-pro'); ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if ($preview_content) : ?>
                    <div class="preview-text">
                        <?php echo wpautop($preview_content); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php do_action('woocommerce_after_single_product'); ?>
