<section class="blog__section section--padding" style="background-color:#f7f3f3">
            <div class="container-fluid">
                <div class="section__heading text-center mb-40">
                    <h2 class="section__heading--maintitle">From The Blog</h2>
                </div>
                <div class="blog__section--inner blog__swiper--activation swiper">
                    <div class="swiper-wrapper">
                        @foreach ($blogPosts as $post)
                            <div class="swiper-slide">
                                <div class="blog__items">
                                    <div class="blog__thumbnail">
                                        <a class="blog__thumbnail--link" href="{{ $post['url'] }}">
                                            <img class="blog__thumbnail--img" src="{{ asset($post['featured_image']) }}"
                                                style="height:235px" alt="blog-img">
                                        </a>
                                    </div>
                                    <div class="blog__content">
                                        <span class="blog__content--meta">{{ $post['created_at'] }}</span>
                                        <h3 class="blog__content--title"><a
                                                href="{{ $post['url'] }}">{{ $post['title'] }}</a></h3>
                                        <a class="blog__content--btn primary__btn" href="{{ $post['url'] }}">Read
                                            more</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper__nav--btn swiper-button-next"></div>
                    <div class="swiper__nav--btn swiper-button-prev"></div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('blog.index') }}" class="btn primary__btn">Show More</a>
                </div>
            </div>
        </section>
