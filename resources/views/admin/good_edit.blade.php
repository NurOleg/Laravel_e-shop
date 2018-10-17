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
                    <h2>Редактирование товара - {{ $good->name }}</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);" class="save-good"
                                       id="{{ $good->article }}">Сохранить</a></li>
                                <li><a href="/admin/goods">Вернуться к списку товаров</a></li>
                                {{--<li><a href="javascript:void(0);">Something else here</a></li>--}}
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <form id="wizard_horizontal">
                        <h2>Товар</h2>
                        <section class="row">
                            <div class="col-xs-6">
                                @foreach($good->image as $image)
                                    <div class="col-xs-12">
                                        <img style="width: 100%" src="{!!  $image->src !!}" alt="{{  $good->name }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-xs-6">
                                <div class="demo-checkbox">
                                    <input type="checkbox" id="basic_checkbox_2" name="active" class="filled-in" checked />
                                    <label for="basic_checkbox_2">Активность</label>
                                </div>
                                <br>
                                <br>
                                <b>Название</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="{{ $good->name }}" class="form-control"
                                               placeholder="Название"/>
                                    </div>
                                </div>
                                <b>Обновлено</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="{{ $good->updated_at }}" class="form-control"
                                               placeholder="Дата обновления"/>
                                    </div>
                                </div>
                                <b>Артикул</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="{{ $good->article }}" class="form-control"
                                               placeholder="Дата обновления"/>
                                    </div>
                                </div>
                                <b>Бренд</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="{{ $good->brand }}" class="form-control"
                                               placeholder="Дата обновления"/>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h2>SEO - теги</h2>
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

                        <h2>Описание</h2>
                        <section>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="body">
                            <textarea id="tinymce">
                                <h2>WYSIWYG Editor</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ullamcorper sapien non nisl facilisis bibendum in quis tellus. Duis in urna bibendum turpis pretium fringilla. Aenean neque velit, porta eget mattis ac, imperdiet quis nisi. Donec non dui et tortor vulputate luctus. Praesent consequat rhoncus velit, ut molestie arcu venenatis sodales.</p>
                                <h3>Lacinia</h3>
                                <ul>
                                    <li>Suspendisse tincidunt urna ut velit ullamcorper fermentum.</li>
                                    <li>Nullam mattis sodales lacus, in gravida sem auctor at.</li>
                                    <li>Praesent non lacinia mi.</li>
                                    <li>Mauris a ante neque.</li>
                                    <li>Aenean ut magna lobortis nunc feugiat sagittis.</li>
                                </ul>
                                <h3>Pellentesque adipiscing</h3>
                                <p>Maecenas quis ante ante. Nunc adipiscing rhoncus rutrum. Pellentesque adipiscing urna mi, ut tempus lacus ultrices ac. Pellentesque sodales, libero et mollis interdum, dui odio vestibulum dolor, eu pellentesque nisl nibh quis nunc. Sed porttitor leo adipiscing venenatis vehicula. Aenean quis viverra enim. Praesent porttitor ut ipsum id ornare.</p>
                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h2>Торговые предложения</h2>
                        <section>
                            <p>
                                Morbi ornare tellus at elit ultrices id dignissim lorem elementum. Sed eget nisl at
                                justo
                                condimentum dapibus. Fusce eros justo, pellentesque non euismod ac, rutrum sed quam.
                                Ut non mi tortor. Vestibulum eleifend varius ullamcorper. Aliquam erat volutpat.
                                Donec diam massa, porta vel dictum sit amet, iaculis ac massa. Sed elementum dui
                                commodo lectus sollicitudin in auctor mauris venenatis.
                            </p>
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
    <script src="{{ asset('adminpanel/plugins/tinymce/tinymce.js') }}"></script>
    <script src="{{ asset('adminpanel/js/pages/forms/basic-form-elements.js') }}"></script>
    <script src="{{ asset('adminpanel/js/pages/forms/form-wizard.js') }}"></script>
    <script src="{{ asset('adminpanel/js/pages/forms/editors.js') }}"></script>
@stop