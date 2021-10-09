$(document).ready(function () {
    $(".nav-treeview .nav-link, .nav-link").each(function () {
        var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
        var link = this.href;
        if(link == location2){
            $(this).addClass('active');
            $(this).parent().parent().parent().addClass('menu-is-opening menu-open');

        }
    });


})

$(document).on('input', '._search_active_record', function (){
    let searchFields = $(this).val();

    $.ajax({
        url: "/admin/fullcalendar/search",
        type: "GET",
        data: {
            searchFields: searchFields,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (data) => {

            $('._users_active_list_wrapper').html(data)

            let elem = $('#list_active_records');

            $('html, body').animate({
                scrollTop: elem.offset().top
            }, {
                duration: 370,   // по умолчанию «400»
                easing: "linear" // по умолчанию «swing»
            });

            return false;
        }
    })
})

$(document).on('click', '._btn_collapse', function (){

    let elem = null

    if($(this).find('i').hasClass('fa-plus')){
        elem = $('#fullcalendar_main');
    } else {

        elem = $('#list_active_records');
    }


    $('html, body').animate({
        scrollTop: elem.offset().top
    }, {
        duration: 370,   // по умолчанию «400»
        easing: "linear" // по умолчанию «swing»
    });
})
