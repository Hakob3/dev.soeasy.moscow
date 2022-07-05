@extends('welcome')

@section('content')

    <section class="for-desktop">
        <div class="swiper-container index-slider" id="index-slider">
            <div class="swiper-wrapper">
                @foreach($slider as $slide)
                    <div class="swiper-slide">
                        <a class="js-slider-click" href="{{$slide->link}}">
                            <img src="https://soeasy.moscow/images/content/{{$slide->image}}"/>
                        </a>
                    </div>
                @endforeach

            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next sw-button-a"></div>
            <div class="swiper-button-prev sw-button-a"></div>
        </div>
    </section>
    <section class="for-mobile">
        <div class="swiper-container index-slider" id="index-slider">
            <div class="swiper-wrapper">
                @foreach($sliderMobile as $slide)
                    <div class="swiper-slide">
                        <a class="js-slider-click" href="{{$slide->link}}">
                            <img src="https://soeasy.moscow/images/content/{{$slide->image}}"/>
                        </a>
                    </div>
                @endforeach

            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next sw-button-a"></div>
            <div class="swiper-button-prev sw-button-a"></div>
        </div>
    </section>

    @include('about.about')



@endsection

@section('scripts')
    <script>
        var mySwiper = new Swiper('.swiper-container', {
            // Optional parameters
            direction: 'horizontal',
            effect: 'fade',
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: true,
            },
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
        });
    </script>
@endsection