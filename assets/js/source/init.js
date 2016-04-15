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

    var postFadeIn = function(){
        $('.blog-contain').find('.block').each( function( index, el ) {
            if($(el).is('loaded')){
                // do nothing
            } else {
                $(el).addClass('loaded');
            }
        });
    };

    var jspdxBlogSearch = function(){

        // $('#blog-search-filter-ajax').on('change', 'input:checkbox', function(){
        //     // resload = '';
        //     $('.blog-contain').addClass('jspdx-loading');
        //     Cookies.set('post-cat', '', {expires: 1, path: '/'});
        //     Cookies.set('cook-resource_topic', '', {expires: 1, path: '/'});
        //     Cookies.set('cook-resource_type', '', {expires: 1, path: '/'});
        //
        //     clinBlogPageAjax('null');
        // });

        // $('#blog-search-filter-ajax').submit(function(){
        //     // resload = '';
        //     $('.blog-contain').addClass('jspdx-loading');
        //     Cookies.set('post-cat', '', {expires: 1, path: '/'});
        //     Cookies.set('cook-resource_topic', '', {expires: 1, path: '/'});
        //     Cookies.set('cook-resource_type', '', {expires: 1, path: '/'});
        //     clinBlogPageAjax('null');
        //     return false;
        // });

        $('body').on('click', '.nav-next', function(evt){
            evt.preventDefault();
            var nextpage = $(this).data('next-page');

            jspdxBlogPageAjax(nextpage);
        });

        // if($('body').is('.blog')){
        //     $(window).bind('beforeunload', function () {
        //         Cookies.set('post-cat', '', {expires: 1, path: '/'});
        //     });
        // }
        //
        // if($('body').is('.post-type-archive-resource-center')){
        //     $(window).bind('beforeunload', function () {
        //         Cookies.set('cook-resource_topic', '', {expires: 1, path: '/'});
        //         Cookies.set('cook-resource_type', '', {expires: 1, path: '/'});
        //     });
        // }
    };

    var infiniteBlogScroll = function(){
        $('.blog-contain').addClass('inf-scroll');
        if ($('body').find('.nav-next').length) {
            if ($('body').find('.nav-next').hasClass('loaded')) {
                // do nothing
            } else {
                if (isScrolledIntoView('.nav-next')) {
                    var nextPage = $('body').find('.nav-next').data('next-page');
                    if(nextPage && (!(nextPage == 'null' || nextPage < '2'))){
                        $('.nav-next').addClass('loaded');
                        jspdxBlogPageAjax(nextPage);
                    }
                }
            }
        }
    };

    var jspdxBlogPageAjax = function(pageNumber) {
        var domain = (document.domain),
            url = domain_url + 'wp-admin/admin-ajax.php',
            // formdata = $('#blog-search-filter-ajax').serialize(),
            ajaxFile = 'jspdx_get_post_type_ajax_view',
            postType = $('.blog-contain').data('postype');
            // postCat = Cookies.get('post-cat'),
            // resTopic = Cookies.get('cook-resource_topic'),
            // resType = Cookies.get('cook-resource_type');


        // formdata += '&action=' + ajaxFile;
        var formdata = '&action=' + ajaxFile;


        if(pageNumber != 'null' || pageNumber > '1') {
            formdata += '&nextpage=' + pageNumber;
        }
        if(postType){
            formdata += '&postType=' + postType;
        }

        // if($('#blog-search-filter-ajax .loading-div').length > 0 ){
            $('.jspdx-loader').addClass('jspdx-loader--loading');
        // } else {
        //     $('.jspdx-loader').addClass('jspdx-loader--loading');
        //     // $('#blog-search-filter-ajax').append('<div class="loading-div"><span>Loading...</span></div>');
        // }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url,
            data: formdata,
            success: function(data){
                $('body').find('.post-navigation').remove();
                if(data.html == ''){
                    $('.jspdx-loader').removeClass('jspdx-loader--loading');
                    // $('.blog-contain').append('<div class="no-data cf"><p>Sorry, there are currently no posts for your selection.</p></div>');
                    $('.blog-contain').removeClass('jspdx-loading');
                } else {
                    $('.jspdx-loader').removeClass('jspdx-loader--loading');
                    if(pageNumber && (!(pageNumber == 'null' || pageNumber < '2'))){
                        $('.blog-contain').append(data.html).removeClass('jspdx-loading').delay(500).queue(function (next) {
                            postFadeIn();
                            infiniteBlogScroll();
                            next();
                        });
                    } else {
                        $('.blog-contain').html(data.html).removeClass('jspdx-loading').delay(500).queue(function (next) {
                            postFadeIn();
                            infiniteBlogScroll();
                            next();
                        });
                    }
                    if($('body').is('.search-results')){
                        var keyword = $('#blog-keyword-search').find('#s').val();

                        $('body').find('.page-title span').hide().html(keyword).fadeIn();
                    }
                }
                // $('#blog-search-filter-ajax').find('.loading-div').fadeOut(300, function() { $(this).remove();});
            }
        });
    };

    var consoleMessage = function(){
        var styles = {
            "primary": "font-weight: bold; color: #FFF888000;"
        }

        if( typeof console === 'object' ) {
            console.log(
                '%c%s',
                'color: #ff8800; font-weight: bold;',
                '\n' +
                'Hey! Checking my site out?\n' +
                'That is actually pretty cool...\n' +
                'Looking for a new dev team to join.\n' +
                'Any ideas, tips, suggestions, or comments?\n' +
                'I\'d love to hear from you.\n' +
                'Link: http://www.joesnellpdx.com\n' +
                '\n' +
                '— @joesnellpdx\n\n'
            );
        }
    };

    function isScrolledIntoView(elem)
    {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();
        var elemTop = $(elem).offset().top;
        return ((elemTop <= docViewBottom) && (elemTop >= docViewTop));
    }

    $(document).ready(function( $ ) {
        primaryNavOpen();
        pageHeroTop();
        scrollToAnchor();
        jspdxBlogSearch();
        infiniteBlogScroll();
        consoleMessage();
    });

    $(window).load(function( $ ) {
        imgFitFunction();
        fadeIn();
        postFadeIn();
    });

    $(window).resize(function() {
    });

    $(window).scroll(function() {
        infiniteBlogScroll();
    });

})(jQuery);
