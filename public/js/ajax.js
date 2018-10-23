window.ajaxCall = function (values, changed = false) {
    var price_from = 0,
        price_to = 0;
    if (changed) {
        price_from = Math.round(values[0]);
        price_to = Math.round(values[1]);
    }
    var data = [];
    data.push(price_from);
    data.push(price_to);
    console.log(values[0]);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/catalog/catalogFilter',
        data: {
            filter: {
                data
            }
        },
        success: function (request) {
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
        dataType:"json",
        data: {
            data: { data },
            options : { options },
            count: { count }
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
        dataType:"json",
        data: {
            data: { data },
            options : { options },
            count: { count }
        },
        success: function (request) {
            $('.header-icons-noti').html('').html(request.count);
            console.log(request);
        }
    });
}