@extends('store.layouts.app')

@section('title', 'Shipping Policy - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Shipping Policy</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Shipping Policy</span></li>
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
                        <h2 class="account__content--title h3 mb-20">Shipping Policy</h2>
                        <p>Vyuga is committed to delivering your orders efficiently. This Shipping Policy outlines our shipping procedures and estimated delivery times. Please read it carefully before placing an order.<br /><br />

                            <strong>Shipping Rates :</strong> Shipping charges are calculated at checkout based on your location and order value. We offer free shipping on orders above Rs. 999 within India. Additional charges may apply for international orders.<br /><br />

                            <strong>Processing Time :</strong> Orders are typically processed within 1-2 business days. Processing time may vary during sales or festive seasons.<br /><br />

                            <strong>Delivery Time :</strong> Standard delivery within India takes 3-7 business days, depending on your location. International shipping may take 10-20 business days. Delays may occur due to customs clearance or unforeseen circumstances.<br /><br />

                            <strong>Shipping Methods :</strong> We partner with reliable courier services to ensure safe delivery. You will receive a tracking number via email once your order is dispatched.<br /><br />

                            <strong>Non-Deliverable Areas :</strong> Vyuga reserves the right to cancel orders for remote or non-serviceable areas. You will be notified and refunded if applicable.<br /><br />

                            <strong>Damaged or Lost Shipments :</strong> If your order arrives damaged or is lost in transit, contact us at <a href="mailto:info@vyuga.in">info@vyuga.in</a> or +91-9876543210 within 7 days of the expected delivery date. We will investigate and arrange a replacement or refund.<br /><br />

                            <strong>Policy Updates :</strong> Vyuga may update this Shipping Policy as needed. Changes will be reflected on this page with an updated effective date.<br /><br />

                            For any shipping-related queries, contact us at:<br />
                            📧 Email: <a href="mailto:info@vyuga.in">info@vyuga.in</a> | 📞 Phone: <a href="tel:+919876543210">+91-9876543210</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
