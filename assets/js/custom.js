jQuery(function($) {
    "use strict";
    //--add to cart product--//
    $(document).on('click', '.add-to-cart', function(e){
        e.preventDefault();
        var button     = $(this),
            thisProdId = $(this).attr('data-postid'),
            thisProdQ  = $(this).attr('data-quantity');
        button.removeClass('added').addClass('loading disabled');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action' : 'prod_add_to_cart',
                'ProdId' : thisProdId,
                'ProdQ'  : thisProdQ
            },
            complete: function(response){
                var data = response.responseJSON;
                if( data.result == 'true' ){
                    button.addClass('added');
                    //if( data.cart_count != '0' ){
                       // $('.cart_count_ajax b').html( data.cart_count );
                       // $('.cart_count_ajax').fadeIn();
                       // $('.header-menu-busket').css("z-index", "99");
                    //} else {
                        //$('.cart_count_ajax').fadeOut();
                        //$('.header-menu-busket').css("z-index", "0");
                    //}
                    $('.basket').fadeIn('1000');
                }
                button.removeClass('loading disabled');
            }
        });
    });

    $(document).on('change', '.variations select', function(){
        if( $('input.variation_id').val() != '' ){
            $('.product-preview .swiper-slide:first-child img').attr('src', $('.product-slider .swiper-slide:first-child img').attr('src') );
            $('.product-preview .swiper-slide:first-child .slide-swich').click();
        }
    });

    $(document).on('click', '.reset_variations', function(){
        $('.product-preview .swiper-slide:first-child img').attr('src', $('.product-slider .swiper-slide:first-child img').attr('src') );
    });
    
    $(document).on('click', '.add-to-wish', function(){
        $(this).find('.add_to_wishlist').click();
        $(this).addClass('added');
    });
    $('.search-form-wr .close').on('click', function(){
       $('.search-popup').removeClass('open');
        return false;
    });

    $('.fa-angle-down').on('click', function(){
        event.preventDefault();
        $(this).parent().siblings('.sub-menu').toggleClass('act');  
    });


});