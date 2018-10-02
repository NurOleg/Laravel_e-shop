@extends('layouts.app')
@section('content')
    <p>Это содержимое тела страницы.</p>

    @foreach($categoriesTree as $categoryTree)
        <div class="col-md-12">
            <h3>-{{ $categoryTree->name }}</h3>
            <hr/>
            <div class="row">
                @foreach($categoryTree->children as $categoryChildrenTree)
                    <div class="col-md-4">
                        <h4> ---------- {{ $categoryChildrenTree->name }}</h4>
                        <hr/>
                        @foreach($categoryChildrenTree->children as $categorySubChildrenTree)
                            <h5> ----------------------------------- {{$categorySubChildrenTree->name}}</h5>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection