{{-- resources/views/store/partials/quickview-modal.blade.php --}}
<div class="modal" id="modal1" data-animation="slideInUp">
    <div class="modal-dialog quickview__main--wrapper">
        <header class="modal-header quickview__header">
            <button class="close-modal quickview__close--btn" aria-label="close modal" data-close>✕ </button>
        </header>
        <div class="quickview__inner">
            <div class="row row-cols-lg-2 row-cols-md-2">
                <div class="col">
                    <div class="quickview__product--media product__details--media">
                        <div class="product__media--preview  swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="product__media--preview__items">
                                        <a class="product__media--preview__items--link glightbox" data-gallery="product-media-preview" href="{{ asset('assets/images/product/p1.jpg') }}"><img class="product__media--preview__items--img" src="{{ asset('assets/images/product/p1.jpg') }}" alt="product-media-img"></a>
                                        <div class="product__media--view__icon">
                                            <a class="product__media--view__icon--link glightbox" href="{{ asset('assets/images/product/p1.jpg') }}" data-gallery="product-media-preview">
                                                <svg class="product__media--view__icon--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product__media--preview__items">
                                        <a class="product__media--preview__items--link glightbox" data-gallery="product-media-preview" href="{{ asset('assets/images/product/p2.jpg') }}"><img class="product__media--preview__items--img" src="{{ asset('assets/images/product/p2.jpg') }}" alt="product-media-img"></a>
                                        <div class="product__media--view__icon">
                                            <a class="product__media--view__icon--link glightbox" href="{{ asset('assets/images/product/p2.jpg') }}" data-gallery="product-media-preview">
                                                <svg class="product__media--view__icon--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product__media--preview__items">
                                        <a class="product__media--preview__items--link glightbox" data-gallery="product-media-preview" href="{{ asset('assets/images/product/p3.jpg') }}"><img class="product__media--preview__items--img" src="{{ asset('assets/images/product/p3.jpg') }}" alt="product-media-img"></a>
                                        <div class="product__media--view__icon">
                                            <a class="product__media--view__icon--link glightbox" href="{{ asset('assets/images/product/p3.jpg') }}" data-gallery="product-media-preview">
                                                <svg class="product__media--view__icon--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product__media--preview__items">
                                        <a class="product__media--preview__items--link glightbox" data-gallery="product-media-preview" href="{{ asset('assets/images/product/p4.jpg') }}"><img class="product__media--preview__items--img" src="{{ asset('assets/images/product/p4.jpg') }}" alt="product-media-img"></a>
                                        <div class="product__media--view__icon">
                                            <a class="product__media--view__icon--link glightbox" href="{{ asset('assets/images/product/p4.jpg') }}" data-gallery="product-media-preview">
                                                <svg class="product__media--view__icon--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product__media--preview__items">
                                        <a class="product__media--preview__items--link glightbox" data-gallery="product-media-preview" href="{{ asset('assets/images/product/p5.jpg') }}"><img class="product__media--preview__items--img" src="{{ asset('assets/images/product/p5.jpg') }}" alt="product-media-img"></a>
                                        <div class="product__media--view__icon">
                                            <a class="product__media--view__icon--link glightbox" href="{{ asset('assets/images/product/p5.jpg') }}" data-gallery="product-media-preview">
                                                <svg class="product__media--view__icon--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="swiper-slide">
                                    <div class="product__media--preview__items">
                                        <a class="product__media--preview__items--link glightbox" data-gallery="product-media-preview" href="assets/images/product/big-product6.jpg"><img class="product__media--preview__items--img" src="assets/images/product/big-product6.jpg" alt="product-media-img"></a>
                                        <div class="product__media--view__icon">
                                            <a class="product__media--view__icon--link glightbox" href="assets/images/product/big-product6.jpg" data-gallery="product-media-preview">
                                                <svg class="product__media--view__icon--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                        <div class="product__media--nav swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="product__media--nav__items">
                                        <img class="product__media--nav__items--img" src="{{ asset('assets/images/product/p1.jpg') }}" alt="product-nav-img">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product__media--nav__items">
                                        <img class="product__media--nav__items--img" src="{{ asset('assets/images/product/p2.jpg') }}" alt="product-nav-img">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product__media--nav__items">
                                        <img class="product__media--nav__items--img" src="{{ asset('assets/images/product/p3.jpg') }}" alt="product-nav-img">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product__media--nav__items">
                                        <img class="product__media--nav__items--img" src="{{ asset('assets/images/product/p3.jpg') }}" alt="product-nav-img">
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product__media--nav__items">
                                        <img class="product__media--nav__items--img" src="{{ asset('assets/images/product/p3.jpg') }}" alt="product-nav-img">
                                    </div>
                                </div>
                                <!--<div class="swiper-slide">
                                    <div class="product__media--nav__items">
                                        <img class="product__media--nav__items--img" src="assets/images/product/small-product12.png" alt="product-nav-img">
                                    </div>
                                </div>-->
                            </div>
                            <div class="swiper__nav--btn swiper-button-next"></div>
                            <div class="swiper__nav--btn swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="quickview__info">
                        <form action="#">
                            <h2 class="product__details--info__title mb-15">Rhysley Rayon Red Kurti</h2>
                            <div class="product__details--info__price mb-10">
                                <span class="current__price">Rs.4200.00</span>
                                <span class="old__price">Rs.5000.00</span>
                            </div>
                            <div class="quickview__info--ratting d-flex align-items-center mb-10">
                                <ul class="rating d-flex justify-content-center">
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>
                                    <li class="rating__list">
                                        <span class="rating__list--icon">
                                            <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </li>

                                </ul>
                                <span class="quickview__info--review__text">(5 reviews)</span>
                            </div>
                            <p class="product__details--info__desc mb-15">
                                &bull; Designer print kurta.<br />
                                &bull; Be a picture of grace and beauty in this beautiful and elegant red Bandhej print kurta. With this red kurti for women, you would never fail to make an impression.
                            </p>
                            <div class="product__variant">
                                <div class="product__variant--list mb-10">
                                    <fieldset class="variant__input--fieldset">
                                        <legend class="product__variant--title mb-8">Color : Red</legend>
                                    </fieldset>
                                </div>
                                <div class="product__variant--list mb-15">
                                    <fieldset class="variant__input--fieldset weight">
                                        <legend class="product__variant--title mb-8">Size :</legend>
                                        <input id="weight1" name="weight" type="radio" checked>
                                        <label class="variant__size--value red" for="weight1">XS</label>
                                        <input id="weight2" name="weight" type="radio">
                                        <label class="variant__size--value red" for="weight2">S</label>
                                        <input id="weight3" name="weight" type="radio">
                                        <label class="variant__size--value red" for="weight3">M</label>
                                        <input id="weight4" name="weight" type="radio" checked>
                                        <label class="variant__size--value red" for="weight4">L</label>
                                        <input id="weight5" name="weight" type="radio">
                                        <label class="variant__size--value red" for="weight5">XL</label>
                                        <input id="weight6" name="weight" type="radio">
                                        <label class="variant__size--value red" for="weight6">XLL</label>
                                    </fieldset>
                                </div>
                                <div class="quickview__variant--list quantity d-flex align-items-center mb-15">
                                    <div class="quantity__box">
                                        <button type="button" class="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="Decrease Value">-</button>
                                        <label>
                                            <input type="number" class="quantity__number quickview__value--number" value="1" data-counter />
                                        </label>
                                        <button type="button" class="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="Increase Value">+</button>
                                    </div>

                                </div>
                                 <button class="primary__btn quickview__cart--btn" type="submit">Add To Cart</button>
                                 <button class="primary__btn quickview__cart--btn" type="submit">Buy It Now</button>
                                <div class="quickview__variant--list variant__wishlist mb-15">
                                    <a class="variant__wishlist--icon" href="{{ route('product.detail', 'rhysley-rayon-red-kurti') }}" title="Add to wishlist">
                                        View Full Details <i class="fa fa-arrow-right "></i>
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
