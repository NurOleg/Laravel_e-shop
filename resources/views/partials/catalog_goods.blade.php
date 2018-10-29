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