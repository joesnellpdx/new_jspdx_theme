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

    var pageHeroTop = function(){
        var target = $('#page-hero'),
            distance = target.offset().top,
            $window = $(window),
            activeClass = 'hero-top';

        $window.scroll(function() {
            if ( $window.scrollTop() >= distance ) {
                $('body').addClass(activeClass);
            } else if ($('body').hasClass(activeClass)) {
                $('body').removeClass(activeClass);
            }
        });
    };



    $(document).ready(function( $ ) {
        primaryNavOpen();
        pageHeroTop();
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
