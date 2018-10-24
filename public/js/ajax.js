window.ajaxCall = function (filter, slug) {

    var url = '/catalog/filter/' + slug;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'json',
        url: url,
        data: {filter},
        success: function (request) {
            var showButton = $('.show-me'),
                catalogContainer = $('#catalog');
            showButton.html('').html('Показать товары (' + request.total + ' шт.)');
            showButton.show();
            $('body').on('click', showButton, function(){
                catalogContainer.html('').html(request.html);
            });

            console.log(request.total);
        },
        error: function (request) {
            console.log(request);
        }
    });
}

window.ajaxBasket = function (data, options, count = 1) {
    console.log(data);
    console.log(options);
    console.log(count);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/catalog/ajaxBasket',
        dataType: 'json',
        data: {
            data: {data},
            options: {options},
            count: {count}
        },
        success: function (request) {
            $('.header-icons-noti').html('').html(request.count);
            $('.header-cart-total span').html('').html(request.total);
            console.log(request);
        }
    });
}

window.ajaxOrder = function (data, options, count = 1) {
    console.log(data);
    console.log(options);
    console.log(count);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/catalog/ajaxBasket',
        dataType: "json",
        data: {
            data: {data},
            options: {options},
            count: {count}
        },
        success: function (request) {
            $('.header-icons-noti').html('').html(request.count);
            console.log(request);
        }
    });
}

window.getFilter = function () {
    var filterBar = $('.leftbar select'),
        filter = {};
    if (filterBar.length > 0) {
        filterBar.each(function (i, item) {
            if ($(item).val() !== 'Не выбрано' && $(item).val() !== undefined) {
                filter[$(item).attr('name')] = $(item).val();
            }
        });
    }
    return filter;
}