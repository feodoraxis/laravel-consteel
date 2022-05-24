jQuery(function($) {
function is_mobile() {return (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));}
function is_OSX() {return navigator.platform.match(/(Mac|iPhone|iPod|iPad|Android)/i) ? true : false;}

$("[type=tel]").mask("+7 (999) 999-99-99");

var mobile_width = 576;

function offsetLeft( parameters ) {

    if ( parameters.length < 1 )
        return;

    var windowWidth = $(window).width(), param_name,
        maxWidth = 1300, left = 50, key, params = {};

    if ( windowWidth <= 1200 )
        left = 20;

    if ( windowWidth <= mobile_width )
        left = 15;

    if ( windowWidth > maxWidth )
        left = (windowWidth - maxWidth) / 2;

    for ( i = 0; i < parameters.length; i++ ) {
        if ( i < 1 )
            key = '0';
        else
            key = i;

        if ( !parameters[ key ]['element'] )
            return;

        if ( parameters[ key ]['offset'] == 'margin' )
            param_name = 'margin-left';
        else
            param_name = 'padding-left';

        params[ param_name ] = left;

        if ( parameters[ key ]['moreLeft'] )
            params[ param_name ] += parameters[ key ]['moreLeft'];

        $( parameters[ key ]['element'] ).css( params );

        params = {};
    }

    return;
}

function right( parameters ) {

    if ( parameters.length < 1 )
        return;

    var windowWidth = $(window).width(),
        maxWidth = 1300, right = 20, key;

    if ( windowWidth > maxWidth ) {
        right = (windowWidth - maxWidth) / 2;
    }

    for ( i = 0; i < parameters.length; i++ ) {
        if ( i < 1 )
            key = '0';
        else
            key = i;

        if ( !parameters[ key ] )
            return;

        $( parameters[ key ] ).css({
            'right': right
        });
    }

    return;
}

$("#search_button button").click(function() {
    if ( $("#search_button").hasClass('open') ) {
        $("#search_button").removeClass('open');
        $("#main_search").slideUp(300);
    } else {
        $("#search_button").addClass('open');
        $("#main_search").slideDown(300);
    }
});

$(document).mouseup(function (e){
    var el = $("#main_search"),
        el2 = $("#search_button");
    if (!el.is(e.target) && el.has(e.target).length === 0 && !el2.is(e.target) && el2.has(e.target).length === 0) {
        $("#search_button").removeClass('open');
        $("#main_search").slideUp(300);
    }
});

$(".modal .close").click(function(e) {
    e.preventDefault();

    $(this).closest('.modal').fadeOut(300);
    $('body,html').removeAttr('style');
});

cart_table_main_summ_ml();
setTimeout( cart_table_main_summ_ml, 500 );
setTimeout( cart_table_main_summ_ml, 1000 );
setTimeout( cart_table_main_summ_ml, 1500 );
$(window).on('resize', cart_table_main_summ_ml);

function cart_table_main_summ_ml() {
    if ( !$('.cart__table-main_summ').length )
        return;

    if ( window.innerWidth <= 993 ) {
        $('.cart__table-main_summ').removeAttr('style');
        return;
    }

    var ml  = parseInt($('.cart__table-body > .cart__table-item:first-child .cart__table-name').width());
        ml += parseInt($('.cart__table-body > .cart__table-item:first-child .cart__table-price').width());
        ml += parseInt($('.cart__table-body > .cart__table-item:first-child .cart__table-price').css('margin-right'));

    $('.cart__table-main_summ').css({
        'margin-left': ml
    });
}

//Новое
if ( $("#single_configuration").length && !is_mobile() && !is_OSX() ) {
    $('#single_configuration').addClass('single_configuration-windows');
}

$(".show_full_config").click(function(){
    var show_text = $(this).attr('data-show_text'),
        hide_text = $(this).attr('data-hide_text'),
        delay = 300;

    if ( $(this).hasClass('open') ) {
        $(this)
            .removeClass('open')
            .text( show_text );

        $(this)
            .closest('.product-configuration-body')
            .find('.product-configuration-hidden')
            .slideUp(delay);
    } else {
        $(this)
            .addClass('open')
            .text( hide_text );

        $(this)
            .closest('.product-configuration-body')
            .find('.product-configuration-hidden')
            .slideDown(delay);
    }
});
//Новое (конец)

// Сравнение новое. Переделано.
$("#catalog__categoryes a").click(function(e){
    e.preventDefault();

    var need_tab = $(this).attr('data-for');

    $('.compare-tab').removeClass('compare-tab-active');
    $( need_tab ).addClass('compare-tab-active');
    return;
});

if ( $("#compare_products_1").length ) {
    var tabs_length = $('.compare-tab').length,
        compares = {};

    for ( i = 1; i <= tabs_length; i++ ) {
        compares[ i ] = $("#compare_products_" + i);

        compares[ i ].owlCarousel({
            items: 3,
            loop: false,
            dots: false,
            nav: true,
            onInitialized: function(e) {
                $("#compare_products_" + i + " .owl-stage > .owl-item:nth-child(" + get_l_products_compare() + ") .compare-products-item-product").addClass('last');
                return;
            },
            responsive: {
                0: {
                    items: 2,
                    nav: false,
                },
                993: {
                    items: 2,
                    nav: true,
                },
                1200: {
                    items: 3,
                    nav: true,
                }
            }
        });

        compares[ i ].on('changed.owl.carousel', function(e) {
            $("#compare_products_" + i + " .owl-stage > .owl-item .compare-products-item-product")
                .removeClass('first')
                .removeClass('last');

            $("#compare_products_" + i + " .owl-stage > .owl-item:nth-child(" + ( e.property.value ) + ") .compare-products-item-product").addClass('last');
            $("#compare_products_" + i + " .owl-stage > .owl-item:nth-child("+( e.property.value + get_l_products_compare() )+") .compare-products-item-product").addClass('last');
            return;
        });

    }

    var compare_slider_mobile = $('.compare-slider_mobile');
    compare_slider_mobile.owlCarousel({
        items: 1,
        loop: false,
        dots: false,
        nav: true,
        margin: 0,
    });
}

// Сравнение новое. Переделано (конец)

function get_l_products_compare () {
    if ( window.innerWidth >= 1200 )
        return 3;

    return 2;
}
// Новое
$('.has_child span').click(function() {

    var thi = $(this),
        parent = thi.parent(),
        child = parent.children('ul');

    if ( parent.hasClass('open') ) {
        parent.removeClass('open');
        child.slideUp(100);

        return;
    }

    parent.addClass('open');
    child.slideDown(100);
});

$('.filter-item-docs').click(function(e){
    var el = $(this).children('div'),
        stop = false;

    if ( el.is(e.target) || el.has(e.target).length !== 0 )
        return;

    if ( el.css('display') == 'block' )
        stop = true;

    $('.filter-item-docs').removeClass('open');
    $('.filter-item-docs').children('div').slideUp(100);

    if ( stop === true )
        return;

    $(this).addClass('open');
    el.slideDown(100);

});

$(document).mouseup(function (e) {
    var el = $(".filter-item-docs");
    if ( !el.is(e.target) && el.has(e.target).length === 0 ) {
        el.children('div').slideUp(100);
        $('.filter-item-docs').removeClass('open');
    }
});
if ( $("#product_thumbnails_mobile").length ) {
    var product_thumbnails_mobile = $("#product_thumbnails_mobile");
    product_thumbnails_mobile.owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        nav: false,
    });
}

