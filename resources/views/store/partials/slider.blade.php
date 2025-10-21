<!-- slider.blade.php -->
<section class="hero__slider--section slider__section3" style="position: relative; overflow: hidden; margin-top: 0 !important;">
    <div class="hero__slider--inner hero__slider--activation swiper" style="height: auto;">
        <div class="hero__slider--wrapper swiper-wrapper">
            @foreach ($sliders as $slider)
                @if ($slider->status)
                    <div class="swiper-slide">
                        <div class="hero__slider--items home3__slider--bg" style="background-image: url('{{ asset('storage/' . $slider->image) }}'); background-size: cover; background-position: center; min-height: 400px;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-6 offset-lg-6">
                                        <div class="hero__slider--items__inner" style="display: flex; align-items: center; justify-content: center; height: 100%;">
                                            <div class="slider__content style3 text-center" style="max-width: 100%; padding: 20px;">
                                                <p class="slider__content--desc desc1 mb-15">&nbsp;</p>
                                                <h2 class="hero__slider--maintitle h1 text-white">{{ $slider->title }}</h2>
                                                <p class="slider__content--desc desc2 d-sm-2-none mb-40 text-white">
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

<style>
.header__section {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
    position: relative;
}

.hero__slider--section {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

.hero__slider--items {
    min-height: 600px !important; /* Increased from 250px to 400px for desktop */
}

@media (max-width: 768px) {
    .hero__slider--items {
        min-height: 150px !important; /* Reduced from 200px to 150px for mobile */
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function adjustSliderPosition() {
        const headerSection = document.querySelector('.header__section');
        const topbar = document.querySelector('.header__topbar--style3');
        const mainHeader = document.querySelector('.main__header');
        const sliderSection = document.querySelector('.hero__slider--section');

        if (headerSection && sliderSection) {
            const topbarHeight = topbar ? topbar.offsetHeight : 0;
            const mainHeaderHeight = mainHeader ? mainHeader.offsetHeight : 0;
            const headerHeight = topbarHeight + mainHeaderHeight;

            // Use 80% of viewport height for desktop, 60% for mobile
            let viewportHeight = window.innerHeight;
            let heightPercentage = window.innerWidth > 768 ? 0.8 : 0.6; // 80% for desktop, 60% for mobile
            const adjustedHeight = Math.max(viewportHeight * heightPercentage - headerHeight, window.innerWidth > 768 ? 600 : 200); // Minimum 600px desktop, 200px mobile

            sliderSection.style.marginTop = `${headerHeight}px`;
            sliderSection.style.paddingTop = '0';

            const slides = sliderSection.querySelectorAll('.hero__slider--items');
            slides.forEach(slide => {
                slide.style.minHeight = `${adjustedHeight}px`;
                slide.style.height = `${adjustedHeight}px`;
            });
        }
    }

    // Run on load, resize, and scroll
    adjustSliderPosition();
    window.addEventListener('resize', adjustSliderPosition);
    window.addEventListener('scroll', adjustSliderPosition);

    // Initialize Swiper with autoHeight
    if (typeof Swiper !== 'undefined') {
        const swiper = new Swiper('.hero__slider--activation', {
            slidesPerView: 1,
            loop: true,
            clickable: true,
            speed: 800,
            spaceBetween: 30,
            autoHeight: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            on: {
                init: function() {
                    adjustSliderPosition();
                },
                resize: function() {
                    adjustSliderPosition();
                }
            }
        });
    }
});
</script>
