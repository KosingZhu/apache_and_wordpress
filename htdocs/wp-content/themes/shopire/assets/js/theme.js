! function($, b) {
    "use strict";
    var a = {
        eventID: "WfThemeJs",
        document: $(document),
        window: $(window),
        body: $("body"),
        classes: {
            toggled: "active",
            isOverlay: "overlay--enabled",
            mobileMainMenuActive: "wf_mobilenav-mainmenu--active",
            headerSearchActive: "wf_header-search--active",
            headerSidebarActive: "sidebar--active"
        },
        init: function() {
            this.document.on("ready", this.documentReadyRender.bind(this)),
                this.document.on("ready", this.menuFocusAccessibility.bind(this)),
                this.document.on("ready", this.headerHeight.bind(this)),
                this.document.on("ready", this.topbarMobile.bind(this)),
                this.document.on("ready", this.mobileNavRight.bind(this)),
                this.window.on("ready", this.documentReadyRender.bind(this))
        },
        documentReadyRender: function() {
            this.document.on("click." + this.eventID, ".wf_mobilenav-mainmenu-toggle", this.menuToggleHandler.bind(this)).on("click." + this.eventID, ".wf_header-closemenu", this.menuToggleHandler.bind(this)).on("click." + this.eventID, this.hideHeaderMobilePopup.bind(this)).on("click." + this.eventID, ".wf_mobilenav-dropdown-toggle", this.verticalMobileSubMenuLinkHandle.bind(this)).on("click." + this.eventID, ".wf_header-closemenu", this.resetVerticalMobileMenu.bind(this)).on("hideHeaderMobilePopup." + this.eventID, this.resetVerticalMobileMenu.bind(this)).on("click." + this.eventID, ".wf_navbar-search-toggle", this.searchPopupHandler.bind(this)).on("click." + this.eventID, ".wf_search-close", this.searchPopupHandler.bind(this)).on("click." + this.eventID, ".wf_navbar-sidebar-toggle", this.sidebarPopupHandler.bind(this)).on("click." + this.eventID, ".wf_sidebar-close", this.sidebarPopupHandler.bind(this)), this.window.on("scroll." + this.eventID, this.scrollToSticky.bind(this)).on("resize." + this.eventID, this.headerHeight.bind(this))
        },
        scrollToSticky: function(b) {
            var a = $(".is--sticky");
            this.window.scrollTop() >= 220 ? a.addClass("on") : a.removeClass("on")
        },
        headerHeight: function(d) {
            var a = $(".wf_header-navwrapper"),
                b = $(".wf_header-navwrapperinner"),
                c = 0;
            $("body").find("div").hasClass("is--sticky") && (b.each(function() {
                var a = this.clientHeight;
                a > c && (c = a)
            }), a.css("min-height", c))
        },
        topbarAccessibility: function() {
            var b, a, d, c = document.querySelector(".wf_mobilenav-topbar");
            var f = document.querySelector(".wf_mobilenav-topbar-toggle"),
                e = c.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'),
                g = e[e.length - 1];
            if (!c) return !1;
            for (a = 0, d = (b = c.getElementsByTagName("a")).length; a < d; a++) b[a].addEventListener("focus", h, !0), b[a].addEventListener("blur", h, !0);

            function h() {
                for (var a = this; - 1 === a.className.indexOf("wf_mobilenav-topbar");) "*" === a.tagName.toLowerCase() && (-1 !== a.className.indexOf("focus") ? a.className = a.className.replace(" focus", "") : a.className += " focus"), a = a.parentElement
            }
            document.addEventListener("keydown", function(a) {
                ("Tab" === a.key || 9 === a.keyCode) && f.classList.contains("active") && (a.shiftKey ? document.activeElement === f && (g.focus(), a.preventDefault()) : document.activeElement === g && (f.focus(), a.preventDefault()))
            })
        },
        topbarMobile: function() {
            var c = $(".wf_mobilenav-topbar-content"),
                b = $(".wf_header-widget"),
                a = $(".wf_mobilenav-topbar-toggle");
            !b.children().length > 0 ? a.hide() : (a.show(), a.on("click", function(b) {
                c.slideToggle(), a.toggleClass("active"), b.preventDefault()
            }), this.topbarAccessibility())
        },
        mobileNavRight: function() {
            $(".wf_navbar-right .wf_navbar-cart-item").clone().prependTo(".wf_mobilenav-right .wf_navbar-list-right");
        },
        menuFocusAccessibility: function(a) {
            $(".wf_navbar-nav, .widget_nav_menu").find("a").on("focus blur", function() {
                $(this).parents("ul, li").toggleClass("focus")
            })
        },
        menuToggleHandler: function(c) {
            var b = $(".wf_mobilenav-mainmenu-content"),
                a = $(".wf_mobilenav-mainmenu-toggle");
            this.body.toggleClass(this.classes.mobileMainMenuActive), this.body.toggleClass(this.classes.isOverlay), a.toggleClass(this.classes.toggled), b.fadeToggle(), this.body.hasClass(this.classes.mobileMainMenuActive) ? $(".wf_header-closemenu").focus() : a.focus(), this.menuAccessibility()
        },
        hideHeaderMobilePopup: function(a) {
            var b = $(".wf_mobilenav-mainmenu-toggle"),
                c = $(".wf_mobilenav-mainmenu");
            !$(a.target).closest(b).length && !$(a.target).closest(c).length && this.body.hasClass(this.classes.mobileMainMenuActive) && (this.body.removeClass(this.classes.mobileMainMenuActive), this.body.removeClass(this.classes.isOverlay), b.removeClass(this.classes.toggled), mobileMainmenuContent.fadeOut(), this.document.trigger("hideHeaderMobilePopup." + this.eventID), a.stopPropagation())
        },
        verticalMobileSubMenuLinkHandle: function(a) {
            a.preventDefault();
            var b = $(a.currentTarget);
            b.closest(".wf_mobilenav-mainmenu .wf_navbar-mainmenu"), b.parents(".dropdown-menu").length, this.isRTL, setTimeout(function() {
                b.parent().toggleClass("current"), b.next().slideToggle()
            }, 250)
        },
        resetVerticalMobileMenu: function(a) {
            $(".wf_mobilenav-mainmenu .wf_navbar-mainmenu");
            var b = $(".wf_mobilenav-mainmenu  .menu-item"),
                c = $(".wf_mobilenav-mainmenu .dropdown-menu");
            setTimeout(function() {
                b.removeClass("current"), c.hide()
            }, 250)
        },
        menuAccessibility: function() {
            var b, a, d, c = document.querySelector(".wf_mobilenav-mainmenu-content");
            var f = document.querySelector(".wf_header-closemenu:not(.off--layer)"),
                e = c.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'),
                g = e[e.length - 1];
            if (!c) return !1;
            for (a = 0, d = (b = c.getElementsByTagName("a")).length; a < d; a++) b[a].addEventListener("focus", h, !0), b[a].addEventListener("blur", h, !0);

            function h() {
                for (var a = this; - 1 === a.className.indexOf("wf_mobilenav-mainmenu-inner");) "li" === a.tagName.toLowerCase() && (-1 !== a.className.indexOf("focus") ? a.className = a.className.replace(" focus", "") : a.className += " focus"), a = a.parentElement
            }
            document.addEventListener("keydown", function(a) {
                ("Tab" === a.key || 9 === a.keyCode) && (a.shiftKey ? document.activeElement === f && (g.focus(), a.preventDefault()) : document.activeElement === g && (f.focus(), a.preventDefault()))
            })
        },
        searchPopupHandler: function(c) {
            var a = $(".wf_navbar-search-toggle"),
                b = $(".wf_search-field");
            this.body.toggleClass(this.classes.headerSearchActive), this.body.toggleClass(this.classes.isOverlay), this.body.hasClass(this.classes.headerSearchActive) ? b.focus() : a.focus(), this.searchPopupAccessibility()
        },
        searchPopupAccessibility: function() {
            var headers = document.querySelectorAll(".search--header");
            headers.forEach(function(c) {
                var f = c.querySelector(".wf_search-field");
                var e = c.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                var g = e[e.length - 1];
                if (!f || !g) return;
                var buttons = c.getElementsByTagName("button");
                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].addEventListener("focus", handleFocus, true);
                    buttons[i].addEventListener("blur", handleBlur, true);
                }

                function handleFocus() {
                    var el = this;
                    while (el && !el.classList.contains("search--header")) {
                        if (el.tagName.toLowerCase() === "input") {
                            if (el.classList.contains("focus")) {
                                el.classList.remove("focus");
                            } else {
                                el.classList.add("focus");
                            }
                        }
                        el = el.parentElement;
                    }
                }

                function handleBlur() {
                    handleFocus.call(this);
                }
                document.addEventListener("keydown", function(a) {
                    if (a.key === "Tab" || a.keyCode === 9) {
                        if (a.shiftKey) {
                            if (document.activeElement === f) {
                                g.focus();
                                a.preventDefault();
                            }
                        } else {
                            if (document.activeElement === g) {
                                f.focus();
                                a.preventDefault();
                            }
                        }
                    }
                });
            });
        },
        sidebarPopupHandler: function(d) {
            var a = $(".wf_navbar-sidebar-toggle"),
                b = $(".wf_sidebar"),
                c = $(".wf_sidebar-close");
            this.body.toggleClass(this.classes.headerSidebarActive), this.body.toggleClass(this.classes.isOverlay), a.toggleClass(this.classes.toggled), this.body.hasClass(this.classes.headerSidebarActive) ? ( /*b.addClass('1e3'),*/ c.focus()) : ( /*b.fadeOut(1e3),*/ a.focus()), this.sidebarPopupAccessibility()
        },
        sidebarPopupAccessibility: function() {
            var b, a, d, c = document.querySelector(".wf_sidebar");
            var f = document.querySelector(".wf_sidebar-close:not(.off--layer)"),
                e = c.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'),
                g = e[e.length - 1];
            if (!c) return !1;
            for (a = 0, d = (b = c.getElementsByTagName("button")).length; a < d; a++) b[a].addEventListener("focus", h, !0), b[a].addEventListener("blur", h, !0);

            function h() {
                for (var a = this; - 1 === a.className.indexOf("wf_sidebar-inner");) "input" === a.tagName.toLowerCase() && (-1 !== a.className.indexOf("focus") ? a.className = a.className.replace("focus", "") : a.className += " focus"), a = a.parentElement
            }
            document.addEventListener("keydown", function(a) {
                ("Tab" === a.key || 9 === a.keyCode) && (a.shiftKey ? document.activeElement === f && (g.focus(), a.preventDefault()) : document.activeElement === g && (f.focus(), a.preventDefault()))
            })
        }
    };
    a.init()
}(jQuery, window.asConfig);
(function($) {
    $.fn.btnloadmore = function(options) {
        var defaults = {
            showItem: $(this).data("limit"),
            whenClickBtn: $(this).data("col"),
            textBtn: $(this).data("loadname") ? $(this).data("loadname") : "Load More",
            classBtn: "",
            setCookies: false,
            delayToScroll: 2000,
        };

        var settings = $.extend(defaults, options);

        return this.each(function() {
            var container = $(this);
            var items = container.children();

            items.hide().slice(0, settings.showItem).show();

            if (items.filter(":hidden").length > 0) {
                var loadMoreBtn = $(`
                    <div class="wf-row wf-text-center wf-mt-5" style="align-items: center;">
                        <div class="wf-col-12">
                            <a href="javascript:void(0);" data-title="${settings.textBtn}" class="wf-btn wf-btn-primary wf-btn-loadmore ${settings.classBtn}">
                                ${settings.textBtn}
                            </a>
                        </div>
                    </div>
                `);

                container.after(loadMoreBtn);

                let uniqueClass = loadMoreBtn.find('a');

                uniqueClass.on("click", function(event) {
                    event.preventDefault();

                    items.filter(":hidden").slice(0, settings.whenClickBtn).slideDown();

                    if (items.filter(":hidden").length === 0) {
                        loadMoreBtn.fadeOut("slow");
                    }

                    container.animate({
                            scrollTop: container.scrollTop() + items.filter(":visible").last().offset().top - container.offset().top,
                        },
                        settings.delayToScroll
                    );
                });
            }
        });
    };
})(jQuery);