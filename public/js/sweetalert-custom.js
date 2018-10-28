/*[ SweetAlert add to cart]
 ===========================================================*/
$('.block2-btn-addcart').each(function () {
    var thisProduct = $(this);

    thisProduct.on('click', function () {
        var data = {},
            options = {},
            obj = {},
            price = 0,
            name = thisProduct.attr('data-name'),
            article = thisProduct.attr('data-article'),
            productSizes = json[article].skus;

        data['article'] = article;
        data['name'] = name;
        options['image'] = thisProduct.parent().parent().find('img').attr('src');
        if ($('button', thisProduct).hasClass('hasMany')) {
            $.each(productSizes, function (i, item) {
                obj[item['price']] = item['size'] + ' (Цена: ' + item['price'] + '₽)';
            });

            (async function getSize() {
                // inputOptions can be an object or Promise
                const inputOptions = new Promise((resolve) => {
                    setTimeout(() => {
                        resolve(obj)
                    }, 500);
                });

                const {value: size} = await swal({
                    title: 'Выберите размер',
                    confirmButtonText: 'Добавить в корзину',
                    buttonsStyling: false,
                    confirmButtonClass: 'size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 p-t-5 p-b-5 p-l-25 p-r-25',
                    imageUrl: options['image'],
                    imageWidth: 400,
                    imageHeight: 200,
                    imageClass: 'bo-rad-2',
                    imageAlt: data['name'],
                    input: 'radio',
                    inputOptions: inputOptions,
                    inputValidator: (value) => {
                        return !value && 'Необходимо выбрать размер!'
                    }
                });

                if (size) {
                    $.each(productSizes, function (i, item) {
                        if(item['price'] == size)
                        {
                            options['size'] = item['size'];
                            price = item['price'];

                        }
                    });
                    ajaxBasket(data, options, price);
                }
            })()
        } else {
            price = thisProduct.parent().parent().parent().find('.block2-price span').html();
            ajaxBasket(data, options, price);
        }
    });
});

/*[ SweetAlert add to wishlist]
 ===========================================================*/
$('.block2-btn-addwishlist').each(function () {
    var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
    $(this).on('click', function () {
        swal(nameProduct, "Товар добавлен в лист ожидания", "success");
    });
});