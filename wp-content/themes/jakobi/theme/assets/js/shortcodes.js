(function ($, window, document) {
    "use strict";

    $(document).on( 'ready', function(){
        var $body = $('body'),
            content_width   = $('.content').width(),
            container_width = $('.container').width();

        /*************************
         * WAYPOINT
         *************************/

        $.fn.yit_waypoint = function() {
            if (typeof jQuery.fn.waypoint !== 'undefined') {
                $('.yit_animate:not(.animated)').waypoint(function() {
                    var delay = $(this).data('delay');
                    $(this).delay(delay).queue(function(next){
                        $(this).addClass('animated');
                        $(this).css('opacity','1');
                        next();
                    });
                }, {offset: '98%'});
            }
        };

        if ( ! YIT_Browser.isMobile() ) {
            $('.yit_animate:not(.animated)').yit_waypoint();
        }

        /*************************
         * FEATURES TAB
         *************************/

        $.fn.yiw_features_tab = function( options ) {
            var config = {
                'tabNav' : 'ul.features-tab-labels',
                'tabDivs': 'div.features-tab-wrapper'
            };

            if( options ) $.extend( config, options );

            this.each( function () {
                var tabNav  = $( config.tabNav, this );
                var tabDivs = $( config.tabDivs, this );
                var labelNumber = tabNav.children( 'li' ).length;

                tabDivs.children( 'div' ).hide();

                var currentDiv = tabDivs.children( 'div' ).eq( tabNav.children( 'li.current-feature' ).index() );
                currentDiv.show();

                $( 'li', tabNav ).hover( function() {
                    if( !$( this ).hasClass( 'current-feature' ) ) {
                        var currentDiv = tabDivs.children( 'div' ).eq( $( this ).index() );
                        tabNav.children( 'li' ).removeClass( 'current-feature' );

                        $( this ).addClass( 'current-feature' );

                        tabDivs.children( 'div' ).hide().removeClass( 'current-feature' );
                        currentDiv.fadeIn( 'slow', function() {
                            $(document).trigger('feature_tab_opened');
                        });
                    }
                });

            });
        };

        $( '.features-tab-container' ).yiw_features_tab();

        /*************************
         * TABS
         *************************/

        $.fn.yiw_tabs = function(options) {
            // valori di default
            var config = {
                'tabNav': 'ul.tabs',
                'tabDivs': '.containers',
                'currentClass': 'current'
            };

            if (options) $.extend(config, options);

            this.each(function() {
                var tabNav = $(config.tabNav, this);
                var tabDivs = $(config.tabDivs, this);
                var activeTab;
                var maxHeight = 0;

                tabDivs.children('div').hide();

                if ( $('li.'+config.currentClass+' a', tabNav).length > 0 )
                    activeTab = '#' + $('li.'+config.currentClass+' a', tabNav).data('tab');
                else
                    activeTab = '#' + $('li:first-child a', tabNav).data('tab');

                $(activeTab).show().addClass('showing').trigger('yit_tabopened');
                $('li:first-child a', tabNav).parents('li').addClass(config.currentClass);

                $('a', tabNav).click( function(){
                    if ( ! $(this).parent().parent().hasClass('current') ) {

                        var id = '#' + $(this).data('tab');
                        var thisLink = $(this);

                        $('li.'+config.currentClass, tabNav).removeClass(config.currentClass);
                        $(this).parents('li').addClass(config.currentClass);

                        $('.showing', tabDivs).fadeOut(200, function(){
                            $(this).removeClass('showing').trigger('yit_tabclosed');
                            $(id).fadeIn(200).addClass('showing').trigger('yit_tabopened');
                        });
                    }

                    return false;
                });


            });
        };

        $('.tabs-container').yiw_tabs({
            tabNav  : 'ul.tabs',
            tabDivs : '.border-box'
        });

        /*************************
         * PARALLAX
         *************************/

        $.fn.yit_parallax = function() {
            this.each(function() {

                var container = $(this),
                    $window = $(window),
                    $wrapper = $('#wrapper'),
                    video = container.find('video'),

                    vc = ( container.height() - container.find('.vertical_center').height() )/2,

                    onLoadMetaData = function(e) {
                        resizeVideo(e.target);
                    },

                    resizeVideo = function(videoObject) {
                        var percentWidth = videoObject.clientWidth * 100 / videoObject.videoWidth;
                        var videoHeight = videoObject.videoHeight * percentWidth / 100;
                        video.height(videoHeight);
                    };

                container.find('.vertical_center').css({top: vc+'px', marginBottom: 'auto'});

                video.on("loadedmetadata", onLoadMetaData);

                var parallaxvideofix = function(){
                    var windowsize = ! $('body').hasClass( 'boxed-layout' ) ? $window.width() : $wrapper.outerWidth();

                    $(".stretched-layout #primary .parallaxeos_outer, .header-parallax .parallaxeos_outer").css({
                        left: -( windowsize / 2 ),
                        width: windowsize
                    });

                    $(".slider .parallaxeos_outer").css({
                        left: "auto",
                        width: windowsize
                    });


                    // fix video size
                    resizeVideo(video);

                };

                _onresize( parallaxvideofix );
                parallaxvideofix();

                if( jQuery().prettyPhoto ){
                    $(".video-button a[rel^='prettyPhoto']").prettyPhoto({
                        social_tools:'',
                        default_width: 650,
                        default_height: 487,
                        show_title: false
                    });
                }

                if( container.closest('#primary').length > 0 || container.closest('.header-parallax').length > 0 ){
                    $(this).waypoint(function(direction){
                        $(this).find('.parallaxeos_animate').addClass('animated').trigger('animated');
                    }, { offset: '98%' , triggerOnce: false} );
                }


            });
        };

        // parallax
        $( '.parallaxeos_outer' ).yit_parallax();

        /*************************
         * IMAGE STYLED
         *************************/

        $(window).on('load', function () {
            if ($.fn.prettyPhoto) {
                $(".image-styled .img_frame a[rel^='prettyPhoto']").prettyPhoto({
                    social_tools: ''
                });
            }
        });


        /*************************
         * FIX WIDTH (sections, google maps, ecc...)
         *************************/

        var fixWidth = function(){
            var wrapperWidth = ( $body.hasClass('boxed-layout') ) ? $('#wrapper').outerWidth() : $(window).width();

            $('.section-background, .google-map-frame.full-width .inner').css({
                width:  wrapperWidth
            });
        };

        _onresize( fixWidth );
        fixWidth();

        /*************************
         * BLOG SECTION
         *************************/

        $('.blog-slider').each(function(){
            var t = $(this),
                slider = t.find('.blogs_posts'),
                enable_slider = slider.data('slider'),
                owl,
                slides = ( container_width == 1140 && content_width < container_width ) ? 2 : 4,
                fixArrows = function() {
                    var active_items  = slider.find('.owl-item.active').length,
                        slides_number = slider.find('.owl-item').length;

                    if( slides_number == active_items ) {
                        t.find('.prev-blog, .next-blog').hide();
                    } else {
                        t.find('.prev-blog, .next-blog').show();
                    }
                };

            if( enable_slider != 'no' && $.fn.owlCarousel ) {

                t.imagesLoaded(function(){
                    owl = slider.owlCarousel({
                        items : slides,
                        itemsDesktop: [1199, slides],
                        itemsDesktopSmall: [991, 1],
                        itemsTablet: [767, 1],
                        itemsMobile: [479, 1],
                        addClassActive: true
                    });
                });

                _onresize( fixArrows );
                fixArrows();

                t.on( 'click', '.prev-blog', function(e){
                    e.preventDefault();
                    owl.trigger('owl.prev');
                });

                t.on( 'click', '.next-blog', function(e){
                    e.preventDefault();
                    owl.trigger('owl.next');
                });
            }else {
                t.find('.prev-blog, .next-blog').hide();
                slider.find('li.blog_post').css( 'margin-bottom', '30px' );
            }
        });

       

        /*************************
         * SECTION BACKGROUND
         *************************/

        $('.section-background').each( function(){
            var section = $(this),
                section_background_fix_height = function(){
                    var current_height = section.height();

                    if ( current_height == 0 ){
                        var row = section.parents('.wpb_row'),
                            parent_height = row.next().height();

                        row.next().css('margin-bottom','25px');
                        section.css('height', parent_height+60);
                    }
                };

            $( window ).on( 'load', section_background_fix_height );
            _onresize( section_background_fix_height );
        });

        /*************************
         * FAQ
         *************************/

        $('#faqs-container').yit_faq();

    });

})( jQuery, window, document );