@extends('layouts.app')
@section('specificCSS')
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">
@endsection
@section('content')
    <section class="bgwhite p-t-45 p-b-58">
        <div class="container">
            <div class="sec-title p-b-22">
                <h3 class="m-text5 t-center">
                    Наша продукция
                </h3>
            </div>

            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($props['propsForTops'] as $code => $value)
                        <li class="nav-item">
                            <a class="nav-link @if($loop->first) {{ 'active' }} @endif" data-toggle="tab"
                               href="#{{$code}}" role="tab">{{$value}}</a>
                        </li>
                    @endforeach
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-35">
                    <!-- - -->
                    @foreach($props['propsForTops'] as $code => $value)
                        <div class="tab-pane fade @if($loop->first) {{ 'show active' }} @endif" id="{{$code}}"
                             role="tabpanel">
                            <div class="row">
                                @foreach($topGoods[$code] as $topGood)
                                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-img wrap-pic-w of-hidden pos-relative block2-label{{$code}}">
                                                @foreach($topGood->image as $image)
                                                    <img src="{!!  $image->src !!}" alt="{{ $topGood->name }}">
                                                @endforeach

                                                <div class="block2-overlay trans-0-4">
                                                    {{--<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">--}}
                                                    {{--<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>--}}
                                                    {{--<i class="icon-wishlist icon_heart dis-none"--}}
                                                    {{--aria-hidden="true"></i>--}}
                                                    {{--</a>--}}

                                                    <div class="block2-btn-addcart w-size1 trans-0-4"
                                                         data-name="{{ $topGood->name }}"
                                                         data-article="{{ $topGood->article }}">
                                                        <!-- Button -->
                                                        <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 @if ($topGood->skus->count() > 1) hasMany @endif ">
                                                            В корзину
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="block2-txt p-t-20">
                                                <a href="{{ $topGood->url }}"
                                                   class="block2-name dis-block s-text3 p-b-5">
                                                    {{ $topGood->name }}
                                                </a>

                                                <span class="block2-price m-text6 p-r-5">
											@if ($topGood->skus->count() === 1)
                                                        @foreach($topGood->skus as $sku)
                                                            <span>{{ $sku->price }}</span> ₽
                                                        @endforeach
                                                    @else
                                                        @foreach($topGood->skus as $sku)
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
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section('specificJS')
    <script>
        var json = {!! $json !!};
    </script>
    <script type="text/javascript" src="{{ asset('vendor/sweetalert/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert-custom.js') }}"></script>
@endsection