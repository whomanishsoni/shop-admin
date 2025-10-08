@extends('store.layouts.app')

@section('title', 'Privacy Policy - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Privacy Policy</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Privacy Policy</span></li>
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
                        <h2 class="account__content--title h3 mb-20">Privacy Policy</h2>
                        <p>At Vyuga, we value your privacy and are committed to safeguarding your personal information. This Privacy Policy outlines how we collect, use, and protect the data you share when you visit or shop on our online fashion store. By using our website, you agree to the practices described below.<br /><br />
                            <strong>Information We Collect :</strong> When you browse or make a purchase on our website, we may collect personal details such as your name, email address, phone number, shipping/billing address, and payment details. We also gather non-personal information like your IP address, browser type, and browsing patterns to improve your shopping experience.<br /><br />

                            <strong>How We Use Your Information :</strong> Your information is used to:<br />
                            <br />&bull; Process and fulfill your orders efficiently.
                            <br />&bull; Send order updates, invoices, and shipping details.
                            <br />&bull; Share promotional offers, discounts, and new arrivals (only if you subscribe to our newsletter).
                            <br />&bull; Personalize your shopping experience based on preferences and browsing history.
                            <br />&bull; Improve website functionality and product offerings.<br /><br />

                            <strong>Data Security :</strong> We take your security seriously. All payment transactions are processed through secure payment gateways using encryption technologies. We also use firewalls, SSL protection, and strict data access controls to prevent unauthorized access.<br /><br />

                            <strong>Cookies and Tracking :</strong> Our website uses cookies to store preferences, remember items in your cart, and provide personalized recommendations. You can choose to disable cookies in your browser settings, but certain features of the site may not function properly.<br /><br />

                            <strong>Third-Party Sharing :</strong> We do not sell, rent, or trade your personal information. However, we may share necessary details with trusted partners such as delivery services, payment processors, and marketing platforms strictly to fulfill orders or improve services.<br /><br />

                            <strong>Your Rights :</strong> You can request to access, update, or delete your personal data at any time. You may also unsubscribe from promotional communications by clicking the “Unsubscribe” link in our emails.<br /><br />

                            <strong>Policy Updates :</strong> We may update this Privacy Policy periodically to reflect changes in our practices. All updates will be posted on this page with the revised effective date.
                            <br /><br />
                            For any questions regarding this policy, contact us at:
                            📧 Email: <a href="mailto:info@vyuga.in">info@vyuga.in</a> | 📞 Phone: <a href="tel:+919876543210">+91-9876543210</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