if ( $("#product_slider").length ) {
    var product_slider = $("#product_slider");
    product_slider.owlCarousel({
        items: 1,
        loop: true,
        margin: 5,
        responsive: {
            0: {
                dots: true,
                nav: false,
            },
            1200: {
                dots: false,
                nav: true,
            }
        }
    });
}

//Изменено
if ( $("#product_similar").length ) {
    var product_similar = $("#product_similar");
    product_similar.owlCarousel({
        items: 4,
        loop: false,
        dots: false,
        nav: true,
        onInitialized: function(e) {
            $("#product_similar .owl-stage > .owl-item:nth-child(1) .product-similar-item").addClass('first');
            $("#product_similar .owl-stage > .owl-item:nth-child(" + get_l_products() + ") .product-similar-item").addClass('last');
            return;
        },
        responsive: {
            0: {
                items: 1,
                dots: true,
                nav: false,
            },
            576:{
                items: 2,
                dots: false,
                nav: true,
            },
            800:{
                items: 3,
                dots: false,
                nav: true,
            },
            1100: {
                items: 4,
                dots: false,
                nav: true,
            }
        }
    });

    product_similar.on('changed.owl.carousel', function(e) {
        $("#product_similar .owl-stage > .owl-item .product-similar-item")
            .removeClass('last')
            .removeClass('first');

        var t = e.property.value+1;

        if ( Number.isInteger(t) )
            $("#product_similar .owl-stage > .owl-item:nth-child(" + t + ") .product-similar-item").addClass('first');

        if ( Number.isInteger( e.property.value ) && Number.isInteger(get_l_products() ) )
            $("#product_similar .owl-stage > .owl-item:nth-child("+( e.property.value + get_l_products() )+") .product-similar-item").addClass('last');

        return;
    });
}
//Изменено (конец)


