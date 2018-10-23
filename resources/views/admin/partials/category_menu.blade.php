<li>
    <a href="javascript:void(0);" class="menu-toggle waves-effect waves-block">
        <i class="material-icons">trending_down</i>
        <span>Категории</span>
    </a>
    <ul class="ml-menu">
        @foreach($categoriesMenu as $topLevelItem)
            <li>
                <div @if($topLevelItem->children->count() > 0) class="menu-toggle add-plus" @endif><a
                            href="javascript:void(0);">
                        <span>{{ $topLevelItem->name }}</span></a>
                    <a href="/admin/categories/{{ $topLevelItem->id }}">੦ Товары </a>
                </div>
                @if($topLevelItem->children->count() > 0)
                    <ul class="ml-menu">
                        @foreach($topLevelItem->children as $secondMenuItem)
                            <li>
                                <div @if($secondMenuItem->children->count() > 0) class="menu-toggle add-plus" @endif>
                                    <a href="javascript:void(0);">
                                        <span>{{$secondMenuItem->name}}</span>
                                    </a>
                                    <a href="/admin/categories/{{ $secondMenuItem->id }}">੦ Товары</a>
                                </div>
                                @if($topLevelItem->children->count() > 0)
                                    <ul class="ml-menu">
                                        @foreach($secondMenuItem->children as $thirdMenuItem)
                                            <li>
                                                <a href="javascript:void(0);" @if($secondMenuItem->children->count() > 0) class="menu-toggle add-plus" @endif>
                                                    <span>{{$thirdMenuItem->name}}</span>
                                                </a>
                                                <a href="/admin/categories/{{ $thirdMenuItem->id }}">੦ Товары</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</li>