(function($) {

    var location_url = window.location.href;
    var domain_url = location_url.substring(0, location_url.indexOf('/', 14) ) + "/";

    var imgFitFunction = function(){

        if ( ! Modernizr.objectfit ) {
            $('.img-fit').each(function () {
                var $container = $(this),
                    imgUrl = '';

                if($container.find('img').attr('data-fallback-img')){
                    imgURL = $container.find('img').data('fallback-img');
                } else {
                    imgUrl = $container.find('img').prop('src');
                }
                if (imgUrl) {
                    $container
                        .css('backgroundImage', 'url(' + imgUrl + ')')
                        .addClass('compat-object-fit');
                }
            });
        }
    };

    var  isScrolledIntoView = function(elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();
        var elemTop = $(elem).offset().top;
        return ((elemTop <= docViewBottom) && (elemTop >= docViewTop));
    };

    var primaryNavOpen = function(){

        $('#nav-open-btn').on('click touchstart', function(evt) {
            evt.preventDefault();
            $('body').toggleClass('nav-open');
        });
    };

    var fadeIn = function() {
        $('body').addClass('js-loaded');
    };

    var pageHeroTop = function() {
        var target = $('#page-hero');
        
        if (target.length) {

            var distance = target.offset().top,
                $window = $(window),
                activeClass = 'hero-top';

            $window.scroll(function () {
                if ($window.scrollTop() >= distance) {
                    $('body').addClass(activeClass);
                } else if ($('body').hasClass(activeClass)) {
                    $('body').removeClass(activeClass);
                }
            });
        }
    };

    var scrollToAnchor = function(){

        var header_height = $('#nav').outerHeight();

        $('a[href*=#]:not([href=#])').click(function() {
            if($(this).is('.home-modal-btns__trigger')){
                // do nothing
            } else {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top - header_height
                        }, 1000);
                        return false;
                    }
                }
            }
        });

        if (window.location.hash.length){

            var target = window.location.hash; //Puts hash in variable, and removes the # character
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

            var ele = document.getElementById("theid");

            if(ele) {

                function scrollToTarget() {
                    $('html,body').animate({
                        scrollTop: $(target).offset().top - header_height
                    }, 1000);
                }

                if (target.length) {
                    if (target.match("^#gf")) {
                        setTimeout(scrollToTarget, 1000)
                    } else {
                        scrollToTarget();
                    }
                    return false;
                }
            }
        }
    };

    $(document).ready(function( $ ) {
        primaryNavOpen();
        pageHeroTop();
        scrollToAnchor();
    });

    $(window).load(function( $ ) {
        imgFitFunction();
        fadeIn();
    });

    $(window).resize(function() {
    });

    $(window).scroll(function() {
    });

})(jQuery);
