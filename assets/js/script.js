jQuery(function ($) {

	'use strict';


    // -------------------------------------------------------------
    //      Sticky Menu
    // -------------------------------------------------------------
        
        function menuSticky() { 
            var navHeight = $(".topper").height();

            ($(window).scrollTop() > navHeight) ? $('nav, .menu-toggle').addClass('sticky') : $('nav , .menu-toggle').removeClass('sticky');
        }




    // -------------------------------------------------------------
    //  	Offcanvas Menu
    // -------------------------------------------------------------

        (function () {
            var menutoggle = $(".menu-toggle");
            var offcanvasmenu = $("#offcanvas-menu");
            var closemenu = $(".close-menu");

            menutoggle.on("click" ,function(){
                offcanvasmenu.addClass("toggled");
                return false;
            });

            closemenu.on("click" ,function() {
                offcanvasmenu.removeClass("toggled");
                return false;
            });
        }());



    // -------------------------------------------------------------
    //      Single-Page-Menu-Scrolling  Easy Plugin
    // -------------------------------------------------------------

        $(function() {
            $('a.page-scroll').on('click', function(event) {
                var $anchor = $(this);
                $('html, body').stop().animate({
                    scrollTop: $($anchor.attr('href')).offset().top
                }, 1500, 'easeInOutExpo');
                event.preventDefault();
            });
        });


    // -------------------------------------------------------------
    // Sub-menu
    // -------------------------------------------------------------
        if ( $('.dropmenu').length) {
            $('.dropmenu').on("click" ,function(){
                $(this).parent().find('ul').slideToggle();
                return false;
            });
        }



    // -------------------------------------------------------------
    //      Cart-Box-Open/Remove
    // -------------------------------------------------------------

        (function() {
            var openclose = $(".cart-wrapper");

            openclose.on("click" ,function() {
                return $(this).toggleClass("open");
            });

        }());



    // -------------------------------------------------------------
    //      Search Bar
    // -------------------------------------------------------------

        (function () {
            var openbar = $(".open-bar");
            var searchbar = $("#search-bar");
            var closebar = $(".close-bar");

            openbar.on("click" ,function(){
                searchbar.addClass("active");
                return false;
            });

            closebar.on("click" ,function() {
                searchbar.removeClass("active");
                return false;
            });
        }());



    // -------------------------------------------------------------
    //      Slider
    // -------------------------------------------------------------    

        jQuery('#rev_slider_1').show().revolution({
            sliderLayout: 'auto',
            gridwidth: 1140,
            gridheight: 815,
            spinner:"off",
            hideTimerBar:"on",
            navigation: {
                arrows: {
                    enable: true,
                    style: 'zeus',
                    hide_onleave: false,
                    hide_onmobile: true,
                    hide_under: 480
                }
            }
        });


        jQuery('#rev_slider_2').show().revolution({
            sliderLayout: 'auto',
            gridwidth: 1140,
            gridheight: 815,
            spinner:"off",
            hideTimerBar:"on",
            navigation: {
                arrows: {
                    enable: true,
                    style: 'zeus',
                    hide_onleave: false,
                    hide_onmobile: true,
                    hide_under: 480
                }
            }
        });


        jQuery('#rev_slider_4').show().revolution({
            sliderLayout: 'auto',
            gridwidth: 1140,
            gridheight: 840,
            spinner:"off",
            hideTimerBar:"on",
            navigation: {
                arrows: {
                    enable: true,
                    style: 'zeus',
                    hide_onleave: false,
                    hide_onmobile: true,
                    hide_under: 480
                }
            }
        });


        jQuery('#rev_slider_5').show().revolution({
            sliderLayout: 'auto',
            gridwidth: 1140,
            gridheight: 860,
            spinner:"off",
            hideTimerBar:"on",
            navigation: {
                arrows: {
                    enable: true,
                    style: 'zeus',
                    hide_onleave: false,
                    hide_onmobile: true,
                    hide_under: 480
                }
            }
        });



        jQuery('#rev_slider_6').show().revolution({
            sliderLayout: 'auto',
            gridwidth: 1140,
            gridheight: 900,
            spinner:"off",
            hideTimerBar:"on",
            navigation: {
                arrows: {
                    enable: true,
                    style: 'zeus',
                    hide_onleave: false,
                    hide_onmobile: true,
                    hide_under: 480
                }
            }
        });



    // -------------------------------------------------------------
    //      Accordion - call
    // -------------------------------------------------------------

        if ($('#accordion').length) {
            $( "#accordion" ).accordion();
        }




    // -------------------------------------------------------------
    //      LightBox-Js
    // -------------------------------------------------------------

        if ($('#lightBox, #lightBox-2').length) {
            $('#lightBox, #lightBox-2').poptrox({
                usePopupCaption: true,
                usePopupNav: true,
                popupPadding: 0
            });
        }



    // -------------------------------------------------------------
    //      Achievement-Slider
    // -------------------------------------------------------------

        $(".achievement-slide").owlCarousel({
            loop: true,
            autoplay: true,
            items: 1,
            dots:true,
            nav: false,
            autoplayHoverPause: true,
            animateOut: 'slideOutUp',
            animateIn: 'slideInUp'
        });




    // -------------------------------------------------------------
    //      Boost-Slider
    // -------------------------------------------------------------

        if ($('.boost-carousel').length) {
            $('.boost-carousel').owlCarousel({
                loop:true,
                autoplay:true,
                autoplayTimeout: 3000,
                margin:30,
                dots:true,
                nav:true,
                navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
                responsive:{
                    0:{
                        items:1,
                        nav:false,
                        dots:true,
                        margin:0,
                    },
                    600:{
                        items:2,
                        nav:true,
                        dots:true,
                    },
                    1000:{
                        items:3
                    }
                }
            });
        }




    // -------------------------------------------------------------
    //      Team-Carousel-Slider
    // -------------------------------------------------------------

        if ($('.team-carousel').length) {
            $('.team-carousel').owlCarousel({
                loop:true,
                autoplay:false,
                autoplayTimeout: 3000,
                margin:30,
                nav:true,
                dots:false,
                navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
                responsive:{
                    0:{
                        items:1,
                        nav:true,
                        dots:false,
                    },
                    600:{
                        items:2,
                        nav:true,
                        dots:false,
                    },
                    1000:{
                        items:4
                    }
                }
            });
        }



    // -------------------------------------------------------------
    //      Finance-Carousel-Slider
    // -------------------------------------------------------------

        if ($('.finance-carousel').length) {
            $('.finance-carousel').owlCarousel({
                loop:true,
                autoplay:true,
                autoplayTimeout: 3000,
                margin:20,
                nav:true,
                dots:false,
                navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
                responsive:{
                    0:{
                        items:1,
                        nav:true,
                        dots:false,
                    },
                    600:{
                        items:2,
                        nav:true,
                        dots:false,
                    },
                    1000:{
                        items:4
                    }
                }
            });
        }




       
    // -------------------------------------------------------------
    //      Client-Slider
    // -------------------------------------------------------------

        if ($('.client-carousel').length) {
            $('.client-carousel').owlCarousel({
                loop:true,
                autoplay:true,
                autoplayTimeout: 2000,
                margin:10,
                nav:true,
                responsive:{
                    0:{
                        items:1,
                        nav:false,
                        dots:true,
                    },
                    600:{
                        items:4,
                        nav:false,
                        dots:true,
                    },
                    1000:{
                        items:7
                    }
                }
            });
        }




    //-------------------------------------------------------
    //  	counter Section
    //-------------------------------------------------------
       
        function funFactCounting() {
            if ($('.counting-section').length) {
                $('.counting-section').on('inview', function(event, visible, visiblePartX, visiblePartY) {
                    if (visible) {
                        $(this).find('.timer').each(function () {
                            var $this = $(this);
                            $({ Counter: 0 }).animate({ Counter: $this.text() }, {
                                duration: 2000,
                                easing: 'linear',
                                step: function () {
                                    $this.text(Math.ceil(this.Counter));
                                }
                            });
                        });

                        $(this).off('inview');
                    }
                });
            }
        }




    // -------------------------------------------------------------
    //      Progress Bar
    // -------------------------------------------------------------
     
        function progressBar() {
            $('.progressSection').on('inview', function(event, visible, visiblePartX, visiblePartY) {
                if (visible) {
                    $.each($('div.progress-bar'),function(){
                        $(this).css('width', $(this).attr('aria-valuenow')+'%');
                    });
                    $(this).off('inview');
                }
            });
        }




    // -------------------------------------------------------------
    //      Google Map
    // -------------------------------------------------------------

        if ($('#googleMap').length) {
            google.maps.event.addDomListener(window, 'load', init);
            
            function init() {
                var mapOptions = {
                    // How zoomed in you want the map to start at (always required)
                    zoom: 14,
                    scrollwheel: false,

                    // The latitude and longitude to center the map (always required)
                    center: new google.maps.LatLng(41.966770, -71.186996), // New York

                    // This is where you would paste any style found on Snazzy Maps.
                    styles:[{"featureType": "all","elementType": "labels.text.fill","stylers": [{"saturation": 36},{"color": "#333333"},{"lightness": 40}]},
                            {"featureType": "all","elementType": "labels.text.stroke","stylers": [{"visibility": "on"},{"color": "#ffffff"},{"lightness": 16}]},
                            {"featureType": "all","elementType": "labels.icon","stylers": [{"visibility": "off"}]},
                            {"featureType": "administrative","elementType": "geometry.fill","stylers": [{"color": "#fefefe"},{"lightness": 20}]},
                            {"featureType": "administrative","elementType": "geometry.stroke","stylers": [{"color": "#fefefe"},{"lightness": 17},{"weight": 1.2}]},
                            {"featureType": "landscape","elementType": "geometry","stylers": [{"color": "#f4f4f4"},{"lightness": 20}]},
                            {"featureType": "poi","elementType": "geometry","stylers": [{"color": "#f4f4f4"},{"lightness": 21}]},
                            {"featureType": "poi.park","elementType": "geometry","stylers": [{"color": "#48c7ec"},{"lightness": 21}]},
                            {"featureType": "road.highway","elementType": "geometry.fill","stylers": [{"color": "#ffffff"},{"lightness": 17}]},
                            {"featureType": "road.highway","elementType": "geometry.stroke","stylers": [{"color": "#ffffff"},{"lightness": 29},{"weight": 0.2}]},
                            {"featureType": "road.arterial","elementType": "geometry","stylers": [{"color": "#ffffff"},{"lightness": 18}]},
                            {"featureType": "road.local","elementType": "geometry","stylers": [{"color": "#ffffff"},{"lightness": 16}]},
                            {"featureType": "transit","elementType": "geometry","stylers": [{"color": "#48c7ec"},{"lightness": 19}]},
                            {"featureType": "water","elementType": "geometry","stylers": [{"color": "#a3ccff"},{"lightness": 17}]}]};

                            // Get the HTML DOM element that will contain your map 
                            var mapElement = document.getElementById('googleMap');

                            // Create the Google Map using our element and options defined above
                            var map = new google.maps.Map(mapElement, mapOptions);

                            // Let's also add a marker while we're at it
                            var marker = new google.maps.Marker({
                                position: new google.maps.LatLng(41.966770, -71.186996),
                                map: map,
                                title: 'Snazzy!'
                            });
            }
        }




    // -------------------------------------------------------------
    //  Back To Top
    // -------------------------------------------------------------

        function backToTopBtnAppear() {
            if ($("#toTop").length) {
                var windowpos = $(window).scrollTop(),
                    backToTopBtn = $("#toTop");

                if (windowpos > 300) {
                    backToTopBtn.fadeIn();
                } else {
                   backToTopBtn.fadeOut();
                }
            }
        }

        function backToTop() {
            if ($("#toTop").length) {
                var backToTopBtn = $("#toTop");
                backToTopBtn.on("click", function() {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 1000);
                    
                    return false;
                })
            }
        }



	// -------------------------------------------------------------
    // 		Preloader
    // -------------------------------------------------------------

        function preloader() {
            if($('#preloader').length) {
                $('#preloader').delay(100).fadeOut(500, function() {});
            }
        }
    
    


    // -------------------------------------------------------------
    //      WHEN WINDOW LOAD
    // -------------------------------------------------------------

        $(window).on("load", function() {

            preloader();

            funFactCounting();

            backToTop();

            new WOW().init();

            progressBar();

        })



    // -------------------------------------------------------------
    //      WHEN WINDOW SCROLL
    // -------------------------------------------------------------
        $(window).on("scroll", function() {

            backToTopBtnAppear();

            menuSticky();

        });

});   // Jquery-End