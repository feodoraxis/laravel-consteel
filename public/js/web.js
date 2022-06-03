jQuery(function($) {
    $("#show_more").on('click', function(){
        let thi = $(this),
            text = thi.text(),
            form = {
                type: $(this).attr('data-type'),
                category: $(this).attr('data-category'),
                current_page: parseInt($(this).attr('data-current_page')) + 1,
                max: parseInt($(this).attr('data-max'))
            };

        $.ajax( {
            url: '/ajax/' + form.type + '/',
            type: 'POST',
            data: {
                action: 'show_more',
                _token: $(this).attr('data-csrf'),
                form: form
            },
            beforeSend: function() {
                thi.addClass('active').text("Загрузка...");
            },
            success: function( d ) {
                $("#catalog__list_row").append( d );

                $('#pagination li').removeClass('active');
                $('#pagination li[data-num=' + form.current_page + ']').addClass('active');
                $('#pagination li[data-num=' + form.current_page + ']').html("<span>" + $('#pagination li[data-num=' + form.current_page + '] span').text() + "</span>");


                if ( form.current_page >= form.max ) {
                    thi.remove();
                    return;
                }

                thi
                    .attr('data-current_page', form.current_page)
                    .removeClass('active')
                    .text( text );
            }
        } );
    });

    $(".button-filter").on('click', function(e) {
        e.preventDefault();

        let thi = $(this),
            thi_text = thi.text(),
            form = $("form#global_filter"),
            global_filter = form.serialize(),
            url = window.location.href,
            get_string = '?';

        if ( url.lastIndexOf('?') > 0 ) {
            get_string += url.split('?')['1'] + '&';
        }

        $.ajax( {
            url: form.attr('action'),
            type: 'POST',
            data: {
                _token: form.attr('data-csrf'),
                category: form.attr('data-category'),
                global_filter: global_filter
            },
            beforeSend: function() {
                thi.addClass('active').text("Загрузка...");
            },
            success: function( d ) {
                thi
                    .removeClass('active')
                    .text( thi_text )
                    .closest('.filter__modal')
                    .fadeOut(300);

                $('body,html').removeAttr('style');
                $("#catalog__list_row").html(d);

                window.history.pushState('page2', $('title').text(), window.location.pathname + get_string + form.serialize() );
            }
        } );
    });

    $("#global_filter .button-reset").on('click', function(e){
        e.preventDefault();

        window.location.href = window.location.pathname;
    });

    $("#catalog-sort li").on('click', function( e ) {
        let value = $(this).attr('data-value'),
            url = window.location.pathname + '?sort=' + value;

        window.location.href = url;
    });

    $("#catalog-quantity li").on('click', function( e ) {
        let value = $(this).attr('data-value'),
            url = window.location.pathname + '?sort=' + value;

        window.location.href = url;
    });


    $("#show_more_search").on('click', function(){
        let thi = $(this),
            text = thi.text(),
            form = {
                type: $(this).attr('data-type'),
                request: $(this).attr('data-request'),
                current_page: parseInt($(this).attr('data-current_page')) + 1,
                max: parseInt($(this).attr('data-max'))
            };

        $.ajax( {
            url: '/ajax/search-load/',
            type: 'POST',
            data: {
                // action: 'show_more',
                _token: $(this).attr('data-csrf'),
                form: form
            },
            beforeSend: function() {
                thi.addClass('active').text("Загрузка...");
            },
            success: function( d ) {
                $("#catalog__list_row").append( d );

                $('#pagination li').removeClass('active');
                $('#pagination li[data-num=' + form.current_page + ']').addClass('active');
                $('#pagination li[data-num=' + form.current_page + ']').html("<span>" + $('#pagination li[data-num=' + form.current_page + '] span').text() + "</span>");


                if ( form.current_page >= form.max ) {
                    thi.remove();
                    return;
                }

                thi
                    .attr('data-current_page', form.current_page)
                    .removeClass('active')
                    .text( text );
            }
        } );
    });

    $("#main_search_input").on('keyup', function(e) {
        let thi = $(this),
            request = $(this).val();

        if ( request.length < 4 ) {
            $("#main_search").removeClass("active");
            return '';
        }

        $.ajax( {
            url: '/ajax/search/',
            type: 'POST',
            data: {
                // action: 'load-preview-search-result',
                _token: $('[name="csrf-token"]').attr('content'),
                form: {
                    request: request
                }
            },
            beforeSend: function() {
                thi.addClass('is-loading');
            },
            success: function( d ) {
                if ( d == '' ) {
                    $("#main_search").removeClass("active");
                    return;
                }

                $("#main__search_result").html( d );
                $("#main_search").addClass("active");
                thi.removeClass('is-loading');
            }
        } );
    });

    $("#compare").on('click', function(e) {
        e.preventDefault();

        compare( $(this), $(this).attr('data-id') );
    });

    $(".add-to-compare").on('click', function(e) {
        e.preventDefault();

        compare( $(this), $(this).closest('.product__preview').attr('data-product-id') );
    });

    function compare( context, product_id )
    {
        $.ajax( {
            url: '/ajax/compare/toggle/',
            type: 'POST',
            data: {
                _token: $('[name="csrf-token"]').attr('content'),
                form: {
                    id: product_id
                }
            },
            beforeSend: function() {
                context.addClass('is-loading');
            },
            success: function( json ) {
                let d = JSON.parse(json);

                context.removeClass('is-loading');

                if ( d.result == 'added' ) {
                    context.addClass('active');
                } else {
                    context.removeClass('active');
                }

                if ( $('.compare-list').length ) {
                    location.reload();
                }
            }
        } );
    }

    $("#clear_compare").on('click', function(e) {
        e.preventDefault();

        compareClear();
    });

    function compareClear()
    {
        $.ajax( {
            url: '/ajax/compare/clear/',
            type: 'POST',
            data: {
                _token: $('[name="csrf-token"]').attr('content')
            },
            success: function( json ) {
                let d = JSON.parse(json);

                if ( d.result == 'success' ) {
                    window.location.href = '/';
                }
            }
        } );
    }
});