if ( $("#viewed_mobile").length ) {
    var viewed_mobile = $("#viewed_mobile");
    viewed_mobile.owlCarousel({
        items: 1,
        loop: false,
        dots: true,
        nav: false,
    });
}

function get_l_products () {
    if ( window.innerWidth > 1100 )
        return 4;

    if ( window.innerWidth > 800 )
        return 3;

    if ( window.innerWidth > 576 )
        return 2;

    return 1;
}

$(".product-tabs li").click(function() {

    var id = $(this).attr('for');

    $(".product-tabs li").removeClass('active');
    $(".product__tab").removeClass('active');

    $(this).addClass('active');
    $(id).addClass('active');

    $('html').animate({
        scrollTop: $('.product-bottom_description-left').offset().top
    }, 500)

});

$("#help_choice_button").click(function(e) {
    e.preventDefault();

    var css = {'overflow': 'hidden'};

    $("html").css(css);

    if ( !is_mobile() && !is_OSX() )
        css['padding-right'] = '17px';

    $("body").css(css);

    $("#help_choice_modal").fadeIn(300);
    return;
});

//Новое
$("#select_configuration").click(function(e) {
    e.preventDefault();

    var css = {'overflow': 'hidden'};

    $("html").css(css);

    if ( !is_mobile() && !is_OSX() )
        css['padding-right'] = '17px';

    $("body").css(css);

    $("#single_configuration").fadeIn(300);
    return;
});
$("#select_configuration_2").click(function(e) {
    e.preventDefault();

    var css = {'overflow': 'hidden'};

    $("html").css(css);

    if ( !is_mobile() && !is_OSX() )
        css['padding-right'] = '17px';

    $("body").css(css);

    $("#single_configuration").fadeIn(300);
    return;
});
//Новое (конец)

$('.product-thumbnail-list-item').click(function() {
    $('.product-thumbnail-list-item').removeClass('active');
    $(this).addClass('active');

    var src = $(this).find('img').attr('original-src');

    $('.product-thumbnail-detail img').attr('src', (src + '.jpg'));
    $('.product-thumbnail-detail source').attr('srcset', (src + '.webp'));
});

if ( $('.fotorama').length ) {
    var $fotoramaDiv = $('.fotorama').fotorama(),
        fotorama = $fotoramaDiv.data('fotorama'),
        imagArr = fotorama.data,
        srcArr = [], current_frame;

    for(var i = 0; i < imagArr.length; i++){
        var src = {};
        src.src = imagArr[i].img;
        srcArr.push(src);
    }

    for ( i = 1; i <= $('.fotorama__nav .fotorama__nav__frame').length; i++ )
        if ( $('.fotorama__nav .fotorama__nav__frame:nth-child('+i+')').hasClass('fotorama__active') )
            current_frame = i+1;

    // console.log(srcArr);


}

$(document).on('click', '.fotorama__stage .fotorama__img', function() {
    var src1 = {"src":$(this).attr('src')};
    console.log(current_frame);
    $.fancybox.open(srcArr, {
        loop: false,
        // current
    }, current_frame);
});

if ( $("#reviews_slider").length ) {
    var reviews_slider = $("#reviews_slider");

    reviews_slider.owlCarousel({
        items: 1,
        dots: true,
        nav: false
    })
}
$(".catalog__menu .catalog__menu-first a[data-child]").mouseover(function() {
    var el = $(this).attr('data-child');

    $('.catalog__menu-second, .catalog__menu-last').css({'display':'none'}).parent().css({'display':'none'});
    $('.catalog__menu .catalog__menu-first a, .catalog__menu .catalog__menu-second a').removeClass('active');

    $(el).css({'display':'block'}).parent().css({'display':'block'});
    $(this).addClass('active');
});

