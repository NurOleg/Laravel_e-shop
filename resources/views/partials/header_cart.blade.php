<div class="header-wrapicon2">
    <img src="{{ asset('images/icons/icon-header-02.png') }}"
         class="header-icon1 js-show-header-dropdown" alt="ICON">
    <span class="header-icons-noti">
        @if($count) {{ $count }} @else 0 @endif
                    </span>
    <!-- Header cart noti -->
    @if(count((array)$cart) > 0 )
        <div class="header-cart header-dropdown">
            <ul class="header-cart-wrapitem">
                @foreach($cart as $key => $item)
                    <li class="header-cart-item">
                        <div class="header-cart-item-img">
                            <img src="{{ $item->attributes->image }}" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt">
                            <a href="#" class="header-cart-item-name">
                                {{ $item->name }}
                            </a>

                            <span class="header-cart-item-info">
											{{ $item->quantity }} x {{ $item->price }}₽
										</span>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="header-cart-total">
                Итого: <span>{{ $total }}</span>₽
            </div>

            <div class="header-cart-buttons">
                <div class="header-cart-wrapbtn">
                    <!-- Button -->
                    <a href="/personal/cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
                        Заказать
                    </a>
                </div>

                {{--<div class="header-cart-wrapbtn">--}}
                {{--<!-- Button -->--}}
                {{--<a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">--}}
                {{--Check Out--}}
                {{--</a>--}}
                {{--</div>--}}
            </div>
        </div>
    @endif
</div>