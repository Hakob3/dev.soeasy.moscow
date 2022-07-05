$(document).ready(function () {
    $(".lazyload").lazyload({
        effect: "fadeIn",
        bind: "event",
        delay: 0
    });

})
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function setLocalStorageIfNotExist($cookName) {
    let $cookValue = Math.random().toString(36).slice(2);
    if (localStorage.getItem($cookName) === null) {
        localStorage.setItem($cookName, $cookValue)
    }
    return localStorage.getItem($cookName)
}


$('.mob-menu-burger').on('click', function () {
    if ($('.nav-h').hasClass('mob-show')) {
        $('#mob-menu-burger').removeClass('open-b');
        $('.nav-h').removeClass('mob-show');
    } else {
        $('.nav-h').addClass('mob-show');
        $('#mob-menu-burger').addClass('open-b');
    }
})

function notify(element, message, _type = 'danger') {
    element.html(message).fadeIn();
    setTimeout(function () {
        element.fadeOut();
    }, 3500)
}