$(".catalog__menu .catalog__menu-second a[data-child]").mouseover(function() {
    var el = $(this).attr('data-child');

    $('.catalog__menu-last').css({'display':'none'}).parent().css({'display':'none'});
    $('.catalog__menu .catalog__menu-second a').removeClass('active');

    $(el).css({'display':'block'}).parent().css({'display':'block'});
    $(this).addClass('active');
});

$('.main__header-nav-catalog').mouseover(function() {
    $("#catalog__menu").css('display', 'block');
});

$('.main-menu-item, .main__header-logo, .main__header-first').mouseover(function(){
    $("#catalog__menu").css('display', 'none');
});

$("#catalog__menu").mouseleave(function() {
    $("#catalog__menu").css('display', 'none');
});

// mobile menu
$("#hamburger").click(function() {
    $("#mobile__menu").fadeIn(100);
});

$("#mobile__menu .close").click(function() {
    $("#mobile__menu").fadeOut(100);
});

$('.mobile-catalog').click(function() {
    $("#mobile_submenu_first").addClass('open');
    $('#mobile_submenu_first .mobile__menu-submenu-item').css('display','block');
});

$("#mobile_submenu_first button").click(function() {
    $("#mobile_submenu_first").removeClass('open');
});

$("#mobile_submenu_first [data-child]").click(function() {
    var id = $(this).attr('data-child');

    $(id).css('display','block');
    $("#mobile_submenu_second").addClass('open');
});

$("#mobile_submenu_second button").click(function() {
    $("#mobile_submenu_second").removeClass('open');
    setTimeout(() => {
        $('#mobile_submenu_second .mobile__menu-submenu-item').removeAttr('style');
    }, 300);
});

$("#mobile_submenu_second [data-child]").click(function() {
    var id = $(this).attr('data-child');

    $(id).css('display','block');
    $("#mobile_submenu_thirth").addClass('open');
});

$("#mobile_submenu_thirth button").click(function() {
    $("#mobile_submenu_thirth").removeClass('open');
    setTimeout(() => {
        $('#mobile_submenu_thirth .mobile__menu-submenu-item').removeAttr('style');
    }, 300);
});

if ( window.innerWidth < 993 ) {
    $(".catalog__categoryes").click(function(){
        if ( $(this).hasClass('open') ) {
            $(this)
                .removeClass('open')
                .find('ul')
                .slideUp(200);
        } else {
            $(this)
                .addClass('open')
                .find('ul')
                .slideDown(200);
        }
    });
}
$(".sort__item-label span:last-child").click(function() {
    var el = $(this).parent().parent();

    if ( el.find('.sort__item-select').css('display') == 'none' ) {
        el
            .addClass('open')
            .find('.sort__item-select').css('display','block');
    } else {
        el
            .removeClass('open')
            .find('.sort__item-select').css('display','none');
    }
});

$('.sort__item-select li').click(function() {
    $('.sort__item')
        .removeClass('open')
        .find('.sort__item-select').css('display','none');
})

$(document).mouseup(function (e){
    var el = $(".sort__item");
    if (!el.is(e.target) && el.has(e.target).length === 0) {
        el
            .removeClass('open')
            .find('.sort__item-select').css('display','none');
    }
});

$('.filter-item').click(function() {
    var id = $(this).attr("for");
    $(id).fadeIn(300);
});

if ( $( "#slider-range" ).length ) {
    $( "#slider-range" ).slider({
        range: true,
        min: 1000,
        max: 5000000,
        values: [ 500000, 2000000 ],
        slide: function( event, ui ) {
            $('.filter__modal-price-from.before input').attr('value', ui.values[ 0 ]);
            $('.filter__modal-price-to.before input').attr('value', ui.values[ 1 ]);
        }
    });
    $('.filter__modal-price-from.before input').attr('value', $( "#slider-range" ).slider( "values", 0 ) );
    $('.filter__modal-price-to.before input').attr('value', $( "#slider-range" ).slider( "values", 1 ) );
}

