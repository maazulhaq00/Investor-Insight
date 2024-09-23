/*
Theme Name: investor_insight
Theme URI: http://themewar.com/html/investor_insight/
Author: ThemeWar
Author URI: http://themewar.com/
Description: Investor Insight.
Version: 1.0
License:
License URI:
*/

/*--------------------------------------------------------------------------
 [Table of contents]
--------------------------------------------------------------------------
1. Init Obj
2. Service Slider 01
3. Client Slider 01
4. Service Slider 02
5. Service Slider 03
6. Client Slider 02
7. Stretch Column
8. Suffle
9. Case Related Slider
10. Price Range UI Slider
11. Quantity Increment / Decrement
12. Custom Google Maps
13. Maitaince Loader
14. Count Down
15. Search Toggler
16. Rev Sliders
17. Funfact Count
18. Back To Top
19. Office Location Toggle
20. One Page Scroller
21. Skills
22. Light Case Popups
23. Mobile Menu
*/

(function($){
    'use strict';
    
    /*--------------------------------------------------------------------------
    / 1. Init Obj
    /--------------------------------------------------------------------------*/
    var service_01_slider = $('.service_01_slider'), 
        client_slider = $('.client_slider'),
        case_slider_01 = $('.case_slider_01'),
        testimonial_slider_01 = $('.testimonial_slider_01'),
        service_02_slider = $('.service_02_slider'),
        case_slider_02 = $('.case_slider_02'),
        related_case_slider = $('.related_case_slider'),
        slider_range = $("#slider-range"),
        countdown = $('#countdown_dashboard');
    
    /*--------------------------------------------------------------------------
    / 1. Service Slider 01
    --------------------------------------------------------------------------*/
    if(service_01_slider.length > 0){
        service_01_slider.owlCarousel({
            loop: false,
            margin: 0,
            responsiveClass: true,
            nav: true,
            dots: false,
            navText: ['<i class="bx bx-left-arrow-alt"></i>', '<i class="bx bx-right-arrow-alt"></i>'],
            responsive:{
                0:{
                    items: 1
                },
                600:{
                    items: 2
                },
                992:{
                    items: 3
                }
            }
        });
    }
    
    /*--------------------------------------------------------------------------
    / 2. Client Slider 01
    --------------------------------------------------------------------------*/
    if(client_slider.length > 0){
        client_slider.owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            nav: false,
            dots: false,
            responsive:{
                0:{
                    items: 2
                },
                600:{
                    items: 4
                },
                992:{
                    items: 6
                }
            }
        });
    }
    
    /*--------------------------------------------------------------------------
    / 3. Client Slider 01
    --------------------------------------------------------------------------*/
    if(case_slider_01.length > 0){
        case_slider_01.owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            nav: false,
            dots: false,
            responsive:{
                0:{
                    items: 1
                },
                600:{
                    items: 2
                },
                992:{
                    items: 3
                }
            }
        });
        
        $('.case_prev').click(function() {
            case_slider_01.trigger('prev.owl.carousel');
        })
        $('.case_next').click(function() {
            case_slider_01.trigger('next.owl.carousel');
        })
    }
    
    /*--------------------------------------------------------------------------
    / 4. Service Slider 02
    --------------------------------------------------------------------------*/
    if(testimonial_slider_01.length > 0){
        testimonial_slider_01.owlCarousel({
            loop: false,
            margin: 0,
            responsiveClass: true,
            nav: true,
            dots: true,
            navText: ['<i class="bx bx-left-arrow-alt"></i>', '<i class="bx bx-right-arrow-alt"></i>'],
            responsive:{
                0:{
                    items: 1
                },
                600:{
                    items: 2
                },
                992:{
                    items: 3
                }
            }
        });
    }
    
    /*--------------------------------------------------------------------------
    / 5. Service Slider 03
    --------------------------------------------------------------------------*/
    if(service_02_slider.length > 0){
        service_02_slider.owlCarousel({
            loop: false,
            margin: 0,
            responsiveClass: true,
            nav: true,
            dots: false,
            navText: ['<i class="bx bx-left-arrow-alt"></i>', '<i class="bx bx-right-arrow-alt"></i>'],
            responsive:{
                0:{
                    items: 1
                },
                600:{
                    items: 2
                },
                992:{
                    items: 3
                }
            }
        });
    }
    
    /*--------------------------------------------------------------------------
    / 6. Client Slider 02
    --------------------------------------------------------------------------*/
    if(case_slider_02.length > 0){
        case_slider_02.owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            nav: false,
            dots: false,
            responsive:{
                0:{
                    items: 1
                },
                600:{
                    items: 2
                },
                900:{
                    items: 3
                },
                1200:{
                    items: 4
                }
            }
        });
        
        $('.case_prev').click(function() {
            case_slider_02.trigger('prev.owl.carousel');
        })
        $('.case_next').click(function() {
            case_slider_02.trigger('next.owl.carousel');
        })
    }
    
    /*--------------------------------------------------------------------------
    / 7. Stretch Column
    --------------------------------------------------------------------------*/
    function tw_stretch() {
        var i = $(window).width();
        $(".row .tw-stretch-element-inside-column").each(function() {
            var $this = $(this),
                row = $this.closest(".row"),
                cols = $this.closest('[class^="col-"]'),
                colsheight = $this.closest('[class^="col-"]').height(),
                rect = this.getBoundingClientRect(),
                l = row[0].getBoundingClientRect(),
                s = cols[0].getBoundingClientRect(),
                r = rect.left,
                d = i - rect.right,
                c = l.left + (parseFloat(row.css("padding-left")) || 0),
                u = i - l.right + (parseFloat(row.css("padding-right")) || 0),
                p = s.left,
                f = i - s.right,
                styles = {
                    "margin-left": 0,
                    "margin-right": 0
                };
            if (Math.round(c) === Math.round(p)) {
                var h = parseFloat($this.css("margin-left") || 0);
                styles["margin-left"] = h - r;
            }
            if (Math.round(u) === Math.round(f)) {
                var w = parseFloat($this.css("margin-right") || 0);
                styles["margin-right"] = w - d;
            }
            $this.css(styles);
        });
    }
    tw_stretch();
    
    /*--------------------------------------------------------------------------
    / 8. Suffle
    --------------------------------------------------------------------------*/
    $(window).on('load', function () {
        if ($(".shafull_container").length > 0)
        {
            var $grid = $('.shafull_container');
            $grid.shuffle({
                itemSelector: '.shaf_item',
                sizer: '.shaf_sizer'
            });
            /* reshuffle when user clicks a filter item */
            $('.shaf_filter li').on('click', function () {
                // set active class
                $('.shaf_filter li').removeClass('active');
                $(this).addClass('active');
                // get group name from clicked item
                var groupName = $(this).attr('data-group');
                // reshuffle grid
                $grid.shuffle('shuffle', groupName);
            });
        }
    });
    
    /*--------------------------------------------------------------------------
    / 9. Case Related Slider
    --------------------------------------------------------------------------*/
    if(related_case_slider.length > 0){
        related_case_slider.owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            nav: false,
            dots: false,
            responsive:{
                0:{
                    items: 1
                },
                600:{
                    items: 1
                },
                992:{
                    items: 2
                }
            }
        });
    }
    
    /*--------------------------------------------------------------------------
    / 10. Price Range UI Slider
    --------------------------------------------------------------------------*/
    if (slider_range.length > 0) {
        slider_range.slider({
            range: true,
            min: 0,
            max: 800,
            values: [18, 600],
            slide: function (event, ui) {
                $("#amount").html("$" + ui.values[ 0 ] + " — $" + ui.values[ 1 ]);
            }
        });
        $("#amount").html("$" + $("#slider-range").slider("values", 0) + " — $" + $("#slider-range").slider("values", 1));
    }
    
    /*--------------------------------------------------------------------------
    / 11. Quantity Increment / Decrement
    --------------------------------------------------------------------------*/
    if ($(".qtyBtn").length > 0)
    {
        $(".btnMinus").on('click', function () {
            var vals = parseInt($(this).next(".carqty").val(), 10);

            if (vals > 1)
            {
                vals -= 1;
                $(this).next(".carqty").val(vals);
            } else
            {
                $(this).next(".carqty").val(vals);
            }
            return false;
        });
        $(".btnPlus").on('click', function () {
            var vals = parseInt($(this).prev(".carqty").val(), 10);
            vals += 1;
            $(this).prev(".carqty").val(vals);
            return false;
        });
    }
    
    /*--------------------------------------------------------------------------
    / 12. Custom Google Maps
    /-------------------------------------------------------------------------*/
    if ($("#google_map").length > 0)
    {
        var map;
        map = new GMaps({
            el: "#google_map",
            lat: 24.8607,
            lng: 67.0011,
            zoom: 15,
        });
        
        var image = "";
        map.addMarker({
            lat: 24.8607,
            lng: 67.0011,
            icon: "images/marker.png",
            animation: google.maps.Animation.DROP,
            verticalAlign: "bottom",
            horizontalAlign: "center",
            backgroundColor: "#d3cfcf"
        });
        var styles = [
            {
                "featureType": "road",
                "stylers": [
                    {"color": "#FFFFFF"}
                ]
            }, {
                "featureType": "water",
                "stylers": [
                    {"color": "#ededed"}
                ]
            }, {
                "featureType": "landscape",
                "stylers": [
                    {"color": "#f7f7f7"}
                ]
            }, {
                "elementType": "labels.text.fill",
                "stylers": [
                    {"color": "#e5e5e5"}
                ]
            }, {
                "featureType": "poi",
                "stylers": [
                    {"color": "#e5e5e5"}
                ]
            }, {
                "elementType": "labels.text",
                "stylers": [
                    {"saturation": 1},
                    {"weight": 0.1},
                    {"color": "#717171"}
                ]
            }

        ];
        map.addStyle({
            styledMapName: "Styled Map",
            styles: styles,
            mapTypeId: "map_style"
        });

        map.setStyle("map_style");
    }
    
    /*--------------------------------------------------------------------------
     / 13. Maitaince Loader
     /------------------------------------------------------------------------*/
    $(window).on('load', function () {
        if ($('.maintanance_bar').length > 0) {
            $('.maintanance_bar').each(function () {
                var $this = $(this);
                var today = new Date();

                var date1 = new Date($this.attr('data-sd'));
                var date2 = new Date($this.attr('data-ed'));

                var totaldiffTime = Math.abs(date2 - date1);
                var totaldiffDays = Math.ceil(totaldiffTime / (1000 * 60 * 60 * 24));

                var todaydiffTime = Math.abs(date1 - today);
                var todaydiffDays = Math.ceil(todaydiffTime / (1000 * 60 * 60 * 24));

                var parcents = (todaydiffDays / totaldiffDays) * 100;
                parcents = parcents.toFixed();
                $('.mb_child', $this).animate({'width': parcents + '%'}, 2000);

                $this.find('.percentst').each(function () {
                    var $this = $(this);
                    $({Counter: 0}).animate({Counter: parcents}, {
                        duration: 2000,
                        easing: 'swing',
                        step: function () {
                            $this.text(Math.ceil(this.Counter) + '%');
                        }
                    });
                });
            });
        }
    });
    
    /*--------------------------------------------------------------------------
     / 14. Count Down
     /------------------------------------------------------------------------*/
    if (countdown.length > 0) {
        var d = countdown.attr('data-day');
        var m = countdown.attr('data-month');
        var y = countdown.attr('data-year');
        countdown.countdown({
            until: new Date(y, m - 1, d),
            format: 'DHMS'
        });
    }
    
    /*--------------------------------------------------------------------------
    / 15. Search Toggler
    /------------------------------------------------------------------------*/
    $('.src_btn').on('click', function (e) {
        e.preventDefault();
        $('.popup_search_sec').toggleClass('active');
    });
    $('.popup_search_overlay').on('click', function () {
        $('.popup_search_sec').removeClass('active');
    });
    $('.popup_search_form input').on('focus', function(){
        $('.popup_search_form').addClass('focused');
    });
    $('.popup_search_form input').on('blur', function(){
        $('.popup_search_form').removeClass('focused');
    });
    
    /*--------------------------------------------------------------------------
    / 16. Rev Sliders
    /------------------------------------------------------------------------*/
    var revapi = jQuery('#rev_slider_1').show().revolution({
        delay: 7000,
        responsiveLevels: [1200, 1140, 778, 480],
        gridwidth: [1110, 920, 700, 380],
        sliderLayout: 'auto',
        minHeight: '660',
        onHoverStop: 'off',
        navigation: {
            onHoverStop: 'off',
            arrows: {
                enable: false,
                style: 'uranus',
                hide_onmobile: false,
                hide_onleave: false,
                left: {
                    h_align: "left",
                    v_align: "center",
                    h_offset: 30,
                    v_offset: 0
                },
                right: {
                    h_align: "right",
                    v_align: "center",
                    h_offset: 30,
                    v_offset: 0
                }
            },
            bullets: {
                enable: true,
                style: 'custom',
                h_align: "right",
                v_align: "center",
                direction: 'vertical',
                tmp: '<div class="tp-title-wrap"><span class="tp-arr-titleholder">{{title}}</span><span class="timers"></span></div>',
                space: 56,
                hide_onmobile: true,
                hide_onleave: false,
                h_offset: 0,
                v_offset: 0,
                container: 'layergrid',
            }
        }
    });
    revapi.one('revolution.slide.onloaded', function () {
        var currentSlide = revapi.revcurrentslide();
        //currentSlide = (currentSlide < 10 ? '0'+currentSlide : currentSlide);
        $('.tp-bullet .timers').stop(true).css('width', '0%');
        $(".tp-bullet:eq("+currentSlide+") .timers").animate({
            'width': '100%'
        }, 7000);
    });
    revapi.on('revolution.slide.onbeforeswap', function (event, data) {
        var currentSlide = revapi.revcurrentslide();
        $('.tp-bullet .timers').stop(true).css('width', '0%');
        $(".tp-bullet.selected .timers").animate({
            'width': '100%'
        }, 7000);
    });
    
    var revapi_2 = jQuery('#rev_slider_2').show().revolution({
        delay: 7000,
        responsiveLevels: [1200, 1140, 778, 480],
        gridwidth: [1110, 920, 700, 380],
        sliderLayout: 'auto',
        minHeight: '783',
        navigation: {
            arrows: {
                enable: true,
                style: 'custom',
                hide_onmobile: false,
                hide_onleave: false,
                left: {
                    h_align: "left",
                    v_align: "center",
                    h_offset: 30,
                    v_offset: 0
                },
                right: {
                    h_align: "right",
                    v_align: "center",
                    h_offset: 30,
                    v_offset: 0
                }
            },
            bullets: {
                enable: false
            }
        }
    });
    var revapi_3 = jQuery('#rev_slider_3').show().revolution({
        delay: 7000,
        responsiveLevels: [1200, 1140, 778, 480],
        gridwidth: [1110, 920, 700, 380],
        sliderLayout: 'fullscreen',
        navigation: {
            arrows: {
                enable: true,
                style: 'custom',
                hide_onmobile: false,
                hide_onleave: false,
                left: {
                    h_align: "left",
                    v_align: "center",
                    h_offset: 30,
                    v_offset: 76
                },
                right: {
                    h_align: "right",
                    v_align: "center",
                    h_offset: 30,
                    v_offset: 76
                }
            },
            bullets: {
                enable: false
            }
        }
    });
    
    var revapi_4 = jQuery('#rev_slider_4').show().revolution({
        delay: 7000,
        responsiveLevels: [1200, 1140, 778, 480],
        gridwidth: [1110, 920, 700, 380],
        sliderLayout: 'auto',
        minHeight: '660',
        navigation: {
            arrows: {
                enable: true,
                style: 'custom',
                hide_onmobile: false,
                hide_onleave: false,
                left: {
                    h_align: "left",
                    v_align: "center",
                    h_offset: 30,
                    v_offset: 0
                },
                right: {
                    h_align: "right",
                    v_align: "center",
                    h_offset: 30,
                    v_offset: 0
                }
            },
            bullets: {
                enable: false
            }
        }
    });
    
    /*--------------------------------------------------------
    / 17. Funfact Count
    /----------------------------------------------------------*/
    $('.counters').appear();
    $(document.body).on('appear', '.counters', function(e, $affected) {
        $affected.each(function() {
            var $this = $(this);
            if(!$this.hasClass('appeared')){
                jQuery({Counter: 0}).animate({Counter: $this.attr('data-count')}, {
                    duration: 3000,
                    easing: 'swing',
                    step: function () {
                        var num = Math.ceil(this.Counter).toString();
                        $this.html(num+"+");
                    }
                });
                $this.addClass('appeared');
            }
        });
    });
    
    /*--------------------------------------------------------
    / 18. Back To Top
    /----------------------------------------------------------*/
    $('.scroll_to_btn').on('click', function(e){
        e.preventDefault();
        $('html, body').animate({scrollTop : $(this.hash).offset().top - 0}, 1000);
        return false;
    });

    var back = $("#backtotop"), body = $("body, html");
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > $(window).height())
        {
            back.css({bottom: '50px', opacity: '1', visibility: 'visible'});
        } else
        {
            back.css({bottom: '-50px', opacity: '0', visibility: 'hidden'});
        }

    });
    body.on("click", "#backtotop", function (e) {
        e.preventDefault();
        body.animate({scrollTop: 0}, 800);
        return false;
    });
    
    /*--------------------------------------------------------
    / 19. Office Location Toggle
    /----------------------------------------------------------*/
    $('.office_locations > a').on('click', function(e){
        e.preventDefault();
        $('.all_off_locations').slideToggle();
    });
    
    /*--------------------------------------------------------
    / 20. One Page Scroller
    /----------------------------------------------------------*/
    if($(".isSticky").length > 0){
        var header_height = $(".isSticky").height();
        $(window).on('scroll', function(){
            if($(window).scrollTop() > 300)
            {
                $('.blanks').css('height', header_height);
                $(".isSticky").addClass('fixedHeader animated slideInDown');
            }else
            {
                $('.blanks').css('height', '0');
                $(".isSticky").removeClass('fixedHeader animated slideInDown');
            }
            Scroll();
        });
    }

    $('.menu_1 ul li.scroll > a').on('click', function(){
        $('html, body').animate({scrollTop : $(this.hash).offset().top - 68}, 1000);
        return false;
    });

    function Scroll(){
        var contentTop = [];
        var contentBottom = [];
        var winTop = $(window).scrollTop();
        var rangeTop = 200;
        var rangeBottom = 500;

        $('.menu_1').find('.scroll > a').each(function(){
            var atr = $(this).attr('href');
            if($(atr).length > 0)
            {
                contentTop.push($($(this).attr('href')).offset().top);
                contentBottom.push($($(this).attr('href')).offset().top + $($(this).attr('href')).height());
            }
        });

        $.each(contentTop, function(i){
            if(winTop > contentTop[i] - rangeTop){
                $('.menu_1 li.scroll').removeClass('active').eq(i).addClass('active');
            }
        });
    }
    
    /*--------------------------------------------------------
    / 21. Skills
    /----------------------------------------------------------*/
    if ($(".single_skill").length > 0)
    {
        $('.single_skill').appear();
        $('.single_skill').on('appear', loadSkills);
    }
    var coun = true;
    function loadSkills()
    {
        $(".single_skill").each(function () {
            var datacount = $(this).attr("data-parcent");
            $(".ss_child", this).animate({'width': datacount + '%'}, 2000);
            if (coun)
            {
                $(this).find('span').each(function () {
                    var $this = $(this);
                    $({Counter: 0}).animate({Counter: datacount}, {
                        duration: 2000,
                        easing: 'swing',
                        step: function () {
                            $this.text(Math.ceil(this.Counter) + '%');
                        }
                    });
                });

            }
        });
        coun = false;
    }
    
    /*--------------------------------------------------------
    / 22. Light Case Popups
    /----------------------------------------------------------*/
    $('.light_pops').lightcase({
        transition: 'elastic',
        showSequenceInfo: false,
        slideshow: false,
        swipe: true,
        showTitle: false,
        controls: true
    });
    
    /*--------------------------------------------------------
    / 23. Mobile Menu
    /----------------------------------------------------------*/
    $(window).on("load resize", function (e) {
        if ($(window).width() < 991) {
            $('.menuButton a').on('click', function (e) {
                e.preventDefault();
                $('.menu_1 > ul').stop(true, true).slideToggle();
            });
            $('.menu_1 ul li.menu-item-has-children').each(function () {
                var $this = $(this);
                $this.append('<span class="submenu_toggler"><i class="bx bx-down-arrow-alt"></i></span>');
            });
            $('.menu_1 ul li.menu-item-has-children > span.submenu_toggler').on('click', function () {
                var $this = $(this);
                
                if ($(this).hasClass('active-span')) {
                    $('i', $this).removeClass('bx-up-arrow-alt').addClass('bx-down-arrow-alt');
                } else {
                    $('i', $this).addClass('bx-up-arrow-alt').removeClass('bx-down-arrow-alt');
                }

                $(this).prev('ul.sub-menu').slideToggle();
                $(this).toggleClass('active-span');
            });
        };
    });
    
    /*--------------------------------------------------------
    / 24. Site Preloader
    /----------------------------------------------------------*/
    $(window).on('load', function (event) {
        $('.preloader').delay(800).fadeOut(500);
    });
    
    /*--------------------------------------------------------
    / 25. Site Preloader
    /----------------------------------------------------------*/
    $('#contact_form').on('submit', function (e) {
        e.preventDefault();
        var $this = $(this);

        $('button[type="submit"]', this).attr('disabled', 'disabled');
        $('.fn_loader', this).fadeIn();

        var form_data = $this.serialize();

        var required = 0;
        $(".required", this).each(function () {
            if ($(this).val() === '')
            {
                $(this).addClass('reqError');
                required += 1;
            } else
            {
                if ($(this).hasClass('reqError'))
                {
                    $(this).removeClass('reqError');
                    if (required > 0)
                    {
                        required -= 1;
                    }
                }
            }
        });

        if (required === 0) {
            $.ajax({
                type: 'POST',
                url: 'contact_us?action=submit',
                data: {form_data: form_data},
                success: function (data) {
                    $('button[type="submit"]', $this).removeAttr('disabled');
                    $('.fn_loader', $this).fadeOut();

                    $('.con_message', $this).fadeIn().html('<div class="alert alert-success" role="alert"><strong>Congratulations!</strong> Your query successfully sent to site admin.</div>');
                    setTimeout(function () {
                        $('.con_message', $this).fadeOut().html('');
                    }, 5000);
                }
            });
        } else {
            $('button[type="submit"]', $this).removeAttr('disabled');
            $('.fn_loader', $this).fadeOut();
            $('.con_message', $this).fadeIn().html('<div class="alert alert-danger" role="alert"><strong>Opps!</strong> Errpr found. Please fix those and re submit.</div>');
            setTimeout(function () {
                $('.con_message', $this).fadeOut().html('');
            }, 5000);
        }

    });
    $(".required").on('keyup', function () {
        $(this).removeClass('reqError');
    });
    
})(jQuery);