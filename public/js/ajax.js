window.ajaxCall = function (filter, slug, page) {

    var url = '/catalog/' + slug;

    localStorage.setItem('filter', JSON.stringify(filter));

    var itemFilter = JSON.parse(localStorage.getItem('filter'));
    console.log(page);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'json',
        url: url,
        data: {
            'filter': itemFilter,
            'page': page
        },
        success: function (request) {
            var catalogContainer = $('#catalog');
            catalogContainer.html('').html(request.html);
            $('html,body').animate({scrollTop: catalogContainer.offset().top}, 'slow');

        },
        error: function (request) {
            console.log(request);
        }
    });
}

window.ajaxBasket = function (data, options, price, count = 1) {
    console.log(data);
    console.log(options);
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
            count: {count},
            price: price
        },
        success: function (request) {
            if (request.result === 'success') {
                var sizeHtml = (options['size'] !== undefined) ? ' (' + options['size'] + ')' : '';
                $('.header-icons-noti').html('').html(request.count);
                $('.header-cart-total span').html('').html(request.total);
                swal({
                    type: 'success',
                    title: 'Товар ' + data['name'] + sizeHtml + ' добавлен в корзину',
                    // html: 'Вы выбрали: ' + size,
                    buttonsStyling: false,
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: 'Оформить заказ',
                    confirmButtonAriaLabel: 'Перейти к оформлению заказа!',
                    confirmButtonClass: 'bg4 bo-rad-23 hov1 m-r-5 p-b-5 p-l-25 p-r-25 p-t-5 s-text1 size1 trans-0-4',
                    cancelButtonText: 'Продолжить',
                    cancelButtonAriaLabel: 'Продолжить покупки на сайте',
                    cancelButtonClass: 'size13 bo16 bo-rad-23 hov3 s-text2 colorwhite-hov trans-0-4 p-t-5 p-b-5 p-l-25 p-r-25'
                }).then((result) => {
                    if (result.value) {
                        //go to cart
                    }
                });
            }
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