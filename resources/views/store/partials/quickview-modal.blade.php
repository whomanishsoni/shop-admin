<div class="modal" id="modal1" data-animation="slideInUp">
    <div class="modal-dialog quickview__main--wrapper">
        <header class="modal-header quickview__header">
            <button class="close-modal quickview__close--btn" aria-label="close modal" data-close>✕ </button>
        </header>
        <div class="quickview__inner" id="quickview-content">
            <div class="row row-cols-lg-2 row-cols-md-2">
                <div class="col">
                    <div class="quickview__product--media product__details--media">
                        <div class="product__media--preview swiper" id="quickview-gallery">
                            <div class="swiper-wrapper" id="quickview-slides">
                                <!-- Main image will be loaded here -->
                            </div>
                        </div>
                        <div class="product__media--nav swiper">
                            <div class="swiper-wrapper" id="quickview-thumbs">
                                <!-- Thumbnails will be loaded here -->
                            </div>
                            <div class="swiper__nav--btn swiper-button-next"></div>
                            <div class="swiper__nav--btn swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="quickview__info">
                        <form id="quickview-add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" id="quickview-product-slug">
                            <input type="hidden" name="quantity" value="1" id="quickview-quantity-input">

                            <h2 class="product__details--info__title mb-15" id="quickview-name">Loading...</h2>
                            <div class="product__details--info__price mb-10" id="quickview-price">
                                <span class="current__price">Rs.0.00</span>
                                <span class="old__price"></span>
                            </div>
                            <div class="quickview__info--ratting d-flex align-items-center mb-10" id="quickview-rating">
                                <!-- Rating will be loaded here -->
                            </div>
                            <p class="product__details--info__desc mb-15" id="quickview-description">
                                Loading product details...
                            </p>
                            <div class="product__variant" id="quickview-variants">
                                <!-- Variants will be loaded here dynamically -->
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
                            <button class="primary__btn quickview__cart--btn" type="button" onclick="buyNow()">Buy It Now</button>
                            <div class="quickview__variant--list variant__wishlist mb-15">
                                <a class="variant__wishlist--icon" href="#" id="quickview-view-details">
                                    View Full Details <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
