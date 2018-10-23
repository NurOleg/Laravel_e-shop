@extends('layouts.admin')

@section('specificCSS')
    <link rel="stylesheet" href="{{ asset('adminpanel/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}">
@endsection

@section('content')

    <!-- Basic Examples -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Товары
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Активность</th>
                                <th>{{ $props_good['article'] }}</th>
                                <th>{{ $props_good['brand'] }}</th>
                                <th>{{ $props_sku['price'] }} от</th>
                                <th>{{ $props_sku['price'] }} до</th>
                                <th>{{ $props_sku['count'] }}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Название</th>
                                <th>Активность</th>
                                <th>{{ $props_good['article'] }}</th>
                                <th>{{ $props_good['brand'] }}</th>
                                <th>{{ $props_sku['price'] }} от</th>
                                <th>{{ $props_sku['price'] }} до</th>
                                <th>{{ $props_sku['count'] }}</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($goods as $good)
                                <tr>
                                    <td><a href="goods/{{ $good->article }}">{{ $good->name }}</a></td>
                                    <td>
                                        @if($good->active === 1)
                                            Да
                                        @else
                                            Нет
                                        @endif
                                    </td>
                                    <td>{{ $good->article }}</td>
                                    <td>{{ $good->brand }}</td>
                                    @if($good['skus']->count() > 1)
                                        @foreach($good['skus'] as $sku)
                                            @if($loop->first || $loop->last)
                                                <td>{{ $sku->price }}</td>
                                            @endif
                                        @endforeach
                                    @else
                                        <td>{{ $sku->price }}</td>
                                        <td>{{ $sku->price }}</td>
                                    @endif

                                    <td>{{ $good->total }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('specificJS')
    <script src="{{ asset('adminpanel/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminpanel/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('adminpanel/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminpanel/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('adminpanel/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('adminpanel/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminpanel/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminpanel/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminpanel/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminpanel/js/pages/tables/jquery-datatable.js') }}"></script>
@stop