$(".filter__modal .close").click(function() {
    $(this).closest('.filter__modal').fadeOut(300);
});

$("#open_mobile_filter").click(function() {
    $("#mobile_filter_popup").fadeIn(300);
});
$("#mobile_filter_popup .close").click(function() {
    $("#mobile_filter_popup").fadeOut(300);
});

$(".mobile__filter_item-title").click(function() {
    if ( $(this).parent().hasClass('open') ) {
        $(this)
            .parent()
            .removeClass('open')
            .find('.mobile__filter_item-body')
            .slideUp(200);
    } else {
        $(this)
            .parent()
            .addClass('open')
            .find('.mobile__filter_item-body')
            .slideDown(200);
    }
});


// sort
$("#open_mobile_sort").click(function() {
    $("#mobile_sort_popup").fadeIn(300);
});
$("#mobile_sort_popup .close").click(function() {
    $("#mobile_sort_popup").fadeOut(300);
});
$(".footer__email-select .checker").click(function() {
    if ( $(this).hasClass('active_first') )
        footer_email_checker_toRight();
    else
        footer_email_checker_toLeft();
});

$(".footer__email-select .first").click( footer_email_checker_toLeft );
$(".footer__email-select .second").click( footer_email_checker_toRight );

function footer_email_checker_toRight() {
    $(".footer__email-select .checker")
        .removeClass('active_first')
        .addClass('active_second');

    $('.footer__email-address .first').removeClass('active');
    $('.footer__email-address .second').addClass('active');
}

function footer_email_checker_toLeft() {
    $(".footer__email-select .checker")
        .addClass('active_first')
        .removeClass('active_second');

    $('.footer__email-address .first').addClass('active');
    $('.footer__email-address .second').removeClass('active');
}
if ( window.innerWidth < 576 ) {
    $('.footer__nav a.before').click(function(e) {
        e.preventDefault();

        if ( $(this).parent().hasClass('active') ) {
            $(this).parent().removeClass('active');
            $(this).parent().find('ul').slideUp(300);
        } else {
            $(this).parent().addClass('active');
            $(this).parent().find('ul').slideDown(300);
        }

    })
}
$("#show__nds .show__nds-selecter").click(function() {
    if ( $(this).hasClass('show__nds-selecter-left') )
        footer_nds_checker_toRight();
    else
        footer_nds_checker_toLeft();
});

$("#show__nds ul > li:first-child").click( footer_nds_checker_toLeft );
$("#show__nds ul > li:last-child").click( footer_nds_checker_toRight );

function footer_nds_checker_toRight() {
    $("#show__nds .show__nds-selecter")
        .removeClass('show__nds-selecter-left')
        .addClass('show__nds-selecter-right');
}

function footer_nds_checker_toLeft() {
    $("#show__nds .show__nds-selecter")
        .addClass('show__nds-selecter-left')
        .removeClass('show__nds-selecter-right');
}
$('.general-to_bottom button').click(function() {
    $('html').animate( {scrollTop: $(window).height()}, 1000 );
});
if ( $("#portfolio_body").length ) {
    var portfolioBobyOptions = [
        {
            'element': "#portfolio_body",
            'offset': 'padding'
        },
        {
            'element': "#portfolio_slider",
            'offset': 'margin',
            'moreLeft': 26
        },
    ];

    if ( window.innerWidth > 1530 )
        offsetLeft(portfolioBobyOptions);
    else
        $('.portfolio .owl-carousel, #portfolio_body').removeAttr('style');

    $(window).resize(function() {
        if ( window.innerWidth > 1530 )
            offsetLeft(portfolioBobyOptions);
        else
            $('.portfolio .owl-carousel, #portfolio_body').removeAttr('style');
    });

    // slider
    var portfolio_slider = $("#portfolio_slider");
    portfolio_slider.owlCarousel({

        margin: 30,
        loop: true,
        responsive: {
            0: {
                items: 1,
                dots: true,
                nav: false,
            },
            775: {
                items: 2
            },
            1200: {
                items: 3
            },
            1530: {
                items: 3.7,
                dots: false,
                nav: true,
            }
        },
    });
}
if ( window.innerWidth < 576 ) {
    var prefers_icons = $("#prefers_icons");

    prefers_icons.owlCarousel({
        items: 1,
        dots: true,
        nav: false
    })
}
});
