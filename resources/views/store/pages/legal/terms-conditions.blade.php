@extends('store.layouts.app')

@section('title', 'Terms & Conditions - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Term & Conditions</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Term & Conditions</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="my__account--section section--padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="account__content--title h3 mb-20">Term & Conditions</h2>
                        <p>Welcome to Vyuga. By accessing or using our website (the “Site”) and purchasing products from our online store, you agree to comply with and be bound by these Terms & Conditions. Please read them carefully before placing an order.<br /><br />

                            <strong>General :</strong> Vyuga is an online fashion e-commerce portal offering women’s clothing, including kurtis, tops, and other apparel. By using our Site, you confirm that you are at least 18 years old or have parental/guardian consent to make purchases.<br /><br />

                            <strong>Product Information :</strong> We strive to ensure that all product descriptions, images, and prices are accurate. However, slight variations in color, fabric, or design may occur due to photography or display settings. Vyuga reserves the right to modify or discontinue products without prior notice.<br /><br />

                            <strong>Orders & Payments :</strong> All orders placed on the Site are subject to acceptance and availability. Prices are listed in INR and include applicable taxes unless otherwise stated. Payment must be made in full via our secure payment gateways before your order is processed.<br /><br />

                            <strong>Shipping & Delivery :</strong> We aim to dispatch orders promptly. Delivery times may vary depending on your location and courier services. Vyuga is not responsible for delays beyond our control.<br /><br />

                            <strong>Returns & Exchanges :</strong> We accept returns and exchanges only if the product is unused, unwashed, and in its original packaging with tags intact. Requests must be made within 7 days of delivery. Certain items, such as sale products or personalized orders, are non-returnable. Please refer to our Return Policy for complete details.<br /><br />

                            <strong>Intellectual Property :</strong> All content on the Site, including images, text, graphics, and logos, is the property of Vyuga and is protected by copyright laws. Unauthorized use is strictly prohibited.<br /><br />

                            <strong>Limitation of Liability :</strong> Vyuga is not liable for any indirect, incidental, or consequential damages arising from the use of our Site or products.<br /><br />

                            <strong>Governing Law :</strong> These Terms & Conditions are governed by the laws of India. Any disputes shall be subject to the exclusive jurisdiction of the courts in Hyderabad, Telangana.<br /><br />

                            <strong>Contact Us :</strong> For any questions regarding this policy, contact us at:<br />
                            📧 Email: <a href="mailto:info@vyuga.in">info@vyuga.in</a> | 📞 Phone: <a href="tel:+919876543210">+91-9876543210</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
