if (window.innerWidth < 600) {
    let swiperMob = new Swiper('.soeasy-slide', {
        direction: 'horizontal',
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        mousewheel: true,
        pagination: {
            clickable: true,
        }
    });
} else {
    let galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 4,
        loop: false,
        direction: 'vertical',
        freeMode: true,
        loopedSlides: 5, //looped slides should be the same
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    let swiper = new Swiper('.soeasy-slide', {
        direction: 'vertical',
        slidesPerView: 1,
        spaceBetween: 30,
        mousewheel: true,
        pagination: {
            clickable: true,
        },
        thumbs: {
            swiper: galleryThumbs,
        },
    });
}

$('.toggle-header').on('click', function () {
    let $thisBody = $(this).parents('.toggle-bar');
    if ($thisBody.hasClass('show')) {
        $thisBody.removeClass('show')
    } else {
        $thisBody.addClass('show')
    }
})


$('.inf-icon').on('mouseover', function () {
    let d_hover = $(this).data('hover');
    $('.' + d_hover).fadeIn();
})

$('.inf-icon').on('mouseout', function () {
    let d_hover = $(this).data('hover');
    $('.' + d_hover).fadeOut();
})

$('.photo-slide').on('click', function () {
    let _src = $(this).attr('src');
    console.log(_src);
    $('#imageForZoom').attr('src', _src);
    $('#zoomImgParent').addClass('show');
})
$('#imageForZoom').on('click', function () {
    $('#zoomImgParent').removeClass('show');
})

$(document).ready(function () {
    (function ($) {
        $(function () {

            $('input, select').styler();

        });
    })(jQuery);
})
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.add-cart').on('click', function () {
    let dataId = $(this).data('id');
    if ($('#sizesSelect').val() === '0') {
        notify($('#alertDanger'),'Пожалуйста, выберите размер')
    } else {
        $.ajax({
            url: '/addToCart',
            data: {
                catId: dataId,
                sizes: $('#sizesSelect').val(),
                fingerprint: setLocalStorageIfNotExist('fingerprint'),
            },
            method: 'POST',
            success: function (data) {
                if(data.success !== undefined) {

                    $('#checkoutModal').modal('show')
                }
            }
        })
    }

})