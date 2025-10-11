<!-- Updated slider.blade.php -->
<section class="hero__slider--section slider__section3">
    <div class="hero__slider--inner hero__slider--activation swiper">
        <div class="hero__slider--wrapper swiper-wrapper">
            @foreach ($sliders as $slider)
                @if ($slider->status)
                    <div class="swiper-slide">
                        <div class="hero__slider--items home3__slider--bg" style="background-image: url('{{ asset('storage/' . $slider->image) }}');">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-6 offset-lg-6">
                                        <div class="hero__slider--items__inner">
                                            <div class="slider__content style3 text-center">
                                                <p class="slider__content--desc desc1 mb-15">&nbsp;</p>
                                                <h2 class="slider__content--maintitle h1 text-white">{{ $slider->title }}</h2>
                                                <p class="slider__content--desc desc2 d-sm-2-none mb-40 text-white">
                                                    <!-- Optional: Add a default or dynamic description if needed -->
                                                    Discover the latest in fashion!
                                                </p>
                                                <a class="primary__btn slider__btn" href="{{ $slider->link ?? route('shop') }}">
                                                    Show Collection
                                                    <svg class="slider__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                                                        <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="swiper__nav--btn swiper-button-next"></div>
        <div class="swiper__nav--btn swiper-button-prev"></div>
    </div>
</section>
