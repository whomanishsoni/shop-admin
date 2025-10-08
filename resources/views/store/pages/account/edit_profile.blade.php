@extends('store.layouts.app')

@section('title', 'Edit Profile - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Account</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Edit Profile</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="my__account--section section--padding">
            <div class="container">
                <p class="account__welcome--text">Hello, Guest! Welcome to your dashboard!</p>
                <div class="my__account--section__inner border-radius-10 d-flex">
                    <div class="account__left--sidebar">
                        <h2 class="account__content--title h3 mb-20">My Account</h2>
                        <ul class="account__menu">
                            <li class="account__menu--list {{ request()->routeIs('profile') ? 'active' : '' }}"><a href="{{ route('profile') }}" class="account__menu--link">My Profile</a></li>
                            <li class="account__menu--list {{ request()->routeIs('editProfile') ? 'active' : '' }}"><a href="{{ route('editProfile') }}" class="account__menu--link">Edit Profile</a></li>
                            <li class="account__menu--list {{ request()->routeIs('orders') ? 'active' : '' }}"><a href="{{ route('orders') }}" class="account__menu--link">My Order</a></li>
                            <li class="account__menu--list {{ request()->routeIs('wishlist') ? 'active' : '' }}"><a href="{{ route('wishlist') }}" class="account__menu--link">Wishlist</a></li>
                            <li class="account__menu--list {{ request()->routeIs('addresses') ? 'active' : '' }}"><a href="{{ route('addresses') }}" class="account__menu--link">Addresses</a></li>
                            <li class="account__menu--list {{ request()->routeIs('logout') ? 'active' : '' }}">
                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="account__menu--link" onclick="this.closest('form').submit(); return false;">Log Out</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="account__wrapper">
                        <div class="account__content">
                            <h2 class="account__content--title h3 mb-20">Edit Profile</h2>
                            <div class="account__content">
                                <div class="row account__table--area">
                                    @foreach ($profileData as $data)
                                        <div class="col-lg-6 col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>Name : </label>
                                                <input class="checkout__input--field border-radius-5 form-control" value="{{ $data['name'] }}" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-6 mb-12">
                                            <div class="checkout__input--list">
                                                <label>Email-Id : </label>
                                                <input class="checkout__input--field border-radius-5 form-control" value="{{ $data['email'] }}" type="email" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>Contact No. : </label>
                                                <input class="checkout__input--field border-radius-5 form-control" value="{{ $data['contact_no'] }}" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>Alt. Contact No. : </label>
                                                <input class="checkout__input--field border-radius-5 form-control" value="{{ $data['alt_contact_no'] }}" type="tel" name="alt_contact_no">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>Address : </label>
                                                <textarea class="checkout__input--field border-radius-5 form-control" rows="1" name="address">{{ $data['address'] }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-6 mb-12">
                                            <div class="checkout__input--list">
                                                <label>
                                                    <input class="checkout__input--field border-radius-5" placeholder="City" type="text" name="city" value="{{ $data['city'] }}">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-12">
                                            <div class="checkout__input--list checkout__input--select select">
                                                <label class="checkout__select--label" for="country">Country/region</label>
                                                <select class="checkout__input--select__field border-radius-5" id="country" name="country">
                                                    <option value="India" {{ $data['country'] === 'India' ? 'selected' : '' }}>India</option>
                                                    <option value="United States">United States</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Islands">Islands</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Antigua Barbuda">Antigua Barbuda</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-12">
                                            <div class="checkout__input--list checkout__input--select select">
                                                <label class="checkout__select--label" for="state">State</label>
                                                <select class="checkout__input--select__field border-radius-5" id="state" name="state">
                                                    <option value="Telangana" {{ $data['state'] === 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Delhi">Delhi</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>
                                                    <input class="checkout__input--field border-radius-5" placeholder="Postal code" type="text" name="postal_code" value="{{ $data['postal_code'] }}">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-12">
                                            <div class="checkout__input--list">
                                                <a class="wishlist__cart--btn primary__btn" href="{{ route('profile') }}">Update</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-12">
                                            <div class="checkout__input--list">
                                                <button class="like-btn" data-profile-id="1" style="background:none;border:none;cursor:pointer;">
                                                    <span class="heart-icon" style="color: {{ $data['liked'] ? '#ff0000' : '#ccc' }};">&#9829;</span>
                                                </button>
                                                <span>Like this profile?</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                const heart = this.querySelector('.heart-icon');
                const isLiked = heart.style.color === 'rgb(255, 0, 0)';
                heart.style.color = isLiked ? '#ccc' : '#ff0000';
            });
        });
    </script>
@endpush
