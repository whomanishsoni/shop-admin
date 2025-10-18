        <section class="testimonial__section section--padding pt-0">
            <div class="container-fluid">
                <div class="section__heading text-center mb-40">
                    <h2 class="section__heading--maintitle">WHAT OUR CLIENTS SAY</h2>
                </div>
                <div class="testimonial__section--inner testimonial__swiper--activation swiper">
                    <div class="swiper-wrapper">
                        @forelse($testimonials as $testimonial)
                            <div class="swiper-slide">
                                <div class="testimonial__items text-center">
                                    <div class="testimonial__items--thumbnail">
                                        <img class="testimonial__items--thumbnail__img border-radius-50"
                                            src="{{ asset($testimonial['image']) }}" alt="{{ $testimonial['name'] }}">
                                    </div>
                                    <div class="testimonial__items--content">
                                        <h3 class="testimonial__items--title">{{ $testimonial['name'] }}</h3>
                                        @if ($testimonial['designation'] && $testimonial['designation'] !== 'Customer')
                                            <h4 class="testimonial__items--designation text-muted">
                                                {{ $testimonial['designation'] }}</h4>
                                        @endif
                                        <p class="testimonial__items--desc">{{ $testimonial['message'] }}</p>
                                        <ul class="rating testimonial__rating d-flex justify-content-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <li class="rating__list">
                                                    <span class="rating__list--icon">
                                                        <svg class="rating__list--icon__svg"
                                                            xmlns="http://www.w3.org/2000/svg" width="14.105"
                                                            height="14.732" viewBox="0 0 10.105 9.732">
                                                            <path data-name="star - Copy"
                                                                d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0 0 0-.571,0L3.375,3.039.268,3.5a.3.3,0 0 0-.178.514L2.347,6.242,1.813,9.4a.314.314,0 0 0.464.316L5.052,8.232,7.827,9.712A.314.314,0 0 0 8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0 0 0 9.837,3.5Z"
                                                                transform="translate(0 -0.018)"
                                                                fill="{{ $i <= $testimonial['rating'] ? 'currentColor' : '#e5e5e5' }}">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <div class="text-center p-5">
                                    <p class="text-muted">No testimonials available yet.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- ✅ Navigation Arrows -->
                    <div class="swiper__nav--btn style3 swiper-button-next"></div>
                    <div class="swiper__nav--btn style3 swiper-button-prev"></div>

                    <div class="testimonial__pagination swiper-pagination"></div>
                </div>
            </div>
        </section>
