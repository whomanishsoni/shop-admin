@extends('store.layouts.app')

@section('title', 'Checkout - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg" style="background: url({{ asset('assets/images/checkout-banner.jpg') }});">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Checkout</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Checkout</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="cart__section section--padding">
            <div class="container-fluid">
                <div class="row cart__section--inner">
                    <div class="col-lg-8">
                        @if(!$cartSummary['defaultAddress'])
                            <div id="addressWarning" class="alert alert-warning">Please add at least one address to proceed with checkout.</div>
                        @endif
                        <form action="{{ route('checkout.saveAddress') }}" method="POST" id="checkoutForm">
                            @csrf

                            <div class="checkout__content--step section__contact--information">
                                <div class="section__header checkout__section--header d-flex align-items-center justify-content-between mb-25">
                                    <h2 class="section__header--title h3">Contact information</h2>
                                </div>

                                <div class="checkout__content--step section__shipping--address pt-10">
                                    <div class="checkout__content--step__inner3 border-radius-5">
                                        <div class="checkout__address--content__header">
                                            <div class="row customer__information--list" style="width:100%">
                                                <div class="col-lg-6 mb-12 customer__information--step">
                                                    <h4 class="customer__information--subtitle h5">Billing Address</h4>
                                                    <ul>
                                                        @if($cartSummary['defaultAddress'])
                                                            <li><span class="customer__information--text">{{ $cartSummary['defaultAddress']->name }}</span></li>
                                                            <li><span class="customer__information--text">{{ $cartSummary['defaultAddress']->address }}</span></li>
                                                            <li><span class="customer__information--text">{{ $cartSummary['defaultAddress']->city }},</span></li>
                                                            <li><span class="customer__information--text">{{ $cartSummary['defaultAddress']->state ?? '' }} - {{ $cartSummary['defaultAddress']->pincode }}</span></li>
                                                        @else
                                                            <li><span class="customer__information--text">Please fill below</span></li>
                                                            <li><span class="customer__information--text">Address details</span></li>
                                                            <li><span class="customer__information--text">to continue</span></li>
                                                            <li><span class="customer__information--text">& checkout</span></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                <div class="col-lg-6 mb-12 customer__information--step">
                                                    <h4 class="customer__information--subtitle h5">Shipping Address</h4>
                                                    <ul>
                                                        @if(Session::has('checkout_address') && isset(Session::get('checkout_address')['shipping']) && Session::get('checkout_address')['shipping'] !== Session::get('checkout_address')['billing'])
                                                            <li><span class="customer__information--text">{{ Session::get('checkout_address')['shipping']['name'] }}</span></li>
                                                            <li><span class="customer__information--text">{{ Session::get('checkout_address')['shipping']['address'] }}</span></li>
                                                            <li><span class="customer__information--text">{{ Session::get('checkout_address')['shipping']['city'] }},</span></li>
                                                            <li><span class="customer__information--text">{{ Session::get('checkout_address')['shipping']['state'] ?? '' }} - {{ Session::get('checkout_address')['shipping']['pincode'] }}</span></li>
                                                        @elseif($cartSummary['defaultAddress'])
                                                            <li><span class="customer__information--text">{{ $cartSummary['defaultAddress']->name }}</span></li>
                                                            <li><span class="customer__information--text">{{ $cartSummary['defaultAddress']->address }}</span></li>
                                                            <li><span class="customer__information--text">{{ $cartSummary['defaultAddress']->city }},</span></li>
                                                            <li><span class="customer__information--text">{{ $cartSummary['defaultAddress']->state ?? '' }} - {{ $cartSummary['defaultAddress']->pincode }}</span></li>
                                                        @else
                                                            <li><span class="customer__information--text">Please fill below</span></li>
                                                            <li><span class="customer__information--text">Address details</span></li>
                                                            <li><span class="customer__information--text">to continue</span></li>
                                                            <li><span class="customer__information--text">& checkout</span></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="shipping__contact--box__list" style="border-top:1px solid #ccc">
                                                <div class="shipping__radio--input">
                                                    <input class="shipping__radio--input__field" id="radiobox" name="checkmethod" type="radio" {{ old('checkmethod', 'same') === 'same' ? 'checked' : '' }} value="same">
                                                </div>
                                                <label class="shipping__radio--label" for="radiobox">
                                                    <span class="shipping__radio--label__primary">Same as billing address</span>
                                                </label>
                                            </div>
                                            <div class="shipping__contact--box__list">
                                                <div class="shipping__radio--input">
                                                    <input class="shipping__radio--input__field" id="radiobox2" name="checkmethod" type="radio" {{ old('checkmethod') === 'different' ? 'checked' : '' }} value="different">
                                                </div>
                                                <label class="shipping__radio--label" for="radiobox2">
                                                    <span class="shipping__radio--label__primary">Use a different shipping address</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="checkout__content--input__box--wrapper">
                                            <div class="row" id="shippingAddressFields">
                                                <div class="col-lg-6 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5 @error('first_name') is-invalid @enderror"
                                                                   name="first_name" id="first_name"
                                                                   value="{{ old('first_name') }}"
                                                                   placeholder="First name" type="text">
                                                        </label>
                                                        @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5 @error('last_name') is-invalid @enderror"
                                                                   name="last_name" id="last_name"
                                                                   value="{{ old('last_name') }}"
                                                                   placeholder="Last name" type="text" required>
                                                        </label>
                                                        @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5"
                                                                   name="company" id="company"
                                                                   value="{{ old('company') }}"
                                                                   placeholder="Company (optional)" type="text">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5 @error('address1') is-invalid @enderror"
                                                                   name="address1" id="address1"
                                                                   value="{{ old('address1') }}"
                                                                   placeholder="Address1" type="text" required>
                                                        </label>
                                                        @error('address1') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5"
                                                                   name="address2" id="address2"
                                                                   value="{{ old('address2') }}"
                                                                   placeholder="Apartment, suite, etc. (optional)" type="text">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5 @error('city') is-invalid @enderror"
                                                                   name="city" id="city"
                                                                   value="{{ old('city') }}"
                                                                   placeholder="City" type="text" required>
                                                        </label>
                                                        @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-12">
                                                    <div class="checkout__input--list checkout__input--select select">
                                                        <label class="checkout__select--label" for="country">Country/region</label>
                                                        <select class="checkout__input--select__field border-radius-5" id="country" name="country" required>
                                                            <option value="India" selected>India</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5 @error('postal_code') is-invalid @enderror"
                                                                   name="postal_code" id="postal_code"
                                                                   value="{{ old('postal_code') }}"
                                                                   placeholder="Postal code" type="text" required>
                                                        </label>
                                                        @error('postal_code') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__content--step__footer d-flex align-items-center">
                                <button type="submit" class="continue__shipping--btn primary__btn border-radius-5">Continue to Shipping</button>
                                <a class="previous__link--content" href="{{ route('shop') }}">Return to Shop</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart__summary border-radius-10">
                            <div class="cart__table checkout__product--table">
                                <table class="cart__table--inner">
                                    <tbody class="cart__table--body">
                                        @foreach($cartSummary['items'] as $cartKey => $item)
                                        <tr class="cart__table--body__items">
                                            <td class="cart__table--body__list">
                                                <div class="product__image two d-flex align-items-center">
                                                    <div class="product__thumbnail border-radius-5">
                                                        <a href="{{ route('product.detail', $item['slug']) }}"><img class="border-radius-5" src="{{ $item['image'] }}" alt="{{ $item['name'] }}"></a>
                                                        <span class="product__thumbnail--quantity">{{ $item['quantity'] }}</span>
                                                    </div>
                                                    <div class="product__description">
                                                        <h3 class="product__description--name h4"><a href="{{ route('product.detail', $item['slug']) }}">{{ $item['name'] }}</a></h3>
                                                        @if(!empty($item['attributes']))
                                                            @foreach($item['attributes'] as $key => $value)
                                                                <span class="product__description--variant text-black">{{ strtoupper($key) }}: {{ $value }}</span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <span class="cart__price">Rs. {{ number_format($item['total'], 2) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="coupon__code mb-30">
                                <h3 class="coupon__code--title">Coupon Apply</h3>
                                <form action="{{ route('checkout.applyCoupon') }}" method="POST" class="coupon__code--field d-flex" id="couponForm">
                                    @csrf
                                    <label>
                                        <input class="coupon__code--field__input border-radius-5"
                                               name="coupon_code"
                                               placeholder="Coupon code"
                                               value="{{ $cartSummary['couponCode'] }}"
                                               type="text">
                                    </label>
                                    <button class="coupon__code--field__btn primary__btn" type="submit">
                                        {{ $cartSummary['couponCode'] ? 'Change' : 'Apply Coupon' }}
                                    </button>
                                    @if($cartSummary['couponCode'])
                                        <button type="button" class="coupon__code--field__btn primary__btn ms-2" id="clearCoupon">Clear</button>
                                    @endif
                                </form>
                                <div id="couponMessage" class="mt-2"></div>
                            </div>
                            <div class="cart__summary--total mb-20">
                                <table class="cart__summary--total__table">
                                    <tbody>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">SUBTOTAL</td>
                                            <td class="cart__summary--amount text-right">Rs. {{ number_format($cartSummary['subtotal'], 2) }}</td>
                                        </tr>
                                        @if($cartSummary['couponDiscount'] > 0)
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left text-success">COUPON</td>
                                            <td class="cart__summary--amount text-right text-success">-Rs. {{ number_format($cartSummary['couponDiscount'], 2) }}</td>
                                        </tr>
                                        @endif
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">Shipping Fee</td>
                                            <td class="cart__summary--amount text-right">Rs. {{ number_format($cartSummary['shipping'], 2) }}</td>
                                        </tr>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">Tax(18%)</td>
                                            <td class="cart__summary--amount text-right">Rs. {{ number_format($cartSummary['tax'], 2) }}</td>
                                        </tr>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left"><strong>GRAND TOTAL</strong></td>
                                            <td class="cart__summary--amount text-right"><strong>Rs. {{ number_format($cartSummary['grandTotal'], 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart__summary--footer">
                                <form action="{{ route('checkout.createOrderAndPayment') }}" method="POST" id="payNowForm" @if(!$cartSummary['defaultAddress']) class="disabled-form" @endif>
                                    @csrf
                                    <button type="submit" class="primary__btn checkout border-radius-5 w-100 {{ !$cartSummary['defaultAddress'] ? 'disabled' : '' }}"
                                            @if(!$cartSummary['defaultAddress']) onclick="event.preventDefault(); alert('Please add at least one default address to proceed.')" @endif
                                            style="width: 100% !important;">
                                        Proceed To Payment
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }

            const addressWarning = document.getElementById('addressWarning');
            if (addressWarning) {
                setTimeout(() => addressWarning.style.display = 'none', 5000);
            }

            const errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                setTimeout(() => errorMessage.style.display = 'none', 5000);
            }

            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => successMessage.style.display = 'none', 5000);
            }

            const payNowButton = document.querySelector('.cart__summary--footer__btn.checkout');
            if (payNowButton) {
                payNowButton.addEventListener('click', function(e) {
                    if (this.classList.contains('disabled')) {
                        e.preventDefault();
                        alert('Please add at least one default address to proceed.');
                    }
                });
            }

            const checkoutForm = document.querySelector('#checkoutForm');
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function(e) {
                    const sameAsBilling = document.getElementById('radiobox');
                    const differentShipping = document.getElementById('radiobox2');
                    const shippingFields = document.querySelectorAll('#shippingAddressFields input, #shippingAddressFields select');

                    if (differentShipping.checked) {
                        let isValid = true;
                        shippingFields.forEach(field => {
                            if (field.required && !field.value.trim()) {
                                isValid = false;
                            }
                        });
                        if (!isValid) {
                            e.preventDefault();
                            alert('Please fill all required shipping address fields.');
                        }
                    }
                });
            }

            const sameAsBilling = document.getElementById('radiobox');
            const differentShipping = document.getElementById('radiobox2');
            const shippingFields = document.querySelectorAll('#shippingAddressFields input, #shippingAddressFields select');

            function toggleShippingFields() {
                const isDifferent = differentShipping.checked;
                shippingFields.forEach(field => {
                    field.closest('.checkout__input--list').style.display = isDifferent ? 'block' : 'none';
                    field.required = isDifferent;
                    if (isDifferent) {
                        field.value = '';
                    }
                });
            }

            if (differentShipping) {
                differentShipping.addEventListener('change', toggleShippingFields);
                sameAsBilling.addEventListener('change', toggleShippingFields);
                toggleShippingFields();
            }

            const couponForm = document.getElementById('couponForm');
            const couponMessage = document.getElementById('couponMessage');

            if (couponForm) {
                couponForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const button = this.querySelector('button[type="submit"]');
                    const couponInput = this.querySelector('input[name="coupon_code"]');
                    const clearButton = this.querySelector('#clearCoupon');
                    couponMessage.innerHTML = '';
                    fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            button.textContent = 'Change';
                            couponMessage.innerHTML = `
                                <div class="alert alert-success p-2 mb-0">
                                    <div class="d-flex align-items-center">
                                        <span class="fs-4 me-2">🎉</span>
                                        <div>
                                            <strong><span class="text-uppercase">${couponInput.value}</span> APPLIED SUCCESSFULLY!</strong><br>
                                        </div>
                                    </div>
                                </div>
                            `;
                            if (!clearButton) {
                                couponForm.insertAdjacentHTML('beforeend', '<button type="button" class="coupon__code--field__btn primary__btn ms-2" id="clearCoupon">Clear</button>');
                            }
                            setTimeout(() => {
                                couponMessage.innerHTML = '';
                            }, 5000);
                            updateCartTotals(data);
                        } else {
                            couponMessage.innerHTML = '<div class="alert alert-danger p-2 mb-0">' + (data.message || 'Invalid coupon code. Please try again.') + '</div>';
                            setTimeout(() => {
                                couponMessage.innerHTML = '';
                            }, 4000);
                        }
                    })
                    .catch(error => {
                        couponMessage.innerHTML = '<div class="alert alert-danger p-2 mb-0">An error occurred. Please try again.</div>';
                        setTimeout(() => {
                            couponMessage.innerHTML = '';
                        }, 4000);
                    });
                });

                couponForm.addEventListener('click', function(e) {
                    if (e.target.id === 'clearCoupon') {
                        e.preventDefault();
                        couponMessage.innerHTML = '';
                        fetch('{{ route('checkout.removeCoupon') }}', {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const button = couponForm.querySelector('button[type="submit"]');
                                const couponInput = couponForm.querySelector('input[name="coupon_code"]');
                                const clearButton = couponForm.querySelector('#clearCoupon');
                                couponInput.value = '';
                                button.textContent = 'Apply Coupon';
                                couponMessage.innerHTML = '<div class="alert alert-info p-2 mb-0">Coupon removed successfully.</div>';
                                setTimeout(() => {
                                    couponMessage.innerHTML = '';
                                }, 3000);
                                if (clearButton) clearButton.remove();
                                if (data.updated_totals) {
                                    updateCartTotals(data.updated_totals);
                                }
                            }
                        })
                        .catch(error => {
                            couponMessage.innerHTML = '<div class="alert alert-danger p-2 mb-0">Error removing coupon. Please try again.</div>';
                            setTimeout(() => {
                                couponMessage.innerHTML = '';
                            }, 3000);
                        });
                    }
                });
            }

            function updateCartTotals(data) {
                const subtotalElements = document.querySelectorAll('.cart__summary--total__table tbody tr:first-child td:last-child');
                if (subtotalElements.length > 0 && data.subtotal) {
                    subtotalElements[0].textContent = 'Rs. ' + data.subtotal;
                }
                let couponRow = document.querySelector('.cart__summary--total__table tbody tr:nth-child(2)');
                if (data.discount_amount && parseFloat(data.discount_amount) > 0) {
                    if (!couponRow || !couponRow.querySelector('.text-success')) {
                        const subtotalRow = document.querySelector('.cart__summary--total__table tbody tr:first-child');
                        const newRow = document.createElement('tr');
                        newRow.className = 'cart__summary--total__list';
                        newRow.innerHTML = `
                            <td class="cart__summary--total__title text-left text-success">COUPON</td>
                            <td class="cart__summary--amount text-right text-success">-Rs. ${data.discount_amount}</td>
                        `;
                        subtotalRow.parentNode.insertBefore(newRow, subtotalRow.nextSibling);
                    } else {
                        couponRow.querySelector('td:last-child').textContent = '-Rs. ' + data.discount_amount;
                    }
                } else {
                    if (couponRow && couponRow.querySelector('.text-success')) {
                        couponRow.remove();
                    }
                }
                const taxElements = document.querySelectorAll('.cart__summary--total__table tbody tr:nth-last-child(2) td:last-child');
                if (taxElements.length > 0 && data.tax) {
                    taxElements[0].textContent = 'Rs. ' + data.tax;
                }
                const totalElements = document.querySelectorAll('.cart__summary--total__table tbody tr:last-child td:last-child');
                if (totalElements.length > 0 && data.total) {
                    totalElements[0].innerHTML = '<strong>Rs. ' + data.total + '</strong>';
                }
            }
        });
    </script>
@endpush
