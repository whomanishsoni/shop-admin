@extends('store.layouts.app')

@section('title', 'Refund Policy - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Refund Policy</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Refund Policy</span></li>
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
                        <h2 class="account__content--title h3 mb-20">Refund Policy</h2>
                        <p>At Vyuga, we strive to ensure your satisfaction with every purchase. This Refund Policy outlines the conditions under which you may be eligible for a refund. Please review it carefully before making a purchase.<br /><br />

                            <strong>Eligibility for Refunds :</strong> Refunds are available only for defective, damaged, or incorrect items received. Products must be returned within 7 days of delivery in their original condition—unused, unwashed, and with tags and packaging intact. Non-returnable items include sale products, personalized orders, and items marked as non-refundable.<br /><br />

                            <strong>Refund Process :</strong> To request a refund, contact us at <a href="mailto:info@vyuga.in">info@vyuga.in</a> or call +91-9876543210 within 7 days of delivery. Provide your order number and a brief description of the issue. Once approved, we will initiate a refund to your original payment method within 7-10 business days after receiving the returned item.<br /><br />

                            <strong>Non-Refundable Cases :</strong> Refunds will not be issued for change of mind, incorrect size selection, or items damaged due to improper handling after delivery. Shipping costs are non-refundable unless the error is on our part.<br /><br />

                            <strong>Exchanges :</strong> If you prefer an exchange instead of a refund, we will replace the item with an available equivalent, subject to stock availability. Exchange requests follow the same 7-day return window.<br /><br />

                            <strong>Policy Updates :</strong> Vyuga reserves the right to modify this Refund Policy at any time. Changes will be posted on this page with an updated effective date.<br /><br />

                            For any questions or assistance, contact us at:<br />
                            📧 Email: <a href="mailto:info@vyuga.in">info@vyuga.in</a> | 📞 Phone: <a href="tel:+919876543210">+91-9876543210</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
