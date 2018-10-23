@extends('layouts.admin')
@section('content')

    {{--<div class="block-header">--}}
    {{--<h2>--}}
    {{--FORM WIZARD--}}
    {{--<small>Taken from <a href="https://github.com/rstaib/jquery-steps" target="_blank">github.com/rstaib/jquery-steps</a> & <a href="https://jqueryvalidation.org/" target="_blank">jqueryvalidation.org</a></small>--}}
    {{--</h2>--}}
    {{--</div>--}}
    <!-- Basic Example | Horizontal Layout -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Редактирование заказа №{{ $order->code }}</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);" class="save-good"
                                       id="{{ $order->id }}">Сохранить</a></li>
                                <li><a href="/admin/orders">Вернуться к списку заказов</a></li>
                                {{--<li><a href="javascript:void(0);">Something else here</a></li>--}}
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <form id="wizard_horizontal">
                        <h2>Информация о доставке</h2>
                        <section class="row">
                            <div class="col-xs-12">
                                <b>{{ $props['status'] }}</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="{{ $props['statuses'][$order->status] }}" class="form-control"
                                               placeholder="{{ $props['status'] }}" disabled="disabled"/>
                                    </div>
                                </div>
                                <br>
                                <b>{{ $props['code'] }}</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="{{ $order->code }}" class="form-control"
                                               placeholder="{{ $props['code'] }}" disabled="disabled"/>
                                    </div>
                                </div>
                                <b>Добавлен</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="{{ $order->created_at }}" class="form-control"
                                               placeholder="Дата добавления"/>
                                    </div>
                                </div>
                                <b>Обновлен</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="{{ $order->updated_at }}" class="form-control"
                                               placeholder="Дата обновления"/>
                                    </div>
                                </div>
                                <b>{{ $props['sum'] }}</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="{{ $order->sum }}" class="form-control"
                                               placeholder="{{ $props['sum'] }}"/>
                                    </div>
                                </div>
                                <b>{{ $props['adress'] }}</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="{{ $order->adress }}" class="form-control"
                                               placeholder="{{ $props['adress'] }}"/>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h2>Корзина пользователя</h2>
                        <section>
                            <div class="col-xs-12">
                                <b>Заголовок (title)</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="" class="form-control"
                                               placeholder="Заголовок (title)"/>
                                    </div>
                                </div>
                                <b>Описание (description)</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="" class="form-control"
                                               placeholder="Описание (description)"/>
                                    </div>
                                </div>
                                <b>Ключевые слова (keywords)</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="" class="form-control"
                                               placeholder="Ключевые слова (keywords)"/>
                                    </div>
                                </div>
                                <b>Заголовок (h1)</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="" class="form-control"
                                               placeholder="Заголовок (h1)"/>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h2>Доставка, оплата, информация о пользователе</h2>
                        <section>

                        </section>

                        {{--<h2>Forth Step</h2>--}}
                        {{--<section>--}}
                        {{--<p>--}}
                        {{--Quisque at sem turpis, id sagittis diam. Suspendisse malesuada eros posuere mauris vehicula--}}
                        {{--vulputate. Aliquam sed sem tortor. Quisque sed felis ut mauris feugiat iaculis nec--}}
                        {{--ac lectus. Sed consequat vestibulum purus, imperdiet varius est pellentesque vitae.--}}
                        {{--Suspendisse consequat cursus eros, vitae tempus enim euismod non. Nullam ut commodo--}}
                        {{--tortor.--}}
                        {{--</p>--}}
                        {{--</section>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic Example | Horizontal Layout -->
    <!-- Basic Example | Vertical Layout -->
    {{--<div class="row clearfix">--}}
    {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
    {{--<div class="card">--}}
    {{--<div class="header">--}}
    {{--<h2>BASIC EXAMPLE - VERTICAL LAYOUT</h2>--}}
    {{--<ul class="header-dropdown m-r--5">--}}
    {{--<li class="dropdown">--}}
    {{--<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
    {{--<i class="material-icons">more_vert</i>--}}
    {{--</a>--}}
    {{--<ul class="dropdown-menu pull-right">--}}
    {{--<li><a href="javascript:void(0);">Action</a></li>--}}
    {{--<li><a href="javascript:void(0);">Another action</a></li>--}}
    {{--<li><a href="javascript:void(0);">Something else here</a></li>--}}
    {{--</ul>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--<div class="body">--}}
    {{--<form id="wizard_vertical">--}}
    {{--<h2>Товар</h2>--}}
    {{--<section>--}}
    {{--<p>--}}
    {{--Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut nulla nunc. Maecenas--}}
    {{--arcu sem, hendrerit a tempor quis, sagittis accumsan tellus. In hac habitasse platea--}}
    {{--dictumst. Donec a semper dui. Nunc eget quam libero. Nam at felis metus. Nam tellus--}}
    {{--dolor, tristique ac tempus nec, iaculis quis nisi.--}}
    {{--</p>--}}
    {{--</section>--}}

    {{--<h2>SEO - теги</h2>--}}
    {{--<section>--}}
    {{--<p>--}}
    {{--Donec mi sapien, hendrerit nec egestas a, rutrum vitae dolor. Nullam venenatis diam ac--}}
    {{--ligula elementum pellentesque. In lobortis sollicitudin felis non eleifend. Morbi--}}
    {{--tristique tellus est, sed tempor elit. Morbi varius, nulla quis condimentum dictum,--}}
    {{--nisi elit condimentum magna, nec venenatis urna quam in nisi. Integer hendrerit sapien--}}
    {{--a diam adipiscing consectetur. In euismod augue ullamcorper leo dignissim quis elementum--}}
    {{--arcu porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum leo--}}
    {{--velit, blandit ac tempor nec, ultrices id diam. Donec metus lacus, rhoncus sagittis--}}
    {{--iaculis nec, malesuada a diam. Donec non pulvinar urna. Aliquam id velit lacus.--}}
    {{--</p>--}}
    {{--</section>--}}

    {{--<h2>Торговые предложения</h2>--}}
    {{--<section>--}}
    {{--<p>--}}
    {{--Morbi ornare tellus at elit ultrices id dignissim lorem elementum. Sed eget nisl at justo--}}
    {{--condimentum dapibus. Fusce eros justo, pellentesque non euismod ac, rutrum sed quam.--}}
    {{--Ut non mi tortor. Vestibulum eleifend varius ullamcorper. Aliquam erat volutpat.--}}
    {{--Donec diam massa, porta vel dictum sit amet, iaculis ac massa. Sed elementum dui--}}
    {{--commodo lectus sollicitudin in auctor mauris venenatis.--}}
    {{--</p>--}}
    {{--</section>--}}

    {{--<h2>Forth Step</h2>--}}
    {{--<section>--}}
    {{--<p>--}}
    {{--Quisque at sem turpis, id sagittis diam. Suspendisse malesuada eros posuere mauris vehicula--}}
    {{--vulputate. Aliquam sed sem tortor. Quisque sed felis ut mauris feugiat iaculis nec--}}
    {{--ac lectus. Sed consequat vestibulum purus, imperdiet varius est pellentesque vitae.--}}
    {{--Suspendisse consequat cursus eros, vitae tempus enim euismod non. Nullam ut commodo--}}
    {{--tortor.--}}
    {{--</p>--}}
    {{--</section>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    <!-- #END# Basic Example | Vertical Layout -->
    <!-- Advanced Form Example With Validation -->
    {{--<div class="row clearfix">--}}
    {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
    {{--<div class="card">--}}
    {{--<div class="header">--}}
    {{--<h2>ADVANCED FORM EXAMPLE WITH VALIDATION</h2>--}}
    {{--<ul class="header-dropdown m-r--5">--}}
    {{--<li class="dropdown">--}}
    {{--<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
    {{--<i class="material-icons">more_vert</i>--}}
    {{--</a>--}}
    {{--<ul class="dropdown-menu pull-right">--}}
    {{--<li><a href="javascript:void(0);">Action</a></li>--}}
    {{--<li><a href="javascript:void(0);">Another action</a></li>--}}
    {{--<li><a href="javascript:void(0);">Something else here</a></li>--}}
    {{--</ul>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--<div class="body">--}}
    {{--<form id="wizard_with_validation" method="POST">--}}
    {{--<h3>Account Information</h3>--}}
    {{--<fieldset>--}}
    {{--<div class="form-group form-float">--}}
    {{--<div class="form-line">--}}
    {{--<input type="text" class="form-control" name="username" required>--}}
    {{--<label class="form-label">Username*</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group form-float">--}}
    {{--<div class="form-line">--}}
    {{--<input type="password" class="form-control" name="password" id="password" required>--}}
    {{--<label class="form-label">Password*</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group form-float">--}}
    {{--<div class="form-line">--}}
    {{--<input type="password" class="form-control" name="confirm" required>--}}
    {{--<label class="form-label">Confirm Password*</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</fieldset>--}}

    {{--<h3>Profile Information</h3>--}}
    {{--<fieldset>--}}
    {{--<div class="form-group form-float">--}}
    {{--<div class="form-line">--}}
    {{--<input type="text" name="name" class="form-control" required>--}}
    {{--<label class="form-label">First Name*</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group form-float">--}}
    {{--<div class="form-line">--}}
    {{--<input type="text" name="surname" class="form-control" required>--}}
    {{--<label class="form-label">Last Name*</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group form-float">--}}
    {{--<div class="form-line">--}}
    {{--<input type="email" name="email" class="form-control" required>--}}
    {{--<label class="form-label">Email*</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group form-float">--}}
    {{--<div class="form-line">--}}
    {{--<textarea name="address" cols="30" rows="3" class="form-control no-resize" required></textarea>--}}
    {{--<label class="form-label">Address*</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group form-float">--}}
    {{--<div class="form-line">--}}
    {{--<input min="18" type="number" name="age" class="form-control" required>--}}
    {{--<label class="form-label">Age*</label>--}}
    {{--</div>--}}
    {{--<div class="help-info">The warning step will show up if age is less than 18</div>--}}
    {{--</div>--}}
    {{--</fieldset>--}}

    {{--<h3>Terms & Conditions - Finish</h3>--}}
    {{--<fieldset>--}}
    {{--<input id="acceptTerms-2" name="acceptTerms" type="checkbox" required>--}}
    {{--<label for="acceptTerms-2">I agree with the Terms and Conditions.</label>--}}
    {{--</fieldset>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection

@section('specificJS')
    <script src="{{ asset('adminpanel/plugins/jquery-steps/jquery.steps.js') }}"></script>
    <script src="{{ asset('adminpanel/js/pages/forms/basic-form-elements.js') }}"></script>
    <script src="{{ asset('adminpanel/js/pages/forms/form-wizard.js') }}"></script>
    <script src="{{ asset('adminpanel/js/pages/ui/modals.js') }}"></script>
    <script src="{{ asset('adminpanel/js/pages/forms/editors.js') }}"></script>
    <script src="{{ asset('adminpanel/js/pages/cards/basic.js') }}"></script>
    <script>
        // $(document).ready(function () {
        //     $('.sku-edit').on('click', function (e) {
        //         e.preventDefault();
        //         var skuId = $(this).attr('id');
        //         console.log(json[skuId]);
        //         $.each(json[skuId], function (item, value) {
        //             if (value !== null && ($(".modal-body #" + item).length > 0)) {
        //                 console.log('qqqq');
        //                 $(".modal-body #" + item).find('input').val(value);
        //             }
        //         });
        //     });
        // });
    </script>
@stop