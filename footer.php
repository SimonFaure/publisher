    </main>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <?php if (has_nav_menu('footer')) : ?>
                    <nav class="footer-navigation">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class' => 'footer-links',
                            'container' => false,
                            'depth' => 1,
                        ));
                        ?>
                    </nav>
                <?php endif; ?>

                <div class="footer-credit">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'publisher-pro'); ?></p>
                    <?php
                    $illustrator_text = get_theme_mod('illustrator_credit', '');
                    if (!empty($illustrator_text)) {
                        echo '<p>' . esc_html($illustrator_text) . '</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
