<?php

if (!defined('ABSPATH')) {
    exit;
}

define('PUBLISHER_PRO_VERSION', '1.0.0');
define('PUBLISHER_PRO_DIR', get_template_directory());
define('PUBLISHER_PRO_URI', get_template_directory_uri());

function publisher_pro_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');

    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    set_post_thumbnail_size(600, 800, true);
    add_image_size('publisher-pro-product-thumb', 300, 400, true);
    add_image_size('publisher-pro-featured', 800, 600, true);
    add_image_size('publisher-pro-author', 400, 400, true);

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'publisher-pro'),
        'footer' => __('Footer Menu', 'publisher-pro'),
    ));

    load_theme_textdomain('publisher-pro', PUBLISHER_PRO_DIR . '/languages');
}
add_action('after_setup_theme', 'publisher_pro_setup');

function publisher_pro_scripts() {
    wp_enqueue_style('roboto-font', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', array(), null);
    wp_enqueue_style('merriweather-font', 'https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&display=swap', array(), null);

    wp_enqueue_style('publisher-pro-style', get_stylesheet_uri(), array(), PUBLISHER_PRO_VERSION);
    wp_enqueue_style('publisher-pro-main', PUBLISHER_PRO_URI . '/assets/css/main.css', array('publisher-pro-style'), PUBLISHER_PRO_VERSION);
    wp_enqueue_style('publisher-pro-woocommerce', PUBLISHER_PRO_URI . '/assets/css/woocommerce.css', array('publisher-pro-main'), PUBLISHER_PRO_VERSION);

    wp_enqueue_script('publisher-pro-main', PUBLISHER_PRO_URI . '/assets/js/main.js', array('jquery'), PUBLISHER_PRO_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_localize_script('publisher-pro-main', 'publisherProAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('publisher_pro_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'publisher_pro_scripts');

function publisher_pro_register_author_post_type() {
    $labels = array(
        'name' => __('Authors', 'publisher-pro'),
        'singular_name' => __('Author', 'publisher-pro'),
        'menu_name' => __('Authors', 'publisher-pro'),
        'add_new' => __('Add New Author', 'publisher-pro'),
        'add_new_item' => __('Add New Author', 'publisher-pro'),
        'edit_item' => __('Edit Author', 'publisher-pro'),
        'new_item' => __('New Author', 'publisher-pro'),
        'view_item' => __('View Author', 'publisher-pro'),
        'search_items' => __('Search Authors', 'publisher-pro'),
        'not_found' => __('No authors found', 'publisher-pro'),
        'not_found_in_trash' => __('No authors found in trash', 'publisher-pro'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'author'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-admin-users',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    );

    register_post_type('book_author', $args);
}
add_action('init', 'publisher_pro_register_author_post_type');

function publisher_pro_register_series_taxonomy() {
    $labels = array(
        'name' => __('Series', 'publisher-pro'),
        'singular_name' => __('Series', 'publisher-pro'),
        'search_items' => __('Search Series', 'publisher-pro'),
        'all_items' => __('All Series', 'publisher-pro'),
        'parent_item' => __('Parent Series', 'publisher-pro'),
        'parent_item_colon' => __('Parent Series:', 'publisher-pro'),
        'edit_item' => __('Edit Series', 'publisher-pro'),
        'update_item' => __('Update Series', 'publisher-pro'),
        'add_new_item' => __('Add New Series', 'publisher-pro'),
        'new_item_name' => __('New Series Name', 'publisher-pro'),
        'menu_name' => __('Series', 'publisher-pro'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'series'),
        'show_in_rest' => true,
    );

    register_taxonomy('book_series', array('product'), $args);
}
add_action('init', 'publisher_pro_register_series_taxonomy');

function publisher_pro_register_genre_taxonomy() {
    $labels = array(
        'name' => __('Genres', 'publisher-pro'),
        'singular_name' => __('Genre', 'publisher-pro'),
        'search_items' => __('Search Genres', 'publisher-pro'),
        'all_items' => __('All Genres', 'publisher-pro'),
        'parent_item' => __('Parent Genre', 'publisher-pro'),
        'parent_item_colon' => __('Parent Genre:', 'publisher-pro'),
        'edit_item' => __('Edit Genre', 'publisher-pro'),
        'update_item' => __('Update Genre', 'publisher-pro'),
        'add_new_item' => __('Add New Genre', 'publisher-pro'),
        'new_item_name' => __('New Genre Name', 'publisher-pro'),
        'menu_name' => __('Genres', 'publisher-pro'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'genre'),
        'show_in_rest' => true,
    );

    register_taxonomy('book_genre', array('product'), $args);
}
add_action('init', 'publisher_pro_register_genre_taxonomy');

function publisher_pro_add_author_meta_boxes() {
    add_meta_box(
        'author_details',
        __('Author Details', 'publisher-pro'),
        'publisher_pro_author_details_callback',
        'book_author',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'publisher_pro_add_author_meta_boxes');

function publisher_pro_author_details_callback($post) {
    wp_nonce_field('publisher_pro_author_details', 'publisher_pro_author_details_nonce');

    $website = get_post_meta($post->ID, '_author_website', true);
    $twitter = get_post_meta($post->ID, '_author_twitter', true);
    $facebook = get_post_meta($post->ID, '_author_facebook', true);
    $instagram = get_post_meta($post->ID, '_author_instagram', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="author_website"><?php _e('Website', 'publisher-pro'); ?></label></th>
            <td><input type="url" id="author_website" name="author_website" value="<?php echo esc_url($website); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="author_twitter"><?php _e('Twitter', 'publisher-pro'); ?></label></th>
            <td><input type="text" id="author_twitter" name="author_twitter" value="<?php echo esc_attr($twitter); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="author_facebook"><?php _e('Facebook', 'publisher-pro'); ?></label></th>
            <td><input type="text" id="author_facebook" name="author_facebook" value="<?php echo esc_attr($facebook); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="author_instagram"><?php _e('Instagram', 'publisher-pro'); ?></label></th>
            <td><input type="text" id="author_instagram" name="author_instagram" value="<?php echo esc_attr($instagram); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function publisher_pro_save_author_details($post_id) {
    if (!isset($_POST['publisher_pro_author_details_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['publisher_pro_author_details_nonce'], 'publisher_pro_author_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['author_website'])) {
        update_post_meta($post_id, '_author_website', esc_url_raw($_POST['author_website']));
    }

    if (isset($_POST['author_twitter'])) {
        update_post_meta($post_id, '_author_twitter', sanitize_text_field($_POST['author_twitter']));
    }

    if (isset($_POST['author_facebook'])) {
        update_post_meta($post_id, '_author_facebook', sanitize_text_field($_POST['author_facebook']));
    }

    if (isset($_POST['author_instagram'])) {
        update_post_meta($post_id, '_author_instagram', sanitize_text_field($_POST['author_instagram']));
    }
}
add_action('save_post', 'publisher_pro_save_author_details');

function publisher_pro_add_product_meta_boxes() {
    add_meta_box(
        'book_details',
        __('Book Details', 'publisher-pro'),
        'publisher_pro_book_details_callback',
        'product',
        'normal',
        'high'
    );

    add_meta_box(
        'book_preview',
        __('Book Preview / Sample Chapter', 'publisher-pro'),
        'publisher_pro_book_preview_callback',
        'product',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'publisher_pro_add_product_meta_boxes');

function publisher_pro_book_details_callback($post) {
    wp_nonce_field('publisher_pro_book_details', 'publisher_pro_book_details_nonce');

    $isbn = get_post_meta($post->ID, '_book_isbn', true);
    $pages = get_post_meta($post->ID, '_book_pages', true);
    $publication_date = get_post_meta($post->ID, '_book_publication_date', true);
    $dimensions = get_post_meta($post->ID, '_book_dimensions', true);
    $book_author = get_post_meta($post->ID, '_book_author_id', true);

    $authors = get_posts(array(
        'post_type' => 'book_author',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    ?>
    <table class="form-table">
        <tr>
            <th><label for="book_author"><?php _e('Book Author', 'publisher-pro'); ?></label></th>
            <td>
                <select id="book_author" name="book_author" class="regular-text">
                    <option value=""><?php _e('Select Author', 'publisher-pro'); ?></option>
                    <?php foreach ($authors as $author) : ?>
                        <option value="<?php echo esc_attr($author->ID); ?>" <?php selected($book_author, $author->ID); ?>>
                            <?php echo esc_html($author->post_title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="book_isbn"><?php _e('ISBN', 'publisher-pro'); ?></label></th>
            <td><input type="text" id="book_isbn" name="book_isbn" value="<?php echo esc_attr($isbn); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="book_pages"><?php _e('Number of Pages', 'publisher-pro'); ?></label></th>
            <td><input type="number" id="book_pages" name="book_pages" value="<?php echo esc_attr($pages); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="book_publication_date"><?php _e('Publication Date', 'publisher-pro'); ?></label></th>
            <td><input type="date" id="book_publication_date" name="book_publication_date" value="<?php echo esc_attr($publication_date); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="book_dimensions"><?php _e('Dimensions (e.g., 6 x 9 inches)', 'publisher-pro'); ?></label></th>
            <td><input type="text" id="book_dimensions" name="book_dimensions" value="<?php echo esc_attr($dimensions); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function publisher_pro_book_preview_callback($post) {
    wp_nonce_field('publisher_pro_book_preview', 'publisher_pro_book_preview_nonce');

    $preview_content = get_post_meta($post->ID, '_book_preview_content', true);
    $preview_pdf = get_post_meta($post->ID, '_book_preview_pdf', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="book_preview_content"><?php _e('Preview Text Content', 'publisher-pro'); ?></label></th>
            <td>
                <textarea id="book_preview_content" name="book_preview_content" rows="10" class="large-text"><?php echo esc_textarea($preview_content); ?></textarea>
                <p class="description"><?php _e('Enter preview text or sample chapter content.', 'publisher-pro'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="book_preview_pdf"><?php _e('Preview PDF URL', 'publisher-pro'); ?></label></th>
            <td>
                <input type="url" id="book_preview_pdf" name="book_preview_pdf" value="<?php echo esc_url($preview_pdf); ?>" class="regular-text">
                <button type="button" class="button upload-preview-pdf"><?php _e('Upload PDF', 'publisher-pro'); ?></button>
                <p class="description"><?php _e('Upload a PDF file for book preview/sample chapter.', 'publisher-pro'); ?></p>
            </td>
        </tr>
    </table>
    <script>
    jQuery(document).ready(function($) {
        $('.upload-preview-pdf').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var custom_uploader = wp.media({
                title: '<?php _e('Choose PDF', 'publisher-pro'); ?>',
                library: { type: 'application/pdf' },
                button: { text: '<?php _e('Use this PDF', 'publisher-pro'); ?>' },
                multiple: false
            }).on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#book_preview_pdf').val(attachment.url);
            }).open();
        });
    });
    </script>
    <?php
}

function publisher_pro_save_product_details($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['publisher_pro_book_details_nonce']) && wp_verify_nonce($_POST['publisher_pro_book_details_nonce'], 'publisher_pro_book_details')) {
        if (isset($_POST['book_author'])) {
            update_post_meta($post_id, '_book_author_id', absint($_POST['book_author']));
        }

        if (isset($_POST['book_isbn'])) {
            update_post_meta($post_id, '_book_isbn', sanitize_text_field($_POST['book_isbn']));
        }

        if (isset($_POST['book_pages'])) {
            update_post_meta($post_id, '_book_pages', absint($_POST['book_pages']));
        }

        if (isset($_POST['book_publication_date'])) {
            update_post_meta($post_id, '_book_publication_date', sanitize_text_field($_POST['book_publication_date']));
        }

        if (isset($_POST['book_dimensions'])) {
            update_post_meta($post_id, '_book_dimensions', sanitize_text_field($_POST['book_dimensions']));
        }
    }

    if (isset($_POST['publisher_pro_book_preview_nonce']) && wp_verify_nonce($_POST['publisher_pro_book_preview_nonce'], 'publisher_pro_book_preview')) {
        if (isset($_POST['book_preview_content'])) {
            update_post_meta($post_id, '_book_preview_content', wp_kses_post($_POST['book_preview_content']));
        }

        if (isset($_POST['book_preview_pdf'])) {
            update_post_meta($post_id, '_book_preview_pdf', esc_url_raw($_POST['book_preview_pdf']));
        }
    }
}
add_action('save_post', 'publisher_pro_save_product_details');

function publisher_pro_widgets_init() {
    register_sidebar(array(
        'name' => __('Shop Sidebar', 'publisher-pro'),
        'id' => 'shop-sidebar',
        'description' => __('Sidebar for shop and product pages', 'publisher-pro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Blog Sidebar', 'publisher-pro'),
        'id' => 'blog-sidebar',
        'description' => __('Sidebar for blog posts', 'publisher-pro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'publisher_pro_widgets_init');

function publisher_pro_custom_product_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'name') {
            $new_columns['book_author'] = __('Author', 'publisher-pro');
            $new_columns['book_series'] = __('Series', 'publisher-pro');
        }
    }
    return $new_columns;
}
add_filter('manage_edit-product_columns', 'publisher_pro_custom_product_columns');

function publisher_pro_custom_product_column_content($column, $post_id) {
    if ($column === 'book_author') {
        $author_id = get_post_meta($post_id, '_book_author_id', true);
        if ($author_id) {
            echo get_the_title($author_id);
        }
    }

    if ($column === 'book_series') {
        $terms = get_the_terms($post_id, 'book_series');
        if ($terms && !is_wp_error($terms)) {
            $series_names = array();
            foreach ($terms as $term) {
                $series_names[] = $term->name;
            }
            echo implode(', ', $series_names);
        }
    }
}
add_action('manage_product_posts_custom_column', 'publisher_pro_custom_product_column_content', 10, 2);

function publisher_pro_ajax_filter_products() {
    check_ajax_referer('publisher_pro_nonce', 'nonce');

    $genre = isset($_POST['genre']) ? sanitize_text_field($_POST['genre']) : '';
    $author = isset($_POST['author']) ? absint($_POST['author']) : 0;
    $series = isset($_POST['series']) ? sanitize_text_field($_POST['series']) : '';
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'date';

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 12,
        'paged' => isset($_POST['paged']) ? absint($_POST['paged']) : 1,
    );

    $tax_query = array('relation' => 'AND');

    if (!empty($genre)) {
        $tax_query[] = array(
            'taxonomy' => 'book_genre',
            'field' => 'slug',
            'terms' => $genre,
        );
    }

    if (!empty($series)) {
        $tax_query[] = array(
            'taxonomy' => 'book_series',
            'field' => 'slug',
            'terms' => $series,
        );
    }

    if (!empty($tax_query) && count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    if ($author > 0) {
        $args['meta_query'] = array(
            array(
                'key' => '_book_author_id',
                'value' => $author,
                'compare' => '=',
            )
        );
    }

    switch ($orderby) {
        case 'price':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order'] = 'ASC';
            break;
        case 'price-desc':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_price';
            $args['order'] = 'DESC';
            break;
        case 'title':
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
            break;
        case 'date':
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
    } else {
        echo '<p>' . __('No products found.', 'publisher-pro') . '</p>';
    }

    wp_reset_postdata();

    $response = array(
        'html' => ob_get_clean(),
        'max_pages' => $query->max_num_pages,
    );

    wp_send_json_success($response);
}
add_action('wp_ajax_filter_products', 'publisher_pro_ajax_filter_products');
add_action('wp_ajax_nopriv_filter_products', 'publisher_pro_ajax_filter_products');

function publisher_pro_product_badge() {
    global $product;

    if ($product->is_on_sale()) {
        echo '<span class="product-badge sale-badge">' . __('Sale', 'publisher-pro') . '</span>';
    }

    $new_days = 30;
    $created = strtotime($product->get_date_created());
    if ((time() - $created) < ($new_days * 24 * 60 * 60)) {
        echo '<span class="product-badge new-badge">' . __('New', 'publisher-pro') . '</span>';
    }
}
add_action('woocommerce_before_shop_loop_item_title', 'publisher_pro_product_badge', 10);

function publisher_pro_breadcrumbs() {
    if (function_exists('woocommerce_breadcrumb')) {
        woocommerce_breadcrumb(array(
            'delimiter' => ' / ',
            'wrap_before' => '<nav class="breadcrumbs" aria-label="breadcrumb"><ol>',
            'wrap_after' => '</ol></nav>',
            'before' => '<li>',
            'after' => '</li>',
            'home' => _x('Home', 'breadcrumb', 'publisher-pro'),
        ));
    }
}
