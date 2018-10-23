@extends('layouts.app')
@section('content')

    <section class="bg-title-page p-t-40 p-b-50 flex-col-c-m"
             style="background-color: #222222;">
        <h2 class="l-text2 t-center">
            {{ $title }}
        </h2>
    </section>

    <section class="cart bgwhite p-t-70 p-b-100">
        <div class="container">

            <div class="bo9 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 p-lr-15-sm">
                <h5 class="m-text20 p-b-24">
                    Информация о покупателе
                </h5>

                <!---------------- CHANGES ---------------->
                <form id="orderForm" action=""> <!-- added form -->
                    <div class="flex-w flex-sb bo10 p-t-15 p-b-20 m-b-30"> <!-- added class m-b-30 -->
                        <div class="w-size20 w-full-sm m-l-r-auto">
                            <p class="s-text8 p-b-23">Заполните, пожалуйста, информацию о себе, чтобы мы могли понять,
                                кто Вы.</p>

                            <label for="name" class="s-text19">Ваше имя*</label> <!-- changed for label -->
                            <div class="size13 bo4 m-b-12">
                                <input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="name"
                                       placeholder="Ваше имя" id="name" value="{{ Auth::user()->name }}" required>
                            </div>

                            <label for="email" class="s-text19">E-mail</label> <!-- changed for label -->
                            <div class="size13 bo4 m-b-22">
                                <input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="email"
                                       placeholder="Ваш e-mail" value="{{ Auth::user()->email }}" id="email">
                            </div>

                            <label for="phone" class="s-text19">Телефон*</label> <!-- changed for label -->
                            <div class="size13 bo4 m-b-22">
                                <input class="sizefull s-text7 p-l-15 p-r-15" type="tel" name="phone" maxlength="11"
                                       placeholder="Ваш телефон" id="phone" value="{{ Auth::user()->phone }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="size15 trans-0-4">
                        <input class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4 js-btn-step-two"
                               type="submit" value="Продолжить">
                        <!-- changed for input & added class js-btn-step-two -->
                    </div>
                </form>
            </div>
            <div class="container-box-cart js-cart-step-two">

                <!-- Cart item -->
                @if(count((array)$items) > 0)
                    <div class="container-table-cart pos-relative">
                        <div class="size15 trans-0-4">
                            <h4 class="m-text20 m-b-24 m-t-24 t-center">
                                Корзина
                            </h4>
                        </div>
                        <div class="wrap-table-shopping-cart bgwhite">
                            <table class="table-shopping-cart">
                                <tr class="table-head">
                                    <th class="column-1"></th>
                                    <th class="column-2">Товар</th>
                                    <th class="column-3">Цена (шт.)</th>
                                    <th class="column-4 p-l-70">Количество</th>
                                    <th class="column-5">Итого</th>
                                </tr>
                                @foreach($items as $item)
                                    <tr class="table-row">
                                        <td class="column-1">
                                            <div class="cart-img-product b-rad-4 o-f-hidden">
                                                <img src="images/item-10.jpg" alt="IMG-PRODUCT">
                                            </div>
                                        </td>
                                        <td class="column-2">{{ $item->name }}</td>
                                        <td class="column-3">{{ $item->price }} ₽</td>
                                        <td class="column-4">
                                            <div class="flex-w bo5 of-hidden w-size17">
                                                <button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
                                                    <i class="fs-12 fa fa-minus" aria-hidden="true"></i>
                                                </button>

                                                <input class="size8 m-text18 t-center num-product" type="number"
                                                       name="num-product1"
                                                       value="{{ $item->quantity }}">

                                                <button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
                                                    <i class="fs-12 fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="column-5">{{ $item->quantity*$item->price }} ₽</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @else
                @endif

                <div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
                    <div class="flex-w flex-m w-full-sm">
                        <div class="size11 bo4 m-r-10">
                            <input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="coupon-code"
                                   placeholder="Ваш купон">
                        </div>

                        <div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
                            <!-- Button -->
                            <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
                                Применить купон
                            </button>
                        </div>
                    </div>

                    <div class="size24 trans-0-4 m-t-10 m-b-10">
                        <div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size20 w-full-sm">
						Стоимость товаров:
					</span>

                            <span class="m-text21 w-size19 w-full-sm">
						{{ $total }} ₽
					</span>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="bo9 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 p-lr-15-sm">
                    <h5 class="m-text20 p-b-24">
                        Доставка и оплата
                    </h5>

                    <div class="flex-w flex-sb bo10 p-t-15 p-b-20">
					<span class="s-text18 w-size19 w-full-sm">
						Способ доставки:
					</span>

                        <div class="w-size20 w-full-sm">
                            <p class="s-text8 p-b-23">
                                Выберите, пожалуйста, способ доставки. Обращаем Ваше внимание, что итоговая стоимость
                                доставки будет уточнена нашим менеджером после оформления заказа.
                            </p>

                            {{--<span class="s-text19">--}}
                            {{--Calculate Shipping--}}
                            {{--</span>--}}
                            <div class="rs2-select2 rs3-select2 rs4-select2 bo4 of-hidden w-size21 m-t-8 m-b-12">
                                <select class="selection-2" name="delivery">
                                    <option>Выбрать способ доставки</option>
                                    @foreach($deliveries as $delivery)
                                        <option value="{{ $delivery->id }}"
                                                data-delivery-cost="{{$delivery->cost}}">
                                            {{ $delivery->name }}({{$delivery->cost}}₽)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="size13 bo4 m-b-12">
                                <input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="city"
                                       placeholder="Город">
                            </div>

                            <div class="size13 bo4 m-b-12">
                                <input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="street"
                                       placeholder="Улица">
                            </div>

                            <div class="size13 bo4 m-b-12">
                                <input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="house"
                                       placeholder="Дом">
                            </div>

                            <div class="size13 bo4 m-b-22">
                                <input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="zip-code"
                                       placeholder="Индекс">
                            </div>

                        </div>
                    </div>
                    <div class="flex-w flex-sb bo10 p-t-15 p-b-20">
					<span class="s-text18 w-size19 w-full-sm">
						Способ оплаты:
					</span>

                        <div class="w-size20 w-full-sm">
                            <p class="s-text8 p-b-23">
                                Выберите, пожалуйста, способ оплаты.
                            </p>

                            {{--<span class="s-text19">--}}
                            {{--Calculate Shipping--}}
                            {{--</span>--}}
                            <div class="rs2-select2 rs3-select2 rs4-select2 bo4 of-hidden w-size21 m-t-8 m-b-12">
                                <select class="selection-2" name="payment">
                                    <option>Выбрать способ оплаты</option>
                                    @foreach($payments as $payment)
                                        <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!--  -->
                    <div class="flex-w flex-sb-m p-t-26 p-b-30">
					<span class="m-text22 w-size19 w-full-sm">
						Стоимость итого:
					</span>

                        <span class="m-text21 w-size20 w-full-sm order-sum">
                        <span>{{ $total }}</span> ₽
					</span>
                        <input type="hidden" name="sum" value="">
                    </div>

                    <div class="size15 trans-0-4">
                        <!-- Button -->
                        <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4 save-order">
                            Оформить заказ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('specificJS')
    <script>
        $(document).ready(function () {
            $('select[name="delivery"]').on('change', function () {
                var deliveryID = $(this).val(),
                    delivetyCost = $(this).find('option:selected').attr('data-delivery-cost'),
                    currentOrderSum = {!! $total !!},
                    actualOrderSum = currentOrderSum + parseInt(delivetyCost);
                $('.order-sum span').html('').html(actualOrderSum);
                $('input[name="sum"]').val(actualOrderSum);

            });
            $('.save-order').on('click', function (e) {
                e.preventDefault();
                var data = {},
                    inputs = $('.container input, select');
                inputs.each(function (val, item) {

                    data[$(item).attr('name')] = $(item).val();
                });
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/personal/saveOrder',
                    dataType: "json",
                    data: {data},
                    success: function (request) {
                        $('.header-icons-noti').html('').html(request.count);
                        console.log(request);
                    }
                });
            });
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
@stop