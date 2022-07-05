<link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>

<div class=" container lookbooks">

    @foreach($lookBooks as $key => $lookbook)
        <section id="{{$lookbook->uri}}" class="mt-5">
            <h4 class="text-center"> <?=$lookbook->name?></h4>
            <div class="look-items row" id="container{{$lookbook->id}}">
                @foreach($lookbook->lookPhotos as $key => $look)

                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg->12 mt-4">
                        <img class="img-thumbnail img-fit-100" src="http://soeasy.moscow/images/content/{{$look->image}}">
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
</div>
@section('scripts')
    <script src="/js/WOW.js"></script>
    <script>
        new WOW().init();
    </script>
@endsection