(function($) {
    "use strict";
    
    /*****
     * Define some useful variables...
     *****/
    var $masonryContainer = $('.loop-masonry');
    
    /*****
     * Define some helpful functions...
     *****/
    function ts_lol() {
        // LOL
    }
     
    function ts_open_hover_menu(target) {
        var wrap = $(target).closest('.ts-hover-menu-wrap');
        wrap.not(".inuse").addClass("active inuse");
        if(wrap.find('.main-nav-search-sub-menu').length) {
            wrap.find('input[type="text"]').focus();
            wrap.closest('.main-nav').not('.ts-on-search').addClass('ts-on-search normal');
        }
    }

    function ts_close_hover_menus() {
        $(".ts-hover-menu-wrap").not(".active").removeClass("inuse");
        $(".ts-hover-menu-wrap.active").removeClass("active");
        $('#main-nav').not('.normal').removeClass('ts-on-search ts-on-shop');
        $('#main-nav:not(.normal):not(.ts-on-search):not(.ts-on-shop)').addClass('normal');
    }

    function ts_fix_section_margins() {  
        var ww = $('.wrap-inner').width();
        var w = $('#main-container').width();
        var margin = (ww - w) / 2;
        if(!$('#main').hasClass('fullwidth') && ($('#main').hasClass('no-sidebar')||$('#main').hasClass('sidebar-comments-right'))) {
            $('.ts-color-section-fullwidth').each(function() {
                    $(this).css('margin-left', '-'+margin+'px').css('margin-right', '-'+margin+'px');
            });
        }
    }

    function ts_browserWidth() {
        return $(window).width();
    }

    function ts_wrapWidth() {
        return $('#wrap').width();
    }

    function ts_topWrapHeight() {
        return Number($('#top-wrap').outerHeight(true)) + 200;
    }
       
    function ts_update_mini_cart() {
        if($('#ts-top-nav-shop-total').length) {
            var timestamp = $.now();
            $('#ts-top-nav-shop-total').load(ts_ajax_vars.ajaxurl+'?timestamp='+timestamp, {'action':'ts_reload_mini_cart'});
        }
    }
    
    function ts_update_postviews() {
        if($('#ts-postviews').length) {
            var timestamp = $.now();
            var pid = $('#ts-postviews').attr('data-pid');
            var nonce = $('#ts-postviews').attr('data-nonce');
            $.post(ts_ajax_vars.ajaxurl+'?timestamp='+timestamp, {'action':'ts_update_postviews','pid':pid,'nonce':nonce});
        }
    }

    function ts_email(a, b, c) {
        var text;  
        var tg='<';
        var at='@';
        var dest=a+at+b;
        text = (c=='' || !c) ? dest : c;
        document.write(tg+'a hr'+'ef="mai'+'lto:'+dest+'">'+text+tg+'/a>');
    }

    function ts_isRTL() {
        var isRTL = $('body').hasClass('rtl') ? true : false;
        return isRTL;
    }

    function ts_flexslider() {
        $('.entry .flexslider').imagesLoaded(function() {
            $(this).flexslider({
                smoothHeight: true,
                prevText: '<i class="fa fa-angle-left"></i>',
                nextText: '<i class="fa fa-angle-right"></i>',
                pauseOnAction: false,
                pauseOnHover: true
            });
        });
    }
        
    function ts_inview_animations() {
        if(ts_browserWidth() > 900 && !device.tablet() && !device.mobile()) {
            $('.ts-progress-bar').on("inview", function() {
                var progress = $(this).attr('data-percentage');
                $(this).animate({'width':'+'+progress+'%'}, 500).unbind('inview');
            });
            
            $("[class*='ts-fade-in']").each(function() {
                var delay = $(this).attr('data-delay');
                delay = (delay) ? delay : 0;
                var fade_class, ani, all_classes;
                all_classes = 'ts-fade-in ts-fade-in-from-left ts-fade-in-from-right ts-fade-in-from-top ts-fade-in-from-bottom';
                if($(this).hasClass('ts-fade-in-from-top')) {
                    fade_class = 'ts-fade-in-from-top';
                    ani = {opacity:1,top:0};
                } else if($(this).hasClass('ts-fade-in-from-right')) {
                    fade_class = 'ts-fade-in-from-right';
                    ani = {opacity:1,right:0};
                } else if($(this).hasClass('ts-fade-in-from-bottom')) {
                    fade_class = 'ts-fade-in-from-bottom';
                    ani = {opacity:1,bottom:0};
                } else if($(this).hasClass('ts-fade-in-from-left')) {
                    fade_class = 'ts-fade-in-from-left';
                    ani = {opacity:1,left:0};
                } else {
                    fade_class = 'ts-fade-in';
                    ani = {opacity:1};
                }
                if($(this).hasClass('ts-fade-in') || ts_browserWidth() < 720) {
                    $(this).on("inview",function(){
                        if(delay) {
                            $(this).delay(delay).animate({opacity:1}, 700, function() {
                                $(this).removeClass(all_classes).unbind('inview');
                            });
                        } else {
                            $(this).animate({opacity:1}, 700, function() {
                                $(this).removeClass(all_classes).unbind('inview');
                            });
                        }
                    });
                } else {
                    $(this).on("inview",function(){
                        if(delay) {
                            $(this).delay(delay).animate(ani, 500, function() {
                                $(this).removeClass(all_classes).unbind('inview');
                            });
                        } else {
                            $(this).animate(ani, 500, function() {
                                $(this).removeClass(all_classes).unbind('inview');
                            });
                        }
                    });
                }
            });
        } else {
            $('.ts-progress-bar').each(function() {
                var progress = $(this).attr('data-percentage');
                $(this).css({'width':progress+'%'});
            });
            $(".ts-fade-in,.ts-fade-in-from-left,.ts-fade-in-from-right,.ts-fade-in-from-top,.ts-fade-in-from-bottom").each(function() {
                $(this).css({'opacity':1,'top':'auto','right':'auto','bottom':'auto','left':'auto'}).unbind('inview');
            });
        }
    }

    function ts_magnificPopup() {
        $('a.mfp-iframe').magnificPopup({type:'iframe'});
        $('a.mfp-image').magnificPopup({
            type:'image',
            mainClass: 'mfp-with-zoom'
        });
        $('.ts-mfp-gallery').each(function() {
            $(this).magnificPopup({
                delegate: 'a.ts-image-link',
                type: 'image',
                gallery: {
                    enabled:true,
                    preload: [0,1]
                },
                mainClass: 'mfp-with-zoom'
            });
        });
    }
        
    function resizeMasonryEntries() {
        var prefix = ($masonryContainer.hasClass('portfolio-entries')) ? 'portfolio-' : '';
        if(ts_browserWidth() > 720) {
            $masonryContainer.removeClass('destroy-isotope').isotope({
                resizable: false,
                itemSelector: '.entry',
                layoutMode: 'masonry',
                transformsEnabled: (ts_isRTL()) ? false : true,
                masonry: {
                    gutterWidth: 0
                }
            }).isotope('reLayout', function() {
                $masonryContainer.parent().find('.threshold-pending').addClass('threshold');
            }).addClass('isotoped');
        } else {
            if($masonryContainer.hasClass('isotoped')) {
                $masonryContainer.isotope('destroy').removeClass('isotoped').parent().find('.threshold-pending').addClass('threshold');
            }
        }
    }
        
    function SFArrows() {
        var dir = ($('body').hasClass('rtl')) ? 'left' : 'right';
        $('.main-nav > ul.sf-menu > li > ul.sub-menu li a.sf-with-ul').each(function(){
            $(this).append('<span class="sf-sub-indicator"><i class="fa fa-angle-'+dir+'"></i></span>');
        });	
        $('.main-nav > div > ul.sf-menu > li > ul.sub-menu li a.sf-with-ul').each(function(){
            $(this).append('<span class="sf-sub-indicator"><i class="fa fa-angle-'+dir+'"></i></span>');
        });	
    }
    
    /*****
     * Call some helpful functions...
     *****/
    ts_update_mini_cart();
    ts_fix_section_margins();
    ts_inview_animations();
    ts_flexslider();
	SFArrows();
	ts_update_postviews();
    
    /*****
     * Miscellaneous fixes
     *****/
    $('.ts-hover-menu-link').on('click', function(e) {
        var target = $(e.target);
        ts_open_hover_menu(e.target);
    });
    
    $(document).on('click', function(e) {
        var target = $(e.target);
        if(!target.closest('.ts-hover-menu').length) {
            if(!target.is('input[name="Filedata"]')) {
                ts_close_hover_menus();
            }
        }
    });    
    
    $('.single-entry .post-password-form input[type="submit"]').addClass('button');
    
    if($('.ts-related-posts-on-single .entry').length < 1) {
        $('.ts-related-posts-on-single').remove();
    }
    
	/*****
	 * Responsive
	 *****/
	$(window).resize(function() {
        ts_fix_section_margins();
    });
    
    /*****
     * Fix image oembeds (eg. Flickr)
     * Why? In our functions file we wrap oembeds with a responsive div. 
     * Images don't need that, so we remove it here.
     *****/
    $('.ts-wp-oembed').not(':has(iframe)').not(':has(embed)').not(':has(object)').removeClass('fluid-width-video-wrapper');
    
    /*****
     * Flexslider
     *****/
    $('.loop-slider-wrap .flexslider').imagesLoaded(function() {
        $(this).flexslider({
            smoothHeight: true,
            controlsContainer: '.ts-main-flex-nav',
            directionNav: true,
            prevText: '<i class="fa fa-angle-left"></i>',
            nextText: '<i class="fa fa-angle-right"></i>',
            pauseOnAction: false,
            pauseOnHover: true
        });
    });
    $('.loop-slider-wrap.flexslider').imagesLoaded(function() {
        $(this).flexslider({
            smoothHeight: true,
            controlsContainer: '.ts-main-flex-nav',
            directionNav: true,
            prevText: '<i class="fa fa-angle-left"></i>',
            nextText: '<i class="fa fa-angle-right"></i>',
            pauseOnAction: false,
            pauseOnHover: true
        });
    });
    $('#ts-news-ticker-inner').flexslider({
        smoothHeight: true,
        controlsContainer: '#ts-news-ticker-nav',
        directionNav: true,
        prevText: '<i class="fa fa-caret-left"></i>',
        nextText: '<i class="fa fa-caret-right"></i>',
        pauseOnAction: false,
        pauseOnHover: true,
        slideshowSpeed: 5000
    });
    
	/*****
     * Owl Carousel
     *****/     
    if($('.owl-carousel').length) {
        $('.owl-carousel').owlCarousel({
            pagination:             false,
            rtl:                    ts_isRTL(),
            loop:                   true,
            margin:                 1,
            responsiveClass:        true,
            center:                 true,
            items:                  3,
            nav:                    true,
            autoplay:               true,
            autoplayTimeout:        5000,
            autoWidth:              true,
            smartSpeed:             500,
            responsiveRefreshRate:  500,
            autoplayHoverPause:     true,
            onRefresh:          function(event) {
                var desired_slide_w = this.$element.attr('data-desired-slide-width');
                var slide_w = this.$element.attr('data-slide-width');
                var slider_w = this._width;
                if(slider_w < desired_slide_w) {
                    slide_w = slider_w - 20;
                    this.$element.find('.carousel-item').css('width', slide_w+'px').attr('data-slide-width', slide_w);
                    this.$element.find('.owl-prev,.owl-next').css('width', '10px');
                    this.$element.attr('data-slide-width', slide_w);
                } else {
                    slide_w = desired_slide_w;
                    this.$element.find('.carousel-item').css('width', desired_slide_w + 'px').attr('data-slide-width', slide_w);
                    this.$element.attr('data-slide-width', slide_w);
                }
                var nav_w = (slider_w - slide_w - this.options.margin * 2) / 2;
                if(nav_w > 0) {
                    this.$element.find('.owl-prev,.owl-next').css('width', nav_w+'px');
                }
                if(nav_w < 50) {
                    this.$element.find('.owl-prev,.owl-next').addClass('no-bg-image');
                } else {
                    this.$element.find('.owl-prev,.owl-next').removeClass('no-bg-image');
                }
            },
            onInitialized:     function() {
                this.refresh();
            },
            onRefreshed:       function(event) {
                var desired_slide_w = this.$element.attr('data-desired-slide-width');
                var desired_slide_h = this.$element.attr('data-desired-slide-height');
                var slide_w = this.$element.attr('data-slide-width');
                var slider_w = this._width;
                if(slider_w < desired_slide_w) {
                    slide_w = slider_w - 20;
                } else {
                    slide_w = desired_slide_w;
                }
                var slider_h = (slider_w < desired_slide_w) ? slide_w * desired_slide_h / desired_slide_w : this.$element.height();
                this.$element.find('iframe').closest('.fluid-width-video-wrapper').css({'height':slider_h+'px','width':slide_w+'px'});
                this.$element.find('.carousel-item').css({'height':slider_h+'px','width':slide_w+'px'});
                this.$element.attr('data-slide-width', slide_w).attr('data-slide-height', slider_h);
                //console.log(this);    // for testing
            }
        });
    }
    
    /*****
     * Owl & Flexslider hover animation
     *****/
    if($('.loop-slider-wrap').length && ts_browserWidth() >= 800) {
        $('.loop-slider-wrap .ts-slider-item').hover(
            function() {
                $( this ).find('.descr').stop().slideDown(250);
            }, function() {
                $( this ).find('.descr').stop().slideUp(250);
            }
        );
    }
    
    /*****
	 * Mobile Nav
	 *****/
	$('#ts-top-mobile-menu').on('click', function() {
        if($('#main-nav').hasClass('is-open')) {
            $('#main-nav').stop().slideUp('fast', function() {
                $(this).removeClass('is-open');
            });
        } else {
            $('#main-nav').stop().slideDown('fast', function() {
                $(this).addClass('is-open');
            });
        }
	});
	
	/*****
     * Sticky Nav
     *****/
    if($('#sticky-top-container').length && !device.tablet() && !device.mobile()) {
        $(window).scroll(function(){
            if(ts_browserWidth() >= 940) {
                if ($(window).scrollTop() >= ts_topWrapHeight()){
                    $('#sticky-top-container').not('.stickied').addClass('stickied').fadeIn('fast');
                } else {
                    $('#sticky-top-container.stickied').removeClass('stickied').fadeOut('fast');
                }
            }
        });
    }
    
    /*****
     * Parallax
     *****/
    if(ts_browserWidth() > 900 && !device.tablet() && !device.mobile()) {
        //$('.ts-color-section-shortcode.parallax').parallax('50%',.6);
    }
    
    /*****
     * Infinite Scroll
     *****/
    function ts_infinite_scroll(element) {
        
        var infinite = $(element);
        
        infinite.find(".threshold").remove();
        infinite.find('.spinner').show();
        infinite.find(".alt-loader").hide();
        var qvars = $.parseJSON(infinite.find('.infinite-scroller-atts').text());
        var entries_container = infinite.parent().find('.entries');
        var timestamp = $.now();
        qvars.action = 'ts_load_infinite_blog';
        $.post(ts_ajax_vars.ajaxurl+'?timestamp='+timestamp, qvars, function(data) {
            var html_data = data;
            var entries = $(html_data).find('.loop').first().html();
            var new_qvars_str = $(html_data).find('.infinite-scroller-atts').first().text();
            var new_qvars = $.parseJSON(new_qvars_str);
            infinite.find('.infinite-scroller-atts').text(new_qvars_str);
            if(entries_container.hasClass('loop-masonry') && ts_browserWidth() > 720) {
                $masonryContainer.isotope('insert', $(entries));
                setTimeout(function() {
                    $masonryContainer.isotope('reLayout');
                    if(new_qvars.is_final == 1) {
                        $('.infinite-scroller').unbind("inview").remove();
                    } else {
                        infinite.prepend('<div class="threshold"></div>');
                    }
                }, 1000);
            } else {
                entries_container.append(entries);
                if(new_qvars.is_final == 1) {
                    $('.infinite-scroller').unbind("inview").remove();
                } else {
                    infinite.prepend('<div class="threshold"></div>');
                }
                infinite.find(".alt-loader").show();
                infinite.find('.spinner').hide();
            }
            ts_magnificPopup();
            ts_flexslider();
            ts_inview_animations();
        });
    }
    if($('.infinite-scroller').length) {
        
        var infinite = $('.infinite-scroller').first();
        var infinite_button = infinite.find('.alt-loader .button');
        infinite_button.on('click', function() { ts_infinite_scroll(infinite); });
        if(ts_browserWidth() > 720) {
            infinite_button.remove();
            infinite.on("inview", '.threshold', function() { ts_infinite_scroll(infinite); });
        } else {
            infinite.find('.spinner').hide();
        }
    }
    
    /*****
     * Featured photo captions on single pages
     *****/
    $('.single-entry .ts-featured-media-gallery .fp-caption-wrap').each(function() {
        var h = $(this).height();
        $(this).data('height', h).css("height",'0px').addClass('closed');
    }); 
    
    $('.single-entry .ts-featured-media-gallery').hover(
        function() {
            var h = $(this).find('.fp-caption-wrap').data('height');
            $( this ).find('.fp-caption-wrap').stop().animate({height:h+'px'});
        }, function() {
            $( this ).find('.fp-caption-wrap').stop().animate({height:'0px'});
        }
    );
    
    /*****
     * Smooth Page Scroll
     *****/
    if($('body').hasClass('smooth-page-scroll')) {
        addEvent("mousedown",smooth_page_scroll_mousedown);
        addEvent("mousewheel",smooth_page_scroll_wheel);
        smooth_page_scroll_init();
    }   
       
    /*****
     * Google Maps
     *****/
    jQuery(".flexible-map").each(function(){
        var e = jQuery(this).attr("id"), 
            t = jQuery(this).find(".title").val(),
            n = jQuery(this).find(".location").val(),
            r = jQuery(this).find(".coordinates").val(),
            i = parseInt(jQuery(this).find(".zoom").val()),
            s;
        r = r.split(",");var o=new google.maps.LatLng(r[0],r[1]);
        var styles = jQuery(this).attr('data-hue') ? [{featureType: "all",stylers: [{ hue: jQuery(this).attr('data-hue') }]}] : [];
        var sw = (jQuery(this).data('scrollwheel') == 'enabled' || jQuery(this).data('scrollwheel') == 'true') ? true : false;
        var u = {mapTypeId:google.maps.MapTypeId.ROADMAP,center:o,zoom:i,scrollwheel:sw,styles:styles};
        s = new google.maps.Map(jQuery("#"+e+" .map_canvas")[0],u);
        var a = new google.maps.Marker({map:s,position:o,title:n});
        var f = '<div class="map-infowindow">'+(t?"<h3>"+t+"</h3>":"")+n+"<br/>"+'<a href="https://maps.google.com/?q='+r+'" target="_blank">View on Google Map</a>'+"</div>";
        var l = new google.maps.InfoWindow({content:f});google.maps.event.addListener(a,"click",function(){l.open(s,a)});
    });
    
    /*****
     * WooCommerce
     *****/
    $('#woo-product-tabs li.reviews').on('click', function() {
        $('#review_form_wrapper').removeClass('hidden').find('p.stars span a').each(function() {
            $(this).html('<em>'+$(this).text()+'</em>');
        });
    });
    $('.products .ts-loop-product-top .add_to_cart_button.added').each(function() {
        $(this).closest('.product').addClass('in-cart');
    });
    /* woocommerce pre 2.3 */
    $('body.woocommerce-less-than-2dot3').on('adding_to_cart', function(a, b, c) {
        var pid = c.product_id.replace(/[^0-9.]/g, "")
        $(this).attr('data-currently-adding', pid);
        $('.products .post-'+pid).addClass('adding-to-cart');
        var the_button = $('.products .post-'+pid+' .add_to_cart_button');
        var add_to_cart_button_text = the_button.text();
        var add_to_cart_button_href = the_button.attr('href');
        the_button.attr('data-text', add_to_cart_button_text).attr('data-href', add_to_cart_button_href).attr('href', 'javascript:void(0)').css('opacity','.7').html('<i class="fa fa-cog fa-spin"></i>');
    });
    $('body.woocommerce-less-than-2dot3').on('added_to_cart', function(event, param1, param2) {
        var pid = $(this).attr('data-currently-adding');
        $(this).attr('data-currently-adding', '');
        $('.products .post-'+pid).removeClass('adding-to-cart').addClass('ts-in-cart');
        var button = $('.products .post-'+pid+' .add_to_cart_button');
        var add_to_cart_button_text = button.attr('data-text');
        var add_to_cart_button_href = button.attr('data-href');
        button.html('<i class="fa fa-check"></i>').attr('href', add_to_cart_button_href).css('opacity','');
        ts_update_mini_cart();
    });
    /* woocommerce 2.3+ */
    $('body.woocommerce-2dot3-plus .products .add_to_cart_button').on('click', function() {
        var pid = $(this).attr('data-product_id');
        $('body').attr('data-currently-adding', pid);
    });
    $('body.woocommerce-2dot3-plus').on('adding_to_cart', function() {
        var pid = $(this).attr('data-currently-adding');
        $('.products .post-'+pid).addClass('adding-to-cart');
        var the_button = $('.products .post-'+pid+' .add_to_cart_button');
        var add_to_cart_button_text = the_button.text();
        var add_to_cart_button_href = the_button.attr('href');
        the_button.attr('data-text', add_to_cart_button_text).attr('data-href', add_to_cart_button_href).attr('href', 'javascript:void(0)').css('opacity','.7').html('<i class="fa fa-cog fa-spin"></i>');
    });
    $('body.woocommerce-2dot3-plus').on('added_to_cart', function(event, param1, param2) {
        var pid = $(this).attr('data-currently-adding');
        $(this).attr('data-currently-adding', '');
        $('.products .post-'+pid).removeClass('adding-to-cart').addClass('ts-in-cart');
        var button = $('.products .post-'+pid+' .add_to_cart_button');
        var add_to_cart_button_text = button.attr('data-text');
        var add_to_cart_button_href = button.attr('data-href');
        button.html('<i class="fa fa-check"></i>').attr('href', add_to_cart_button_href).css('opacity','');
        ts_update_mini_cart();
    });
    $('#shiptobilling-checkbox').change(function() {
        if($(this).is(':checked')) {
            $('.shipping_address').addClass('hidden');
        } else {
            $('.shipping_address').removeClass('hidden');
        }
    });
    
    /*****
     * Share post
     *****/
    $('a.share-pop').click(function() {
        window.open($(this).attr('href'), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');
        return false;
    });
    $('.loop .entry .reveal-options').click(function() {
        $(this).hide();
        $(this).parent().find('.the-options').show("slide");
    });
    
    /*****
     * Smooth Scroll
     *****/
    var ts_smoothScrollOffset = ($('#wpadminbar').length) ? 28 : 0;
    ts_smoothScrollOffset = ($('#sticky-top-container').length) ? Number(ts_smoothScrollOffset) + 61 : ts_smoothScrollOffset;
    $('a.smoothscroll').smoothScroll({
        offset: -ts_smoothScrollOffset
    });
    $('a.reviews-smoothscroll').smoothScroll({
        offset: -ts_smoothScrollOffset,
        beforeScroll: function () {
            $('#woo-product-tabs li.reviews').click();
        }
    });
    $('a.reviews-smoothscroll').on('click', function() {
        $('.woocommerce-tabs li.reviews-tab a').click();
        $.smoothScroll({scrollTarget:'#reviews', offset: -ts_smoothScrollOffset});
    });
    $('.noreviews a.show_review_form').smoothScroll({
        offset: -ts_smoothScrollOffset
    });
    $('a#sticky-to-top').smoothScroll({offset: -ts_smoothScrollOffset});
    
    /*****
     * Tipsy
     *****/
    $('.tipped').tipsy({
        fade: true, 
        gravity: 's', 
        offset: ($('#wpadminbar').length) ? 37 : 5, 
        opacity: 1
    });
    
    /*****
     * Magnific Popup
     *****/
    if($.magnificPopup) {
        ts_magnificPopup();
    }
    
    
    /*****
     * Masonry
     *****/
    $masonryContainer.imagesLoaded(function() {
        resizeMasonryEntries();
    });
    $(window).resize(function() {
        resizeMasonryEntries();
    });
    
    if(ts_isRTL()) {
        $.Isotope.prototype._positionAbs = function( x, y ) {
            return { right: x, top: y };
        };
    }
        
    /*****
     * Toggles
     *****/
    $('.toggles-wrapper .accordion-block').each(function() {
        $(this).find('.tab-head').each(function(i) {
            $(this).click(function(){
                var open_icon = $(this).closest('.tog-acc-wrapper').data('open-icon');
                var closed_icon = $(this).closest('.tog-acc-wrapper').data('closed-icon');
                if($(this).hasClass('active')) {
                    $(this).removeClass('active').find('i').removeClass(open_icon).addClass(closed_icon)
                    .parent().siblings().slideUp(250).end().removeClass('open');
                } else {
                    $(this).addClass('active').find('i').removeClass(closed_icon).addClass(open_icon)
                        .parent().siblings().slideDown(250).end().addClass('open');
                }
            });
        });
    });
        
    /*****
     * Accordion
     *****/
    $('.accordion-wrapper .accordion-block').each(function() {
        $(this).find('.tab-head').each(function(i) {
            $(this).click(function(){
                var open_icon = $(this).closest('.tog-acc-wrapper').data('open-icon');
                var closed_icon = $(this).closest('.tog-acc-wrapper').data('closed-icon');
                if($(this).hasClass('active')) {
                    $(this).removeClass('active').find('i').removeClass(open_icon).addClass(closed_icon)
                    .parent().siblings().slideUp(250).end().removeClass('open');
                } else {
                    $(this).parent().siblings().find('.tab-head').removeClass('active')
                        .find('i').removeClass(open_icon).addClass(closed_icon);
                    $(this).parent().siblings().find('.tab-body').slideUp(250).end().removeClass('open');
                    $(this).addClass('active').find('i').removeClass(closed_icon).addClass(open_icon)
                        .parent().siblings().slideDown(250).end().addClass('open');
                }
            });
        });
    });
    
    /*****
     * Tabs
     *****/
    $(function(){
        $(".tab-widget .tab-header").each(function(){
            $(this).find("li").each(function(e){
                $(this).click(function(){
                    $(this).addClass("active").siblings().removeClass("active")
                        .parents(".tab-widget").find(".tab-context")
                        .hide().end().find(".tab-context:eq("+e+")").fadeIn(250);
                });
            });
        });
        $(".tab-widget").each(function(){
            var e=0;
            $(this).find(".tab-context.visible").each(function(t){e++});
            if(e<1){$(this).find(".tab-context").first().addClass("visible")}
        });
    });
    
    
    /*****
     * Superfish
     *****/   
    var superfish_options = {
        popUpSelector: '.main-nav ul.sub-menu,.main-nav ul.children,.sf-mega',
         delay:  500,
         autoArrows:    true,
         speed: 50,
         animation:   {opacity:'show'},
         onBeforeShow: function() {
            if($(this).hasClass('invert')) return false;
            var secondary = ($(this).parent().parent().hasClass('sf-menu')) ? true : false;
            var offset = $(this).parent().offset();
            if (typeof offset === 'undefined') {
                // do nothing
            } else {
                var dir = (ts_isRTL()) ? 'left' : 'right';
                var _o = ts_wrapWidth() - offset.left + ((ts_browserWidth() - ts_wrapWidth())/2);
                var o = (secondary) ? _o : _o - $(this).parent().outerWidth();
                if(o < $(this).outerWidth()) {
                    if(secondary) {
                        $(this).css(dir, '-'+(Math.abs(ts_wrapWidth() - offset.left + ((ts_browserWidth() - ts_wrapWidth())/2) - $(this).parent().width() - 10))+'px');
                    } else {
                        $(this).addClass('invert');
                    }
                }
            }
         },
         onHide: function() {
            $(this).removeClass('invert').css('right', '');
         }
    };
    $(".main-nav .sf-menu").superfish(superfish_options);
	
	
    /*****
     * UberMenu
     *****/
    if($('body').hasClass('ts-override-ubermenu-styling')) {
        $('.ubermenu-nav > li > .ubermenu-submenu-align-full_width').each(function() {
            var count = $(this).children('.ubermenu-column-auto').length;
            count = (count > 6) ? 6 : count;
            $(this).children('.ubermenu-column-auto').addClass('ts-boxed-1-of-'+count);
        });
    } 
})(jQuery);

