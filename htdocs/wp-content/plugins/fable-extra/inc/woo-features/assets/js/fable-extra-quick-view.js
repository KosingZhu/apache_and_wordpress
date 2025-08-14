jQuery(document).ready(function($) {
    // Function to initialize Owl Carousel
    function initializeOwlCarousel($container) {
        var $owlProduct = $container.find('.woocommerce-product-gallery__wrapper');
        var $owlProductThumb = $container.find('.product-control-nav');

        // Initialize main product carousel
        $owlProduct.owlCarousel({
            rtl: $("html").attr("dir") === 'rtl',
            items: 1,
            autoplay: true,
            autoplayTimeout: 10000,
            margin: 0,
            loop: $container.find('.owl-carousel .item').length > 1,
            dots: false,
            nav: true,
            navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
            singleItem: true,
            transitionStyle: "fade",
            touchDrag: true,
            mouseDrag: true,
            slideSpeed: 2000,
            responsiveRefreshRate: 200,
            responsive: {
                0: { nav: false },
                992: { nav: true }
            }
        }).on('changed.owl.carousel', function(event) {
            owlPosition(event, $owlProduct, $owlProductThumb);
        });

        // Initialize thumbnail carousel
        $owlProductThumb.owlCarousel({
            dots: false,
            nav: false,
            margin: 20,
            smartSpeed: 200,
            slideSpeed: 500,
            touchDrag: true,
            mouseDrag: true,
            responsiveRefreshRate: 100,
            responsive: {
                0: { items: 3, slideBy: 3 },
                396: { items: 4, slideBy: 4 },
                499: { items: 5, slideBy: 5 },
                768: { items: 3, slideBy: 3 },
                992: { items: 3, slideBy: 3 },
                1400: { items: 3, slideBy: 3 }
            }
        }).on('changed.owl.carousel', function(event) {
            owlPosition2(event, $owlProduct, $owlProductThumb);
        });

        // Thumbnail click event to update main carousel
        $owlProductThumb.on("click", ".owl-item", function(e) {
            e.preventDefault();
            var index = $(this).index();
            $owlProduct.trigger('to.owl.carousel', [index, 300, true]);
        });
    }

    // Function to handle product carousel position
    function owlPosition(event, $owlProduct, $owlProductThumb) {
        var index = event.item.index;
        $owlProductThumb.find(".owl-item").removeClass("current").eq(index).addClass("current");
    }

    // Function to handle thumbnail carousel position
    function owlPosition2(event, $owlProduct, $owlProductThumb) {
        var index = event.item.index;
        // Synchronize the main carousel with the thumbnail carousel
        $owlProduct.trigger('to.owl.carousel', [index, 100, true]);
        //console.log([index, 100, true]);
        // Ensure that the thumbnail carousel reflects the correct active state
        $owlProductThumb.find(".owl-item").removeClass("current").eq(index).addClass("current");
    }

    // Handle quick view trigger
    $(".quickview-trigger").click(function() {
        var product_value = $(this).attr("data-product_id");
        var data = {
            action: 'fable_extra_quick_view',
            security: MyAjax.security,
            fable_extra_product_d: product_value
        };

        $.post(MyAjax.ajaxurl, data, function(response) {
            $("#theme-quickview-body").html(response);
            
            // Initialize carousels inside the quick view
            $('.single-product').each(function() {
                initializeOwlCarousel($(this));
            });
        });
    });

    // Update quantity data attribute
    $('input[name="quantity"]').change(function() {
        var quantity = $(this).val();
        $(this).parent().next().attr('data-quantity', quantity);
    });
});
