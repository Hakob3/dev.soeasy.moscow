@extends('welcome')
@section('content')

    @foreach($catalogItems as $key => $val)
        <section class="catalog-section" id="{{$val['rubric']->uri}}">
            <div class="title">
                <h3 class="text-center">{{$val['rubric']->name}}</h3>
            </div>
            <div class="row">
                @foreach($val['items'] as $key => $item)
                    @include('catalog.oneItem')
                @endforeach
            </div>
        </section>


    @endforeach


@endsection