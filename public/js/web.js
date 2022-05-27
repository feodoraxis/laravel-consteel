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
});
