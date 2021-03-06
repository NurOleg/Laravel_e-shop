@extends('layouts.app')
@section('specificCSS')
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">
@endsection
@section('content')

    <section class="bgwhite p-t-55 p-b-65">
        <section class="container">
            <section class="row">
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
                    <div class="leftbar p-r-20 p-r-0-sm">
                        @if($categoriesTree->count() > 0)
                            <h4 class="m-text14 p-b-7">
                                Категории
                            </h4>

                            <ul class="p-b-54">
                                @foreach($categoriesTree as $categoryTree)
                                    <li class="p-t-4">
                                        <a href="/catalog/{{ $categoryTree->category_slug }}" class="s-text13">
                                            {{ $categoryTree->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <h4 class="m-text14 p-b-32">
                            Фильтр
                        </h4>
                        @foreach($filter as $filterParam => $filterValues)
                            @if($filterParam === 'price')
                                <div class="filter-price p-t-22 p-b-50 bo3">
                                    <div class="m-text15 p-b-17">
                                        {{ $props[$filterParam] }}
                                    </div>

                                    <div class="wra-filter-bar">
                                        <div id="filter-bar"></div>
                                    </div>

                                    <div class="flex-sb-m flex-w p-t-16">
                                        <div class="s-text3 p-t-10 p-b-10">
                                            @foreach($filterValues as $filterValue)
                                                @if($loop->first)
                                                    От <span id="value-lower">{{ $filterValue }}</span>₽ -
                                                @endif

                                                @if($loop->last)
                                                    до <span id="value-upper">{{ $filterValue }}</span>₽
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="m-text15 p-b-17 p-t-10 m-t-15">
                                    {{ $props[$filterParam] }}
                                </div>
                                <div class="rs2-select2 bo4 of-hidden size6 m-t-5 m-b-5 m-r-10">
                                    <select class="selection-2" name="{{ $filterParam }}">
                                        <option>Не выбрано</option>
                                        @foreach($filterValues as $filterValue)
                                            @if($filterValue != '0')
                                                <option>{{ $filterValue }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        @endforeach
                        <div class="size15 m-t-25">
                            <!-- Button -->
                            <button class="show-me flex-c-m size15 bg7 bo-rad-15 hov1 s-text14 trans-0-4"
                                    style="display: none">
                                Фильтровать
                            </button>
                        </div>
                    </div>
                </div>
                    <div class="col-sm-6 col-md-8 col-lg-9 p-b-50" id="catalog">
                        <!--  -->
                        <div class="flex-sb-m flex-w p-b-35">
                            {{--<div class="flex-w">--}}
                            {{--<div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">--}}
                            {{--<select class="selection-2" name="sorting">--}}
                            {{--<option>Не сортировать</option>--}}
                            {{--<option>Цена: по возрастанию</option>--}}
                            {{--<option>Цена: по убыванию</option>--}}
                            {{--</select>--}}
                            {{--</div>--}}

                            {{--<div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">--}}
                            {{--<select class="selection-2" name="sorting">--}}
                            {{--<option>Price</option>--}}
                            {{--<option>$0.00 - $50.00</option>--}}
                            {{--<option>$50.00 - $100.00</option>--}}
                            {{--<option>$100.00 - $150.00</option>--}}
                            {{--<option>$150.00 - $200.00</option>--}}
                            {{--<option>$200.00+</option>--}}

                            {{--</select>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            <span class="s-text8 p-t-5 p-b-5">
							Показаны 1–12 из {{$goods->total()}} элементов
						</span>
                        </div>

                        <!-- Product -->
                        <div class="row">
                            @foreach($goods as $good)
                                <div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block2-img wrap-pic-w of-hidden pos-relative">
                                            {{--<div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">--}}
                                            @foreach($good->image as $image)
                                                <img src="{!!  $image->src !!}" alt="{{ $good->name }}">
                                            @endforeach
                                            <div class="block2-overlay trans-0-4">
                                                <a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
                                                    <i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
                                                    <i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
                                                </a>

                                                <div class="block2-btn-addcart w-size1 trans-0-4"
                                                     data-name="{{ $good->name }}" data-article="{{ $good->article }}">
                                                    <!-- Button -->
                                                    <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 @if ($good->skus->count() > 1) hasMany @endif ">
                                                        В корзину
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="block2-txt p-t-20">
                                            <a href="{{ $good->article }}" class="block2-name dis-block s-text3 p-b-5">
                                                {{ $good->name }}
                                            </a>

                                            <span class="block2-price m-text6 p-r-5">
                                            @if ($good->skus->count() === 1)
                                                    @foreach($good->skus as $sku)
                                                        <span>{{ $sku->price }}</span> ₽
                                                    @endforeach
                                                @else
                                                    @foreach($good->skus as $sku)
                                                        @if($loop->first)
                                                            от {{ $sku->price }} ₽
                                                        @elseif($loop->last)
                                                            до {{ $sku->price }} ₽
                                                        @endif
                                                    @endforeach
                                                @endif
									</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="pagination flex-m flex-w p-t-26">
                            {{ $goods->links() }}
                            <a href="#" class="item-pagination flex-c-m trans-0-4 active-pagination">1</a>
                            <a href="#" class="item-pagination flex-c-m trans-0-4">2</a>
                        </div>
                    </div>
            </section>
        </section>
    </section>
@endsection

@section('specificJS')
    <script type="text/javascript" src="{{ asset('vendor/noui/nouislider.min.js') }}"></script>
    <script type="text/javascript">
        /*[ No ui ]
        ===========================================================*/
        var filterBar = document.getElementById('filter-bar'),
            minVal = document.getElementById('value-lower'),
            maxVal = document.getElementById('value-upper'),
            skipValues = [
                minVal,
                maxVal
            ];
        noUiSlider.create(filterBar, {
            start: [parseInt(minVal.innerHTML), parseInt(maxVal.innerHTML)],
            connect: true,
            range: {
                'min': parseInt(minVal.innerHTML),
                'max': parseInt(maxVal.innerHTML)
            }
        });

        var values = [],
            slug = '{{ $slug }}';
        console.log(slug);
        filterBar.noUiSlider.on('change', function (values, handle) {
            skipValues[handle].innerHTML = Math.round(values[handle]);
            var filter = getFilter();
            filter['price_from'] = Math.round(values[0]);
            filter['price_to'] = Math.round(values[1]);
            setTimeout(function () {
                ajaxCall(filter, slug)
            }, 1000);
        });

        $('body').on('change', '.leftbar select', function () {
            var filter = getFilter();
            ajaxCall(filter, slug);
        });
        $('body').on('click', '.page-item', function (e) {
            e.preventDefault();
            var filter = getFilter();
            var pageNum = $(this).find('.page-link').html();
            ajaxCall(filter, slug, pageNum);
        })
    </script>
    <script>
        var json = {!! $json !!};
    </script>
    <script type="text/javascript" src="{{ asset('vendor/sweetalert/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert-custom.js') }}"></script>
@endsection
