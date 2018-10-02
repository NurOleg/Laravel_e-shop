<nav class="menu">
    <ul class="main_menu">
        <li>
            <a href="index.html">Главная</a>
            <ul class="sub_menu">
                <li><a href="index.html">Homepage V1</a></li>
                <li><a href="home-02.html">Homepage V2</a></li>
                <li><a href="home-03.html">Homepage V3</a></li>
            </ul>
        </li>

        <li>
            <a href="product.html">Каталог</a>
            <ul class="sub_menu">
                <div class="menu_block"></div>
                @foreach($catalogCategories as $catalogCategory)
                            @if ($loop->first)
                                <div class="menu_block">
                            @endif
                            <li><a href="{{ $catalogCategory->category_slug }}">{{ $catalogCategory->name }}</a></li>
                            @if ($loop->iteration == 5 || $loop->iteration == 10)
                                </div>
                                <div class="menu_block">
                            @endif
                            @if ($loop->last)
                                </div>
                            @endif
                @endforeach
            </ul>
        </li>

        <li class="sale-noti">
            <a href="product.html">Распродажа</a>
        </li>

        <li>
            <a href="blog.html">Новости</a>
        </li>

        <li>
            <a href="about.html">Контакты</a>
        </li>
    </ul>
</nav>