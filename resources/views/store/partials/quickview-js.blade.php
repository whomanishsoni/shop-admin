<script>
function loadQuickview(productSlug) {
    fetch(`/product/quickview/${productSlug}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const product = data.product;
            if (!product) {
                console.error('Product data is missing in response');
                return;
            }
            document.getElementById('quickview-name').textContent = product.name || 'N/A';
            document.getElementById('quickview-description').innerHTML = product.description || 'No description available';
            document.getElementById('quickview-product-slug').value = product.slug || '';
            document.getElementById('quickview-view-details').href = product.product_url || '#';

            let priceHTML = '';
            if (product.sale_price && product.sale_price < product.price) {
                priceHTML = `<span class="current__price">Rs. ${parseFloat(product.sale_price).toFixed(2)}</span>
                            <span class="old__price">Rs. ${parseFloat(product.price).toFixed(2)}</span>`;
            } else {
                priceHTML = `<span class="current__price">Rs. ${parseFloat(product.price).toFixed(2)}</span>`;
            }
            document.getElementById('quickview-price').innerHTML = priceHTML;

            let ratingHTML = '<ul class="rating d-flex justify-content-center">';
            for (let i = 1; i <= 5; i++) {
                ratingHTML += `<li class="rating__list">
                    <span class="rating__list--icon" style="color: ${i <= product.rating ? '#ffa500' : '#ddd'}">
                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                        </svg>
                    </span>
                </li>`;
            }
            ratingHTML += `</ul><span class="quickview__info--review__text">(${product.review_count} reviews)</span>`;
            document.getElementById('quickview-rating').innerHTML = ratingHTML;

            let slidesHTML = '';
            let thumbsHTML = '';
            if (product.images && product.images.length > 0) {
                product.images.forEach((image, index) => {
                    const isActive = index === 0;
                    slidesHTML += `
                        <div class="swiper-slide ${isActive ? 'swiper-slide-active' : ''}">
                            <div class="product__media--preview__items">
                                <a class="product__media--preview__items--link glightbox" data-gallery="product-media-preview" href="${image}">
                                    <img class="product__media--preview__items--img" src="${image}" alt="product-media-img">
                                </a>
                                <div class="product__media--view__icon">
                                    <a class="product__media--view__icon--link glightbox" href="${image}" data-gallery="product-media-preview">
                                        <svg class="product__media--view__icon--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                            <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>`;
                    thumbsHTML += `
                        <div class="swiper-slide ${isActive ? 'swiper-slide-thumb-active' : ''}">
                            <div class="product__media--nav__items" data-slide-index="${index}">
                                <img class="product__media--nav__items--img" src="${image}" alt="product-nav-img">
                            </div>
                        </div>`;
                });
            } else {
                slidesHTML = '<div>No images available</div>';
                thumbsHTML = '<div>No thumbnails available</div>';
            }
            document.getElementById('quickview-slides').innerHTML = slidesHTML;
            document.getElementById('quickview-thumbs').innerHTML = thumbsHTML;

            let variantsHTML = '';
            if (product.attributes && Object.keys(product.attributes).length > 0) {
                Object.keys(product.attributes).forEach(attrName => {
                    const values = product.attributes[attrName];
                    variantsHTML += `
                        <div class="product__variant--list mb-10">
                            <fieldset class="variant__input--fieldset">
                                <legend class="product__variant--title mb-8">${attrName}:</legend>
                                ${values.map((value, index) => `
                                    <input id="qv_${attrName}_${index}" name="${attrName.toLowerCase()}" type="radio" value="${value}" ${index === 0 ? 'checked' : ''}>
                                    <label class="variant__size--value red" for="qv_${attrName}_${index}">${value}</label>
                                `).join('')}
                            </fieldset>
                        </div>`;
                });
            } else {
                variantsHTML = '<div>No variants available</div>';
            }
            document.getElementById('quickview-variants').innerHTML = variantsHTML;

            if (typeof Swiper !== 'undefined') {
                const gallerySwiper = new Swiper('#quickview-gallery', {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    thumbs: {
                        swiper: {
                            el: '.product__media--nav',
                            slidesPerView: 4,
                        }
                    }
                });

                document.querySelectorAll('.product__media--nav__items').forEach(thumb => {
                    thumb.addEventListener('click', function() {
                        const slideIndex = parseInt(this.getAttribute('data-slide-index'));
                        gallerySwiper.slideTo(slideIndex);
                    });
                });
            } else {
                console.error('Swiper library is not loaded');
            }

            if (typeof GLightbox !== 'undefined') {
                const lightbox = GLightbox({
                    selector: '.glightbox',
                    touchNavigation: true,
                    loop: true,
                    zoomable: true,
                    draggable: true
                });
            } else {
                console.error('Glightbox library is not loaded');
            }
        } else {
            console.error('Quickview request failed:', data.message || 'Unknown error');
        }
    })
    .catch(error => console.error('Error loading quickview:', error));
}

document.getElementById('quickview-add-to-cart-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const variants = {};
    this.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
        if (radio.name !== '_token') {
            variants[radio.name] = radio.value;
        }
    });
    Object.keys(variants).forEach(key => { formData.append(key, variants[key]); });

    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.dispatchEvent(new Event('cart-updated'));
            document.querySelector('.close-modal').click();
        } else {
            console.error('Failed to add product to cart:', data.message || 'Unknown error');
        }
    })
    .catch(error => console.error('Error adding to cart:', error));
});

document.querySelectorAll('.quickview__value--quantity').forEach(btn => {
    btn.addEventListener('click', function() {
        const input = this.parentElement.querySelector('.quantity__number');
        const currentQty = parseInt(input.value);
        if (this.classList.contains('increase')) {
            input.value = currentQty + 1;
        } else if (this.classList.contains('decrease') && currentQty > 1) {
            input.value = currentQty - 1;
        }
        document.getElementById('quickview-quantity-input').value = input.value;
    });
});

function buyNow() {
    const form = document.getElementById('quickview-add-to-cart-form');
    const formData = new FormData(form);
    const variants = {};
    form.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
        if (radio.name !== '_token') {
            variants[radio.name] = radio.value;
        }
    });
    Object.keys(variants).forEach(key => { formData.append(key, variants[key]); });

    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.dispatchEvent(new Event('cart-updated'));
            document.querySelector('.close-modal').click();
            window.location.href = '{{ route("checkout") }}';
        } else {
            console.error('Failed to add product to cart:', data.message || 'Unknown error');
            alert('Failed to add product to cart. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error adding to cart:', error);
        alert('An error occurred. Please try again.');
    });
}
</script>
