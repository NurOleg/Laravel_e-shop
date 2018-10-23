@extends('layouts.app')
@section('content')


    <section class="bgwhite p-t-55 p-b-65">
        <div class="container">
            <div class="row">
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
                                        Price
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
                                    <div class="rs2-select2 bo4 of-hidden size6 m-t-5 m-b-5 m-r-10">
                                        <select class="selection-2" name="{{ $filterParam }}">
                                            <option>{{ $filterParam }}</option>
                                            @foreach($filterValues as $filterValue)
                                                <option>{{ $filterValue }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
                            <div class="size15 m-t-25">
                                <!-- Button -->
                                <button class="flex-c-m size15 bg7 bo-rad-15 hov1 s-text14 trans-0-4">
                                    Фильтровать
                                </button>
                            </div>
                    </div>
                </div>
                {{--<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">--}}
                    {{--<div class="leftbar p-r-20 p-r-0-sm">--}}
                        {{--<!--  -->--}}
                        {{--<h4 class="m-text14 p-b-7">--}}
                            {{--Categories--}}
                        {{--</h4>--}}

                        {{--<ul class="p-b-54">--}}
                            {{--<li class="p-t-4">--}}
                                {{--<a href="#" class="s-text13 active1">--}}
                                    {{--All--}}
                                {{--</a>--}}
                            {{--</li>--}}

                            {{--<li class="p-t-4">--}}
                                {{--<a href="#" class="s-text13">--}}
                                    {{--Women--}}
                                {{--</a>--}}
                            {{--</li>--}}

                            {{--<li class="p-t-4">--}}
                                {{--<a href="#" class="s-text13">--}}
                                    {{--Men--}}
                                {{--</a>--}}
                            {{--</li>--}}

                            {{--<li class="p-t-4">--}}
                                {{--<a href="#" class="s-text13">--}}
                                    {{--Kids--}}
                                {{--</a>--}}
                            {{--</li>--}}

                            {{--<li class="p-t-4">--}}
                                {{--<a href="#" class="s-text13">--}}
                                    {{--Accesories--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}

                        {{--<!--  -->--}}
                        {{--<h4 class="m-text14 p-b-32">--}}
                            {{--Filters--}}
                        {{--</h4>--}}

                        {{--<div class="filter-price p-t-22 p-b-50 bo3">--}}
                            {{--<div class="m-text15 p-b-17">--}}
                                {{--Price--}}
                            {{--</div>--}}

                            {{--<div class="wra-filter-bar">--}}
                                {{--<div id="filter-bar"></div>--}}
                            {{--</div>--}}

                            {{--<div class="flex-sb-m flex-w p-t-16">--}}
                                {{--<div class="w-size11">--}}
                                    {{--<!-- Button -->--}}
                                    {{--<button class="flex-c-m size4 bg7 bo-rad-15 hov1 s-text14 trans-0-4">--}}
                                        {{--Filter--}}
                                    {{--</button>--}}
                                {{--</div>--}}

                                {{--<div class="s-text3 p-t-10 p-b-10">--}}
                                    {{--Range: $<span id="value-lower">610</span> - $<span id="value-upper">980</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="filter-color p-t-22 p-b-50 bo3">--}}
                            {{--<div class="m-text15 p-b-12">--}}
                                {{--Color--}}
                            {{--</div>--}}

                            {{--<ul class="flex-w">--}}
                                {{--<li class="m-r-10">--}}
                                    {{--<input class="checkbox-color-filter" id="color-filter1" type="checkbox"--}}
                                           {{--name="color-filter1">--}}
                                    {{--<label class="color-filter color-filter1" for="color-filter1"></label>--}}
                                {{--</li>--}}

                                {{--<li class="m-r-10">--}}
                                    {{--<input class="checkbox-color-filter" id="color-filter2" type="checkbox"--}}
                                           {{--name="color-filter2">--}}
                                    {{--<label class="color-filter color-filter2" for="color-filter2"></label>--}}
                                {{--</li>--}}

                                {{--<li class="m-r-10">--}}
                                    {{--<input class="checkbox-color-filter" id="color-filter3" type="checkbox"--}}
                                           {{--name="color-filter3">--}}
                                    {{--<label class="color-filter color-filter3" for="color-filter3"></label>--}}
                                {{--</li>--}}

                                {{--<li class="m-r-10">--}}
                                    {{--<input class="checkbox-color-filter" id="color-filter4" type="checkbox"--}}
                                           {{--name="color-filter4">--}}
                                    {{--<label class="color-filter color-filter4" for="color-filter4"></label>--}}
                                {{--</li>--}}

                                {{--<li class="m-r-10">--}}
                                    {{--<input class="checkbox-color-filter" id="color-filter5" type="checkbox"--}}
                                           {{--name="color-filter5">--}}
                                    {{--<label class="color-filter color-filter5" for="color-filter5"></label>--}}
                                {{--</li>--}}

                                {{--<li class="m-r-10">--}}
                                    {{--<input class="checkbox-color-filter" id="color-filter6" type="checkbox"--}}
                                           {{--name="color-filter6">--}}
                                    {{--<label class="color-filter color-filter6" for="color-filter6"></label>--}}
                                {{--</li>--}}

                                {{--<li class="m-r-10">--}}
                                    {{--<input class="checkbox-color-filter" id="color-filter7" type="checkbox"--}}
                                           {{--name="color-filter7">--}}
                                    {{--<label class="color-filter color-filter7" for="color-filter7"></label>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}

                        {{--<div class="search-product pos-relative bo4 of-hidden">--}}
                            {{--<input class="s-text7 size6 p-l-23 p-r-50" type="text" name="search-product"--}}
                                   {{--placeholder="Search Products...">--}}

                            {{--<button class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">--}}
                                {{--<i class="fs-12 fa fa-search" aria-hidden="true"></i>--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
                    <!--  -->
                    <div class="flex-sb-m flex-w p-b-35">
                        <div class="flex-w">
                            <div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
                                <select class="selection-2" name="sorting">
                                    <option>Не сортировать</option>
                                    <option>Цена: по возрастанию</option>
                                    <option>Цена: по убыванию</option>
                                </select>
                            </div>

                            <div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
                                <select class="selection-2" name="sorting">
                                    <option>Price</option>
                                    <option>$0.00 - $50.00</option>
                                    <option>$50.00 - $100.00</option>
                                    <option>$100.00 - $150.00</option>
                                    <option>$150.00 - $200.00</option>
                                    <option>$200.00+</option>

                                </select>
                            </div>
                        </div>

                        <span class="s-text8 p-t-5 p-b-5">
							Показаны 1–12 из {{ $goods->total() }} элементов
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

                                        <div class="block2-btn-addcart w-size1 trans-0-4" data-name="{{ $good->name }}" data-article="{{ $good->article }}">
                                            <!-- Button -->
                                            <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
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
                                                    {{ $sku->price }} ₽
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
            </div>
        </div>
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
        console.log(minVal);
        console.log(maxVal);
        noUiSlider.create(filterBar, {
            start: [parseInt(minVal.innerHTML), parseInt(maxVal.innerHTML)],
            connect: true,
            range: {
                'min': parseInt(minVal.innerHTML),
                'max': parseInt(maxVal.innerHTML)
            }
        });

        var prices = [];
        filterBar.noUiSlider.on('change', function (values, handle) {
            skipValues[handle].innerHTML = Math.round(values[handle]);
            setTimeout(function () {
                ajaxCall(values, true)
            }, 1000);
        });
    </script>
@endsection
