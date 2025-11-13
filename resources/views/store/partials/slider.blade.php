<!-- slider.blade.php -->
<section class="hero__slider--section slider__section3">
    <div class="hero__slider--inner hero__slider--activation swiper">
        <div class="hero__slider--wrapper swiper-wrapper">
            @foreach ($sliders as $slider)
                @if ($slider->status)
                    <div class="swiper-slide">
                        <div class="hero__slider--items home3__slider--bg"
                            style="background-image: url('{{ asset('storage/' . $slider->image) }}');">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-lg-6 offset-lg-6">
                                        <div class="hero__slider--items__inner">

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
        overflow: visible;
        /* Allow content to be fully visible */
    }

    .hero__slider--items {
        background-size: cover;
        background-position: center;
        width: 100%;
        height: auto;
        /* Let Swiper handle height */
    }

    .slider__content.style3 {
        padding: 20px;
        max-width: 90%;
        /* Ensure content fits within viewport */
        margin: 0 auto;
        text-align: center;
    }

    .hero__slider--maintitle {
        font-size: clamp(1.5rem, 5vw, 2.5rem);
        /* Responsive font size */
        line-height: 1.2;
        margin-bottom: 15px;
    }

    .slider__content--desc.desc2 {
        font-size: clamp(0.9rem, 3vw, 1.1rem);
        /* Responsive font size */
        margin-bottom: 20px;
    }

    .primary__btn.slider__btn {
        font-size: clamp(0.75rem, 2vw, 0.9rem); /* Smaller font size */
        padding: 8px 16px; /* Reduced padding for smaller button */
        line-height: 1.5;
        display: inline-flex;
        align-items: center;
        gap: 8px; /* Space between text and icon */
        white-space: nowrap; /* Prevent text wrapping */
    }

    .slider__btn--arrow__icon {
        width: 16px; /* Smaller SVG icon */
        height: 10px;
    }

    @media (max-width: 768px) {
        .hero__slider--items {
            min-height: auto !important;
            /* Remove fixed min-height */
            padding-bottom: 20px;
            /* Add padding to prevent content cutoff */
        }

        .col-lg-6.offset-lg-6 {
            margin: 0;
            /* Remove offset on mobile */
            width: 100%;
            /* Full width for content */
        }

        .hero__slider--items__inner {
            min-height: auto;
            /* Allow content to dictate height */
            padding: 10px;
        }

        .primary__btn.slider__btn {
            font-size: clamp(0.7rem, 1.8vw, 0.85rem); /* Slightly smaller on mobile */
            padding: 6px 12px; /* Further reduced padding for mobile */
        }

        .slider__btn--arrow__icon {
            width: 14px; /* Slightly smaller icon on mobile */
            height: 9px;
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

                // Adjust margin-top to account for header
                sliderSection.style.marginTop = `${headerHeight}px`;
                sliderSection.style.paddingTop = '0';
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
                spaceBetween: 10, // Reduced for mobile
                autoHeight: true, // Let Swiper adjust height based on content
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    768: {
                        spaceBetween: 30, // Larger spacing for desktop
                    },
                },
                on: {
                    init: function() {
                        adjustSliderPosition();
                    },
                    resize: function() {
                        adjustSliderPosition();
                    },
                },
            });
        }
    });
</script>
