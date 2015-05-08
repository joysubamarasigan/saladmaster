(function ($, window, document) {
    "use strict";

    $(document).on( 'ready', function(){
        var $window   = $(window),
            $body     = $(document.body),

            header    = document.getElementById('header'),
            nav       = document.getElementById('nav'),
            primary   = document.getElementById('primary'),
            footer    = document.getElementById('footer'),
            copyright = document.getElementById('copyright'),
            logo      = document.getElementById('logo-img'),

            $header    = $( header ),
            $nav       = $( nav ),
            $primary   = $( primary ),
            $footer    = $( footer ),
            $copyright = $( copyright ),
            $logo      = $( logo ),

            onScrollEnd,

            detectDevice = function(){
                if ( YIT_Browser.isViewportBetween( 1024 ) ) {
                    $body.addClass('isMobile');
                    $("#animate-css").attr("disabled", "disabled");
                }
                else {
                    $body.removeClass('isMobile');
                    $("#animate-css").attr("disabled", false);
                }

                if ( YIT_Browser.isViewportBetween( 1024, 768 ) ) {
                    $body.addClass('isIpad');
                }
                else {
                    $body.removeClass('isIpad');
                }

                if ( YIT_Browser.isViewportBetween( 767 ) ) {
                    $body.addClass('isIphone');
                }
                else {
                    $body.removeClass('isIphone');
                }
            },

            fix_menu = function (){

                /* fix logo */
                if ( $('#logo').find('img').height() > 87 ){
                    var mmh = $('#menu-main-menu').children('li').outerHeight();
                    $('.skin1').find('#nav, #header-sidebar').css('margin-top', ( $('#header-container').height()  - mmh ) / 2+'px');
                }
            };

        /*************************
         * MISC
         *************************/

        if ( YIT_Browser.isIE8() ) {
            $('*:last-child').addClass('last-child');
        }

        if( YIT_Browser.isIE10() ) {
            $( 'html' ).attr( 'id', 'ie10' ).addClass( 'ie' );
        }

        // placeholder support
        if($.fn.placeholder) {
            $('input[placeholder], textarea[placeholder]').placeholder();
        }

        // detect device and add the class to body
        _onresize( detectDevice );
        detectDevice();

        $window.on('scroll', function(){
            $(".owl-carousel").each(function(){
                var owl = $(this).data('owlCarousel');

                if ( typeof owl != 'undefined' ) {
                    if ( onScrollEnd ) clearTimeout( onScrollEnd );

                    onScrollEnd = setTimeout(function(){
                        owl.play();
                    }, 500 );

                    owl.stop();
                }
            });
        });

        /*************************
         * Smooth Scroll Onepage
         *************************/
        $.fn.yit_onepage = function(){
            var nav = $(this);

            //smooth scrolling
             nav.on( 'click', 'a[href*=#]:not([href=#])', function(e) {

            var onepage_url = $('#logo-img').attr('href') + '/',
                current_page_url = location.origin + location.pathname;

            if ( onepage_url != current_page_url ){
                e.preventDefault();
                window.location.href = onepage_url + this.hash;
            }else if ( location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname ) {
                    var target = $(this.hash),
                        offsetSize = 34,
                        nearHeader = $header.next('div');

                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

                    if( $header.hasClass('sticky-header') && ! $body.hasClass('force-sticky-header') ){
                        offsetSize += $header.height();

                        if( nearHeader.attr('id') == 'primary' && nearHeader.find('.blog_big').length == 0 && nearHeader.find('.portfolio').length == 0 && nearHeader.find('.title_bar_single_product').length == 0  ){
                            offsetSize += 38;
                        }
                    }

                    if ( $body.hasClass('admin-bar') ) {
                        offsetSize += $('#wpadminbar').height();
                    }

                    if ( target.length ) {
                        $('html,body').animate({
                            scrollTop: target.offset().top - offsetSize
                        }, 1000, 'easeOutCirc');

                        return false;
                    }
                }
            });
        };

        $nav.yit_onepage();

        /*************************
         * Custom select
         *************************/

        var custom_select_style = function(){
            if ( $.fn.selectbox ) {
                var custom_selects = $('.faq-filters select,.widget.widget_archive select, .widget.widget_categories #cat, select#message-type-select, select#display_name, #dropdown_layered_nav_color, .wcml_currency_switcher');
                if ( custom_selects.length > 0 ) {
                    custom_selects.selectbox({
                        effect: 'fade'
                    });
                }
            }
        };
        $(document).on('yit_quick_view_loaded');
        custom_select_style();

        /*************************
         * Sticky Footer
         *************************/

        if ( $.fn.imagesLoaded ) {
            $primary.imagesLoaded(function () {
                if ( $footer.length > 0) {
                    $footer.stickyFooter();
                }
                else {
                    $copyright.stickyFooter();
                }
            });
        }

        /*************************
         * Replace type="number" in opera
         *************************/

        $('.opera').find('.quantity input.input-text.qty').replaceWith(function() {
            return '<input type="text" class="input-text qty text" name="quantity" value="' + $(this).attr('value') + '" />';
        });

        /*************************
         * Back to top
         *************************/

        var $backToTop = $( document.getElementById("back-top") );

        if ( $backToTop.length ) {
            // hide #back-top first
            $backToTop.hide();

            // fade in #back-top
            $window.on( 'scroll', function () {
                if ( $window.scrollTop() > 100 ) {
                    $backToTop.fadeIn();
                } else {
                    $backToTop.fadeOut();
                }
            });

            // scroll body to 0px on click
            $backToTop.on( 'click', 'a', function (e) {
                e.preventDefault();

                $('body,html').animate({
                    scrollTop: 0
                }, 800);
            });
        }

        /*************************
         * YIT Share
         *************************/

        var yit_share_init = function(){

            $( '.single-post .blog .share' ).add( '.single-post .blog .yit_post_meta .share').off('click').on('click', function(){
                var t       = $(this),
                    social  = t.find('.socials-container');

                if( social.is(':visible') ) {
                    social.slideUp('slow');
                } else {
                    social.slideDown('slow');
                }
            });
        };

        $body.on( 'yit_share_init', yit_share_init).trigger('yit_share_init');

        

        /*************************
         * FIX HEADER POSITION
         *************************/

        var fixHeaderPosition = function(){ 
            var header_height = $header.height(),
                nearHeader = $header.next('div');

            if( $header.hasClass('sticky-header') && ! $body.hasClass('force-sticky-header') ){  

                $('#header.sticky-header').addClass('fixed-header');
                if( $header.hasClass('sticky-header') ) {
                    $body.addClass('sticky-header');
                }

                if( nearHeader.attr('id') == 'primary' && 
                    nearHeader.find('.blog_big').length == 0 && 
                    nearHeader.find('.portfolio').length == 0 && 
                    nearHeader.find('.title_bar_single_product').length == 0  ){
                    header_height += 38;
                }

                nearHeader.not('.header-parallax').css( 'margin-top', header_height);
            } else {
                if( nearHeader.attr('id') == 'primary' && ( nearHeader.find('.blog_big').length != 0 || nearHeader.find('.portfolio').length != 0 || nearHeader.find('.title_bar_single_product').length != 0 ) ){
                    $('#primary').css({'margin-top': 0})
                }
            }
        };
        
        _onresize( fixHeaderPosition );
        $logo.imagesLoaded( fixHeaderPosition );

        /*************************
         * MENU
         *************************/

        var show_dropdown = function (t) {

                var options,
                    marginRight,
                    submenuWidth,
                    offsetMenuRight,
                    leftPos = 0,
                    containerWidth = $header.width(),
                    dropdown = $(t);

                
                    submenuWidth = dropdown.find('div.submenu').outerWidth();
                    offsetMenuRight = dropdown.position().left + submenuWidth;

                    if (offsetMenuRight > containerWidth)
                        options = { left: leftPos - ( offsetMenuRight - containerWidth ) };
                    else
                        options = {};

                    dropdown.find('ul.sub-menu:not(ul.sub-menu li > div.submenu > ul.sub-menu), ul.children:not(ul.children li > div.submenu > ul.children)').parent().css(options).stop(true, true).fadeIn(300);
            },

            hide_dropdown = function (t) {
                var dropdown = $(t);

                dropdown.find('ul.sub-menu:not(ul.sub-menu li > div.submenu > ul.sub-menu), ul.children:not(ul.children li > div.submenu > ul.children)').parent().fadeOut(300);
                $('.login-box').parent().fadeOut(300);
            };

        $('.nav').on( 'mouseenter mouseleave', 'ul > li', function(e){
            if ( e.type == 'mouseenter' ) show_dropdown( this );
            else if ( e.type == 'mouseleave' ) hide_dropdown( this );
        });


        //add class to li with submenu
        $nav.find('ul:not(.sub-menu) > li:not(.megamenu) div.submenu').each(function () {
            $(this).closest('li').addClass('dropdown');
        });

        $('.nav ul > li').each(function () {
            var $this_item = $(this);
            if ( $this_item.find('ul').length > 0 ) {
                $this_item.children('a').append('<span class="sf-sub-indicator"> +</span>');

                var add_padding = function () {
                    $this_item.children('a').css('padding-right', '').css({ paddingRight: parseInt($this_item.children('a').css('padding-right')) + 3 });
                };

                _onresize( add_padding );
                add_padding();
            }
        });

        $('#lang_sel').on('click', '.lang_sel_sel', function(e){
            e.preventDefault();
            $(this).next('ul').toggle();
        });

        $nav.on( 'mouseenter mouseleave', 'li:not(.megamenu) ul.sub-menu li, li:not(.megamenu) ul.children li, li:not(.bigmenu) ul.sub-menu li, li:not(.bigmenu) ul.children li', function(e){
            var $this = $(this);

            if ( e.type == 'mouseenter' ) {
                if ( $this.closest('.megamenu').length > 0 ) {
                    return;
                }
                var containerWidth = $header.width(),
                    containerOffsetRight = $header.offset().left + containerWidth,
                    submenuWidth = $this.find('ul.sub-menu, ul.children').parent().width(),
                    offsetMenuRight = $this.offset().left + submenuWidth * 2,
                    leftPos = -10;

                if (offsetMenuRight > containerOffsetRight)
                    $this.addClass('left');

                $this.find('ul.sub-menu, ul.children').parent().stop(true, true).fadeIn(300);
            }
            else if ( e.type == 'mouseleave' ) {
                if ( $this.closest('.megamenu').length > 0 || ( $this.closest('.bigmenu').length > 0 && ! $this.prev().hasClass('.bigmenu') ))
                    return;

                $this.find('ul.sub-menu, ul.children').parent().fadeOut(300);
            }
        });


        $(".isMobile li.menu-item-has-children > a").click(function( event ){
            event.preventDefault();
        });

        /*************************
         * HEADER RESPONSIVE
         *************************/

        if ( $nav.find('li.icon-home').length || $nav.find('li.icon-home-responsive').length ) {
            var mobile_menu_header = function () {

                if (  $(window).width() < 991 ) {
                    $nav.find('li.icon-home').addClass('icon-home-responsive').removeClass('icon-home');
                } else {
                    $nav.find('li.icon-home-responsive').addClass('icon-home').removeClass('icon-home-responsive');
                }

            };

            _onresize( mobile_menu_header );
            mobile_menu_header();
        }

        var fixHeaderResponsive = function(){
            var header_sidebar = $('#header-sidebar'),
                setIcons = function() {
                    if ( $(window).width() < 768 ) {
                        header_sidebar.find('a.menu-trigger').addClass('fa fa-bars');
                        header_sidebar.find('a.search_mini_button').addClass('fa fa-search');
                        header_sidebar.find('div#welcome-menu > ul > li, div#welcome-menu-login > ul > li').addClass('fa fa-user');
                    } else {
                        header_sidebar.find('a.menu-trigger').removeClass('fa fa-bars');
                        header_sidebar.find('a.search_mini_button').removeClass('fa fa-search');
                        header_sidebar.find('div#welcome-menu > ul > li, div#welcome-menu-login > ul > li').removeClass('fa fa-user');
                    }
                };

            if ( $(window).width() < 768 && $('#logo.mobile-clone').length == 0 ) {
                var logo = $('#logo:not(.mobile-clone)').clone(true, true);
                logo.addClass('mobile-clone').appendTo('#header-container > .container');
            }

            if ( $(window).width() < 768 && $('.nav.mobile-clone').length == 0 ) {
                var nav  = $('#nav:not(.mobile-clone)').clone(true, true).attr('id', '').addClass('main-nav'),
                    main_nav;

                main_nav = nav.addClass('mobile-clone').prependTo('#header-sidebar');

                main_nav.prepend( '<a href="#" class="menu-trigger" />');
                main_nav.find('img').parent().remove();
                //main_nav.children('ul').prepend( '<li class="menu-close menu-item" />');
                //main_nav.find('.menu-close').prepend( '<a href="#">x ' + yit.responsive_menu_close + '</a>' );

            }

            setIcons();
        };

        _onresize( fixHeaderResponsive );
        fixHeaderResponsive();

        /*************************
         * MOBILE MENU
         *************************/

        $header
            // menu opening
            .on('click', 'a.menu-trigger', function(e){
                e.preventDefault();

                var trigger = $(this),
                    menu = trigger.siblings('ul');

                menu.toggle();
            })

            // my account
            .on('click', 'li.login-menu a', function(e){
                e.preventDefault();

                $(this).unbind('mouseenter mouseleave');

                document.location = $(this).attr('href');
            });

        /*************************
         * SEARCH AUTOCOMPLETE
         *************************/

        if( $('#yith-s').length ){
            var search_autocomplete = function(){
                var search = $('#yith-s'),
                    a = search.outerWidth()+ 1,
                    new_left = search.offset().left,
                    search_skin1 = $('.skin1 .widget_search_mini .autocomplete-suggestions');

                if ( search_skin1.length >0 ){
                    search_skin1.css({
                        left: new_left,
                        width: a +'px !important'
                    });
                }
            };

            $(document).on( 'yit_ajax_search_init', search_autocomplete );
            _onresize( search_autocomplete );
        }

        /*************************
         * SEARCH MINI BUTTON
         *************************/

        $header.filter('.skin1').on('click', '.search_mini_button', function(e){
            e.preventDefault();

            var search_container = $(this).next();

            search_container.stop(true,true).slideToggle('slow', function(){
                search_container.trigger('yit_ajax_search_init');
            });
        });

        /*************************
         * NAV SUBINDICATOR
         *************************/

        if ( $body.hasClass('isMobile') && ! $body.hasClass('isPhone') && ! $body.hasClass('isPad')) {
            $nav.find('.sf-sub-indicator').parent().on( 'click', function () {
                var item = $(this).parent();
                item.toggle( show_dropdown, function () {
                    document.location = item.children('a').attr('href');
                })
            });
        }



        /*************************
         * MASONRY
         *************************/

        var add_masonry = function(){

            if ( $.fn.imagesLoaded && $.fn.masonry ) {
                $('.masonry').each( function(){
                    var container = $(this),
                        item = container.data('item');

                    if( item === 'undefined' ){
                        item = '.masonry_item';
                    }

                    container.imagesLoaded( function(){
                        container.masonry({
                            itemSelector: item,
                            isAnimated: true,
                        });
                    });
                });
            }

        };

        $(window).on( 'load resize', add_masonry );

        /*************************
         * WIDGETS
         *************************/

        $('.yit_toggle_menu ul.menu').each(function(){
            var menu = $(this);

            menu.filter('.open_first').find("> li:first-child").addClass("opened");
            menu.filter('.open_all').find("> li").addClass("opened");

            menu.filter('.open_active').find('li').filter('.current-menu-ancestor').addClass("opened");
            menu.filter('.open_active').find('li').filter('.current-menu-parent').addClass("opened");

            menu.find('> li > ul').hide();
            menu.find('> li.opened > ul').show();

            menu.on( 'click', '> li > a', function (e) {
                e.preventDefault();

                var submenu = $(this).next("ul"),
                    li = submenu.parent("li");

                li.hasClass("opened") ? li.removeClass("opened") : li.addClass("opened");

                submenu.slideToggle('slow');
            });
        });

        if ( $.fn.owlCarousel ) {
            $( '.slides-reviews-widget').each( function(){
                var slider = $(this);

                slider.owlCarousel({
                    singleItem     : true,
                    navigation     : true,
                    slideSpeed     : slider.data('slidespeed'),
                    navigationText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                    autoPlay       : slider.data('autoplay')

                });
            });
        }

        
    });

    /*************************
     * Smooth Scroll
     *************************/

    $.yit_smoothScroll = function() {
        if ( $.srSmoothscroll && navigator.userAgent.indexOf('Mac') == -1 && $.browser.webkit ) {

            $.srSmoothscroll({
                step  : 160,
                speed : 380,
                ease  : "easeOutCirc"
            });

        }
    }
    $.yit_smoothScroll();

})( jQuery, window, document );