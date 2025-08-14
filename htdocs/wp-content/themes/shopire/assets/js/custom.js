(function ($) {
    'use strict';

    // Function to hide preloader
    var preloader = $('.wf_preloader');
    function initHidePreloader() {
        $('body').addClass('overlay--enabled')
        if (preloader.length) {
            preloader.addClass('loaded');
            preloader.delay(600).fadeOut();
            $('body').removeClass('overlay--enabled');
        }
    }
    if (preloader.length) {
        $('.wf_preloader-close').on('click', function () {
            preloader.addClass('loaded');
            preloader.delay(600).fadeOut();
            $('body').removeClass('overlay--enabled');
        });
    }
    // Function to initialize Owl Carousels
    function initOwlCarousels() {
        $(".wf_owl_carousel").each(function () {
            var carousel = $(this);
            var options = carousel.data("owl-options");
            carousel.owlCarousel(
                typeof options === "object" ? options : JSON.parse(options)
            );

            // Add event listener to identify and style the last item
            carousel.on('changed.owl.carousel', function (event) {
                var items = event.item.count; // Total number of items in the carousel
                var currentItem = event.item.index; // Index of the current item

                // Remove class from previously last item
                carousel.find('.owl-item').removeClass('owl-last');

                // Add class to current last item
                if (currentItem + 1 === items) {
                    carousel.find('.owl-item').eq(currentItem).addClass('owl-last');
                }
            });
        });
    }

    // Function to handle scrolling and update progress bar
    function initUpdateProgressBar() {
        var scroll = $(window).scrollTop();
        var height = $(document).height() - $(window).height();
        var progressPath = $('.wf_uptop path')[0];
        var pathLength = progressPath.getTotalLength();
        var progress = pathLength - (scroll * pathLength / height);
        progressPath.style.strokeDashoffset = progress;
    }

    // Event handling for scrolling and updating progress bar
    $(window).on('scroll', function () {
        $('.wf_uptop').toggleClass('active', $(this).scrollTop() > 50);
        initUpdateProgressBar();
    });

    // Function to handle click event for scrolling to top
    $('.wf_uptop').on('click', function (event) {
        event.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 550);
    });

    // Btn Effect Six
    setTimeout(() => {
        document.querySelectorAll(".btn--effect-six .wf-btn").forEach(button => {
            const originalHTML = button.innerHTML;
            button.addEventListener("mouseover", () => {
                if (!button.classList.contains("animating") && !button.classList.contains("mouseover")) {
                    button.classList.add("animating", "mouseover");
                    const tempDiv = document.createElement("div");
                    tempDiv.innerHTML = originalHTML;
                    const chars = Array.from(tempDiv.childNodes);
                    setTimeout(() => button.classList.remove("animating"), (chars.length + 1) * 50);
                    const animationType = button.dataset.animation || "text-spin";
                    button.innerHTML = "";
                    chars.forEach(node => {
                        if (node.nodeType === Node.TEXT_NODE) {
                            node.textContent.split("").forEach(char => {
                                button.innerHTML += `<span class="letter">${char === " " ? "&nbsp;" : char}</span>`;
                            });
                        } else {
                            button.innerHTML += `<span class="letter">${node.outerHTML}</span>`;
                        }
                    });
                    button.querySelectorAll(".letter").forEach((span, index) => {
                        setTimeout(() => span.classList.add(animationType), 50 * index);
                    });
                }
            });
            button.addEventListener("mouseout", () => {
                button.classList.remove("mouseover");
                button.innerHTML = originalHTML;
            });
        });
    }, 100);

    // Function to get a cookie value by name
    function getCookie(name) {
        let value = "; " + document.cookie;
        let parts = value.split("; " + name + "=");
        if (parts.length === 2) {
            return parts.pop().split(";").shift();
        }
        return null;
    }

    // Function to set a cookie with a name, value, and expiration days
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            //date.setTime(date.getTime() + (days * 1000)); // second
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Function to initialize FancyBox for lightbox images
    function initLightbox() {
        if ($('.wf_lightbox_img').length) {
            $('.wf_lightbox_img').fancybox({
                openEffect: 'fade',
                closeEffect: 'fade',
                helpers: { media: {} }
            });
        }
        $('.wp-block-image').each(function () {
            $(this).find("a").attr('data-fancybox', 'gallery');
        });
        if ($('.wp-block-image a').length) {
            $('[data-fancybox="gallery"]').fancybox({
                buttons: ["slideShow", "thumbs", "zoom", "fullScreen", "share", "close"],
                loop: false,
                protect: true
            });
        }
    }

    // Function to initialize tab content
    function initTabContent() {
        $(".wf_tabs").each(function () {
            var tabs = $(this);
            tabs.find(".tabs li a").click(function () {
                var tab_id = $(this).attr("data-tab");
                tabs.find(".tabs li a").removeClass("active");
                tabs.find(".tab-content .tab-pane").removeClass("active").removeClass("show");
                $(this).addClass("active");
                setTimeout(function () {
                    $("#" + tab_id).addClass("active").addClass("show");
                }, 100);
                return false;
            });
        });
    }

    // Event handling for project filter tab click
    $(document).on('click', '.wf-tab-filter a', function (e) {
        e.preventDefault();
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });

    // Accordion
    $(document).on("click", ".accordion__title", function () {
        const accordionWrapper = $(this).parent();
        const accordionContent = $(this).parent().find(".accordion__content").first();
        const accordionOpen = "accordion--open";

        // If this accordion is already open
        if (accordionWrapper.hasClass(accordionOpen)) {
            accordionContent.slideUp(); // Close the content.
            accordionWrapper.removeClass(accordionOpen); // Remove the accordionm--open class.
        } else {
            accordionContent.slideDown(); // Show this accordion's content.
            accordionWrapper.addClass(accordionOpen); // Add the accordion--open class.
        }
    });

    $('#grid').click(function() {
        $(this).addClass('active');
        $('#list').removeClass('active');
        $('ul.products').fadeOut(300, function() {
            $(this).addClass('grid').removeClass('list').fadeIn(300);
        });
        return false;
    });

    $('#list').click(function() {
        $(this).addClass('active');
        $('#grid').removeClass('active');
        $('ul.products').fadeOut(300, function() {
            $(this).removeClass('grid').addClass('list').fadeIn(300);
        });
        return false;
    });

    // Categories More BTN
    function initializeCategoryMenu() {
        var $productCategoryMenu = $('.product-categories .wf_navbar-nav .wf_navbar-mainmenu');
        // Check if menu items exceed 8; if so, add "More" button
        if ($productCategoryMenu.children().length >= 8) {
            $productCategoryMenu.append('<li class="menu-item more"><button type="button" class="product-categories-more-btn"><i class="fa fa-plus"></i> <span>More Category</span></button></li>');
            $productCategoryMenu.children("li:not(.more)").slice(0, 8).show();

            // Toggle visibility of additional categories on button click
            $(".product-categories-more-btn").on('click', function () {
                const isActive = $(this).hasClass("active");

                $(this).toggleClass("active");
                $(this).find('i').toggleClass('fa-plus fa-minus');

                $productCategoryMenu.children("li:not(.more)").slice(8).slideToggle(200).toggleClass('actived', !isActive);
            });
        }
    }

    // Function to get the dynamic slider width
    function getDynamicSliderWidth() {
        var $categories = $('.product-categories');
        var categoriesWidth = $categories.outerWidth();
        return categoriesWidth ? `calc(100% - ${categoriesWidth}px)` : "100%";
    }

    // Function to handle resizing logic
    function handleResize() {
        var $nav = $('.product-categories .wf_navbar-nav');
        var $categories = $('.product-categories');

        if (window.matchMedia('(max-width: 991px)').matches) {
            // For small screens (< 992px)
            $categories.removeClass("active");
            $nav.addClass('closed').hide();
        } else {
            // For medium and large screens (>= 992px)
            if ($(".wf_slider--one").length || $(".wf_slider--nine").length) {
                $categories.addClass("active");
                setTimeout(function () {
                    $nav.removeClass('closed').slideDown(700);
                }, 100);
            } else {
                $nav.addClass('closed').hide();
            }
        }

        // Adjust slider width
        var sliderWidth = getDynamicSliderWidth();
        if (window.matchMedia('(min-width: 992px)').matches && $(".wf_slider--one").length) {
            $(".wf_slider--one .wf_slider-item .wf_slider-wrapper .wf-row").css("width", $categories.hasClass("active") ? sliderWidth : "100%");
        } else {
            $(".wf_slider--one .wf_slider-item .wf_slider-wrapper .wf-row").css("width", "100%");
        }
    }

    // Function to handle menu toggle
    function toggleMenu() {
        var $nav = $('.product-categories .wf_navbar-nav');
        var $categories = $('.product-categories');

        $categories.toggleClass("active");

        if ($categories.hasClass("active")) {
            setTimeout(function () {
                $nav.removeClass('closed').slideDown(700);
            }, 100);
        } else {
            $nav.addClass('closed').slideUp(700);
        }

        // Adjust slider width on toggle
        var sliderWidth = getDynamicSliderWidth();
        if (window.matchMedia('(min-width: 992px)').matches && $(".wf_slider--one").length) {
            $(".wf_slider--one .wf_slider-item .wf_slider-wrapper .wf-row").css("width", $categories.hasClass("active") ? sliderWidth : "100%");
        } else {
            $(".wf_slider--one .wf_slider-item .wf_slider-wrapper .wf-row").css("width", "100%");
        }
    }

    /*
	Stock Alert
	*/
	let  numberPercent = document.querySelectorAll('.stock-countbar')
	let getPercent = Array.from(numberPercent)

	getPercent.map((items) => {
		let startCount = 0
		let progressBar = () => {
			startCount ++
		   // items.innerHTML = `<h3>${startCount}%</h3>`
		   if(startCount > 100) {
			   items.style.width = `100%`
		   }else{
			items.style.width = `${startCount}%`
		   }
			if(startCount == items.dataset.percentnumber) {
				clearInterval(stop)
			}
		}
		let stop = setInterval(() => {
			progressBar()
		},25)
	});

    // Quick Veiw Trigger
    $('.quickview-trigger').on('click',function(e){
        e.preventDefault();
        if (!$('.quickview-overlay').hasClass("active")) {
            $('.quickview-overlay').addClass('active');
            $('.quickview-close').focus();
            var e, t, i, n = document.querySelector(".quickview-overlay");
            let a = document.querySelector(".quickview-close"),
                s = n.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'),
                o = s[s.length - 1];
            if (!n) return !1;
            for (t = 0, i = (e = n.getElementsByTagName("a")).length; t < i; t++) e[t].addEventListener("focus", c, !0), e[t].addEventListener("blur", c, !0);
            function c() {
                for (var e = this; - 1 === e.className.indexOf("quickview-model-details");) "li" === e.tagName.toLowerCase() && (-1 !== e.className.indexOf("focus") ? e.className = e.className.replace(" focus", "") : e.className += " focus"), e = e.parentElement
            }
            document.addEventListener("keydown", function(e) {
                ("Tab" === e.key || 9 === e.keyCode) && (e.shiftKey ? document.activeElement === a && (o.focus(), e.preventDefault()) : document.activeElement === o && (a.focus(), e.preventDefault()))
            })
        } else {
            $('.quickview-trigger').focus();
            $('.quickview-overlay').removeClass('active');
        }
    });
    $('.quickview-close').on('click',function(){
        $('.quickview-trigger').focus();
        $('.quickview-overlay').removeClass('active');
    });

    // Run on window resize
    $(window).resize(handleResize);

    // Toggle menu visibility and animation on button click
    $(document).on('click', '.product-categories .product-categories-btn', function (e) {
        // If .wf_slider--nine exists, do nothing and return immediately
        if ($(".wf_slider--nine").length) {
            return;
        }
        e.preventDefault();
        e.stopPropagation();
        toggleMenu();
    });

    // Function to initialize headline and preloader on window load
    function initializeComponents() {
        $(window).on('load', function () {
            initHidePreloader();
            initOwlCarousels();
            initUpdateProgressBar();
            initLightbox();
            initTabContent();
            initializeCategoryMenu();
            handleResize();
        });
    }

    // Initialize headline and preloader
    initializeComponents();
	
	// Compare POPUP
    $("a").click(function (e) {
        if ($(this).hasClass('compare-btn') || $(this).hasClass('compare')) {
            e.preventDefault();
            $(this).attr("href", "javascript:void(0)");
             //alert("you are done");
            var check = `
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"
                width="70">
                <circle class="checkmark-circle" cx="26" cy="26" r="23" fill="none" />
                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
            </svg>

            <div>
                <p class="text-center">Item Added to Compare</p>
                   </div>`;
            var cart_pop = $('<div id="cart-add-check"></div>').html(check);
            $(cart_pop).appendTo("body");
            setTimeout(function () {
                $(cart_pop).remove();
                $(window).css("pointer-event", "none");
            }, 4000);
            var newval = Number($(".wf_navbar-compare-item .wf_compare_btn .shopire-wcwl-items-count").html()) + 1;
            $(".wf_navbar-compare-item .wf_compare_btn .shopire-wcwl-items-count").html(newval);

        }
    });
	
	// Wishlist POPUP
    $("a").click(function (e) {
        if ($(this).hasClass('add_to_wishlist') || $(this).hasClass('single_add_to_wishlist')) {
            e.preventDefault();
            $(this).attr("href", "javascript:void(0)");
            var check = `
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"
                width="70">
                <circle class="checkmark-circle" cx="26" cy="26" r="23" fill="none" />
                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
            </svg>

            <div>
                <p class="text-center">Item Added to Wishlist</p>
                   </div>`;
            var cart_pop = $('<div id="cart-add-check"></div>').html(check);
            $(cart_pop).appendTo("body");
            setTimeout(function () {
                $(cart_pop).remove();
                $(window).css("pointer-event", "none");
            }, 4000);
            var newval = Number($(".wf_navbar-favourite-item .wf_favourite_btn .shopire-wcwl-items-count").html()) + 1;
            $(".wf_navbar-favourite-item .wf_favourite_btn .shopire-wcwl-items-count").html(newval);

        }
    });

})(jQuery);


