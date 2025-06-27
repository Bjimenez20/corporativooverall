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

        // Abre el menú lateral
        menutoggle.on("click", function () {
            offcanvasmenu.addClass("toggled");
            return false;
        });

        // Cierra el menú lateral
        closemenu.on("click", function () {
            offcanvasmenu.removeClass("toggled");
            return false;
        });

        // Manejo de submenús tipo dropdown (Servicios, Noticias, etc.)
        $("#offcanvas-menu .dropdown > a").on("click", function (e) {
            e.preventDefault(); // Evita que el enlace navegue

            var $submenu = $(this).next("ul");

            // Alterna el submenú actual (muestra/oculta)
            $submenu.slideToggle();

            // Cierra los demás submenús si se quiere comportamiento tipo acordeón
            $("#offcanvas-menu .dropdown > a").not(this).next("ul").slideUp();
        });
    })();




    // -------------------------------------------------------------
    //      Single-Page-Menu-Scrolling  Easy Plugin
    // -------------------------------------------------------------

    $(function () {
        $('a.page-scroll').on('click', function (event) {
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
    if ($('.dropmenu').length) {
        $('.dropmenu').on("click", function () {
            $(this).parent().find('ul').slideToggle();
            return false;
        });
    }



    // -------------------------------------------------------------
    //      Cart-Box-Open/Remove
    // -------------------------------------------------------------

    (function () {
        var openclose = $(".cart-wrapper");

        openclose.on("click", function () {
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

        openbar.on("click", function () {
            searchbar.addClass("active");
            return false;
        });

        closebar.on("click", function () {
            searchbar.removeClass("active");
            return false;
        });
    }());


    $(document).ready(function () {
        $("#partners-slider").owlCarousel({
            loop: true,
            margin: 20,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 5
                }
            }
        });
    });

    // -------------------------------------------------------------
    //      Slider
    // -------------------------------------------------------------    

    jQuery('#rev_slider_1').show().revolution({
        sliderLayout: 'auto',
        gridwidth: 1140,
        gridheight: 815,
        spinner: "off",
        hideTimerBar: "on",
        delay: 10000,
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
        spinner: "off",
        hideTimerBar: "on",
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
        spinner: "off",
        hideTimerBar: "on",
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
        spinner: "off",
        hideTimerBar: "on",
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
        spinner: "off",
        hideTimerBar: "on",
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
        $("#accordion").accordion();
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
        dots: true,
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
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
            margin: 30,
            dots: true,
            nav: true,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    dots: true,
                    margin: 0,
                },
                600: {
                    items: 2,
                    nav: true,
                    dots: true,
                },
                1000: {
                    items: 3
                }
            }
        });
    }




    // -------------------------------------------------------------
    //      Team-Carousel-Slider
    // -------------------------------------------------------------

    if ($('.team-carousel').length) {
        $('.team-carousel').owlCarousel({
            loop: true,
            autoplay: false,
            autoplayTimeout: 3000,
            margin: 30,
            nav: true,
            dots: false,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    dots: false,
                },
                600: {
                    items: 2,
                    nav: true,
                    dots: false,
                },
                1000: {
                    items: 6
                }
            }
        });
    }

        // -------------------------------------------------------------
    //      Team-Carousel-sector-Slider
    // -------------------------------------------------------------

    if ($('.team-carousel-sector').length) {
        $('.team-carousel-sector').owlCarousel({
            loop: true,
            autoplay: false,
            autoplayTimeout: 3000,
            margin: 30,
            nav: true,
            dots: false,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    dots: false,
                },
                600: {
                    items: 2,
                    nav: true,
                    dots: false,
                },
                1000: {
                    items: 4
                }
            }
        });
    }



    // -------------------------------------------------------------
    //      Finance-Carousel-Slider
    // -------------------------------------------------------------

    if ($('.finance-carousel').length) {
        $('.finance-carousel').owlCarousel({
            loop: true,
            autoplay: false,
            autoplayTimeout: 9000,
            margin: 20,
            nav: true,
            dots: false,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    dots: false,
                },
                600: {
                    items: 2,
                    nav: true,
                    dots: false,
                },
                1000: {
                    items: 4
                }
            }
        });
    }


    if ($('.finance-carousel-search').length) {
        $('.finance-carousel-search').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 9000,
            margin: 20,
            nav: true,
            dots: false,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    dots: false,
                },
                600: {
                    items: 2,
                    nav: true,
                    dots: false,
                },
                1000: {
                    items: 1
                }
            }
        });
    }





    // -------------------------------------------------------------
    //      Client-Slider
    // -------------------------------------------------------------

    if ($('.client-carousel').length) {
        $('.client-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 2000,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    dots: true,
                },
                600: {
                    items: 4,
                    nav: false,
                    dots: true,
                },
                1000: {
                    items: 7
                }
            }
        });
    }

    /*Input file*/

    function validateFile(input) {
        const file = input.files[0];
        const fileNameElement = document.getElementById('file-name');

        if (!file) {
            fileNameElement.textContent = 'Sin archivos seleccionados';
            return;
        }

        const allowedTypes = ['application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        const maxSizeMB = 5;

        if (!allowedTypes.includes(file.type)) {
            alert('Solo se permiten archivos PDF o Word.');
            input.value = ''; // Limpia el input
            fileNameElement.textContent = 'Sin archivos seleccionados';
            return;
        }

        if (file.size > maxSizeMB * 1024 * 1024) {
            alert('El archivo es demasiado grande. Máximo permitido: 5 MB.');
            input.value = '';
            fileNameElement.textContent = 'Sin archivos seleccionados';
            return;
        }

        fileNameElement.textContent = file.name;
    }


    //-------------------------------------------------------
    //  	counter Section
    //-------------------------------------------------------

    function funFactCounting() {
        if ($('.counting-section').length) {
            $('.counting-section').on('inview', function (event, visible, visiblePartX, visiblePartY) {
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
        $('.progressSection').on('inview', function (event, visible, visiblePartX, visiblePartY) {
            if (visible) {
                $.each($('div.progress-bar'), function () {
                    $(this).css('width', $(this).attr('aria-valuenow') + '%');
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
                styles: [{ "featureType": "all", "elementType": "labels.text.fill", "stylers": [{ "saturation": 36 }, { "color": "#333333" }, { "lightness": 40 }] },
                { "featureType": "all", "elementType": "labels.text.stroke", "stylers": [{ "visibility": "on" }, { "color": "#ffffff" }, { "lightness": 16 }] },
                { "featureType": "all", "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] },
                { "featureType": "administrative", "elementType": "geometry.fill", "stylers": [{ "color": "#fefefe" }, { "lightness": 20 }] },
                { "featureType": "administrative", "elementType": "geometry.stroke", "stylers": [{ "color": "#fefefe" }, { "lightness": 17 }, { "weight": 1.2 }] },
                { "featureType": "landscape", "elementType": "geometry", "stylers": [{ "color": "#f4f4f4" }, { "lightness": 20 }] },
                { "featureType": "poi", "elementType": "geometry", "stylers": [{ "color": "#f4f4f4" }, { "lightness": 21 }] },
                { "featureType": "poi.park", "elementType": "geometry", "stylers": [{ "color": "#00A3E1" }, { "lightness": 21 }] },
                { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{ "color": "#ffffff" }, { "lightness": 17 }] },
                { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{ "color": "#ffffff" }, { "lightness": 29 }, { "weight": 0.2 }] },
                { "featureType": "road.arterial", "elementType": "geometry", "stylers": [{ "color": "#ffffff" }, { "lightness": 18 }] },
                { "featureType": "road.local", "elementType": "geometry", "stylers": [{ "color": "#ffffff" }, { "lightness": 16 }] },
                { "featureType": "transit", "elementType": "geometry", "stylers": [{ "color": "#00A3E1" }, { "lightness": 19 }] },
                { "featureType": "water", "elementType": "geometry", "stylers": [{ "color": "#a3ccff" }, { "lightness": 17 }] }]
            };

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
            backToTopBtn.on("click", function () {
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
        if ($('#preloader').length) {
            $('#preloader').delay(100).fadeOut(500, function () { });
        }
    }




    // -------------------------------------------------------------
    //      WHEN WINDOW LOAD
    // -------------------------------------------------------------

    $(window).on("load", function () {

        preloader();

        funFactCounting();

        backToTop();

        new WOW().init();

        progressBar();

    })



    // -------------------------------------------------------------
    //      WHEN WINDOW SCROLL
    // -------------------------------------------------------------
    $(window).on("scroll", function () {

        backToTopBtnAppear();

        menuSticky();

    });

});   // Jquery-End