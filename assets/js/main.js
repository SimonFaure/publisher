(function($) {
    'use strict';

    $(document).ready(function() {

        $('.mobile-menu-toggle').on('click', function() {
            $('.main-navigation').toggleClass('active');
            $(this).toggleClass('active');
            $('body').toggleClass('menu-open');
        });

        $('.search-toggle').on('click', function(e) {
            e.stopPropagation();
            $('.search-form-container').toggleClass('active');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.header-search').length) {
                $('.search-form-container').removeClass('active');
            }
        });

        $('.main-navigation a').on('click', function() {
            if ($(window).width() < 1024) {
                $('.main-navigation').removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
                $('body').removeClass('menu-open');
            }
        });

        $(window).on('resize', function() {
            if ($(window).width() >= 1024) {
                $('.main-navigation').removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
                $('body').removeClass('menu-open');
            }
        });

        $(document).on('click', '.read-preview-btn', function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            openPreviewModal(productId);
        });

        function openPreviewModal(productId) {
            var modal = $('#book-preview-modal-' + productId);
            if (modal.length) {
                modal.addClass('active');
                $('body').css('overflow', 'hidden');
            }
        }

        $(document).on('click', '.preview-close, .book-preview-modal', function(e) {
            if (e.target === this) {
                $(this).closest('.book-preview-modal').removeClass('active');
                $('body').css('overflow', '');
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('.book-preview-modal').removeClass('active');
                $('body').css('overflow', '');
            }
        });

        var filterTimeout;
        $('#product-filter-form select, #product-filter-form input').on('change', function() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(function() {
                filterProducts(1);
            }, 300);
        });

        $('#product-sort').on('change', function() {
            filterProducts(1);
        });

        function filterProducts(page) {
            var $form = $('#product-filter-form');
            if (!$form.length) return;

            var data = {
                action: 'filter_products',
                nonce: publisherProAjax.nonce,
                genre: $('#filter-genre').val(),
                author: $('#filter-author').val(),
                series: $('#filter-series').val(),
                orderby: $('#product-sort').val(),
                paged: page || 1
            };

            $('.products').addClass('loading');

            $.ajax({
                url: publisherProAjax.ajaxurl,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        $('.products').html(response.data.html);
                        updateActiveFilters(data);

                        $('html, body').animate({
                            scrollTop: $('.products').offset().top - 100
                        }, 400);
                    }
                },
                complete: function() {
                    $('.products').removeClass('loading');
                }
            });
        }

        function updateActiveFilters(filters) {
            var $container = $('.active-filters');
            if (!$container.length) return;

            $container.empty();

            if (filters.genre) {
                var genreText = $('#filter-genre option:selected').text();
                $container.append(
                    '<span class="filter-tag">' +
                    genreText +
                    '<button type="button" data-filter="genre">&times;</button>' +
                    '</span>'
                );
            }

            if (filters.author) {
                var authorText = $('#filter-author option:selected').text();
                $container.append(
                    '<span class="filter-tag">' +
                    authorText +
                    '<button type="button" data-filter="author">&times;</button>' +
                    '</span>'
                );
            }

            if (filters.series) {
                var seriesText = $('#filter-series option:selected').text();
                $container.append(
                    '<span class="filter-tag">' +
                    seriesText +
                    '<button type="button" data-filter="series">&times;</button>' +
                    '</span>'
                );
            }
        }

        $(document).on('click', '.filter-tag button', function() {
            var filterType = $(this).data('filter');
            $('#filter-' + filterType).val('').trigger('change');
        });

        $(document).on('click', '.clear-filters', function(e) {
            e.preventDefault();
            $('#product-filter-form')[0].reset();
            filterProducts(1);
        });

        if ($('.products').length) {
            $('.products').on('mouseenter', '.product', function() {
                $(this).find('.product-image-wrapper img').css('transform', 'scale(1.05)');
            }).on('mouseleave', '.product', function() {
                $(this).find('.product-image-wrapper img').css('transform', 'scale(1)');
            });
        }

        $(document).on('added_to_cart', function(event, fragments, cart_hash, $button) {
            $('.cart-count').text(fragments.cart_count || 0);

            $button.removeClass('loading');
            $button.addClass('added');
            $button.text($button.data('added-text') || 'Added to cart');

            setTimeout(function() {
                $button.removeClass('added');
                $button.text($button.data('original-text') || 'Add to cart');
            }, 3000);
        });

        if (typeof wc_add_to_cart_params !== 'undefined') {
            $(document.body).on('adding_to_cart', function(event, $button) {
                $button.addClass('loading');
                $button.data('original-text', $button.text());
                $button.text($button.data('loading-text') || 'Adding...');
            });
        }

        $('.quantity').each(function() {
            var $input = $(this).find('input[type="number"]');
            if ($input.length && !$(this).find('.qty-btn').length) {
                $input.wrap('<div class="qty-input-wrapper"></div>');
                $input.before('<button type="button" class="qty-btn qty-minus">-</button>');
                $input.after('<button type="button" class="qty-btn qty-plus">+</button>');
            }
        });

        $(document).on('click', '.qty-minus', function() {
            var $input = $(this).siblings('input[type="number"]');
            var min = parseInt($input.attr('min')) || 1;
            var val = parseInt($input.val()) || min;
            if (val > min) {
                $input.val(val - 1).trigger('change');
            }
        });

        $(document).on('click', '.qty-plus', function() {
            var $input = $(this).siblings('input[type="number"]');
            var max = parseInt($input.attr('max')) || 9999;
            var val = parseInt($input.val()) || 0;
            if (val < max) {
                $input.val(val + 1).trigger('change');
            }
        });

        if ($('.woocommerce-tabs').length) {
            $('.woocommerce-tabs ul.tabs li a').on('click', function(e) {
                e.preventDefault();
                var $tab = $(this);
                var target = $tab.attr('href');

                $('.woocommerce-tabs ul.tabs li').removeClass('active');
                $tab.parent().addClass('active');

                $('.woocommerce-Tabs-panel').hide();
                $(target).show();
            });

            $('.woocommerce-tabs ul.tabs li:first-child').addClass('active');
            $('.woocommerce-Tabs-panel').hide();
            $('.woocommerce-Tabs-panel:first').show();
        }

        var lazyImages = document.querySelectorAll('img[loading="lazy"]');
        if ('IntersectionObserver' in window && lazyImages.length > 0) {
            var imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var image = entry.target;
                        if (image.dataset.src) {
                            image.src = image.dataset.src;
                            image.removeAttribute('data-src');
                        }
                        imageObserver.unobserve(image);
                    }
                });
            });

            lazyImages.forEach(function(image) {
                imageObserver.observe(image);
            });
        }

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 100) {
                $('.site-header').addClass('scrolled');
            } else {
                $('.site-header').removeClass('scrolled');
            }
        });

    });

})(jQuery);