!function(o,e){"object"==typeof exports?module.exports=e(o.jQuery):o.owlcarousel2_filter=e(o.jQuery)}(window,function(o,e){"use strict";o.fn.owlcarousel2_filter=function(o,e){var t=this.data("owl.carousel").options;this.trigger("destroy.owl.carousel"),this.oc2_filter_clone||(this.oc2_filter_clone=this.clone());var l=this.oc2_filter_clone.children(o).clone();this.empty().append(l).owlCarousel(t)}});

jQuery(function($) {
    // Popular Product Carousel
    var owlPopularProducts = $(".popular-product-carousel .woocommerce .products");

    // Initialize Owl Carousel
    owlPopularProducts.addClass('owl-carousel owl-theme');
    owlPopularProducts.owlCarousel({
        rtl: $("html").attr("dir") == 'rtl',
        loop: false,
        nav: true,
        navText: ['<i class="fal fa-arrow-left"></i>', '<i class="fal fa-arrow-right"></i>'],
        dots: false,
        margin: 20,
        responsive: {
            0: { items: 1 },
            576: { items: 2 },
            992: { items: 4 }
        }
    });

    // Filter functionality
    $('.popular-product-carousel .owl-filter-bar').on('click', '.item', function() {
        var filter = $(this).data('owl-filter');

        // Remove current class from all items and add to clicked item
        $(this).siblings().removeClass('current');
        $(this).addClass('current');

        // Filter the items
        $('#loading-indicator').fadeIn(200);
        owlPopularProducts.fadeOut(200, function() {
            // Filter the items
            owlPopularProducts.owlcarousel2_filter(filter);

            // Fade in the filtered items
            owlPopularProducts.fadeIn(200, function() {
                // Refresh the carousel to adjust layout
                owlPopularProducts.trigger('refresh.owl.carousel');
                // Hide loading indicator after fading in
                $('#loading-indicator').fadeOut(200);
            });
        });
    });
});


