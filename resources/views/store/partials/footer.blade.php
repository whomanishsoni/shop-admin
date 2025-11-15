<!-- Footer Blade File: resources/views/store/partials/footer.blade.php -->
<footer class="footer__section">
    <div class="container-fluid-2">
        <div class="main__footer">
            <div class="row">
                <!-- About Us -->
                <div class="col-lg-3 col-md-5">
                    <div class="footer__widget">
                        <h2 class="footer__widget--title h3">About Us
                            <button class="footer__widget--button style3" aria-label="footer widget button">
                                <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                    <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                </svg>
                            </button>
                        </h2>
                        <div class="footer__widget--inner">
                            @if (!empty($settings['footer_logo']))
                                <img src="{{ asset('storage/' . $settings['footer_logo']) }}" alt="{{ $settings['site_name'] ?? 'Waseem Fashion Studio' }} Logo" class="footer__logo mb-20" style="height: 100px;">
                            @else
                                <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $settings['site_name'] ?? 'Waseem Fashion Studio' }} Logo" class="footer__logo mb-20" style="height: 50px;">
                            @endif
                            <p class="footer__widget--desc style3 mb-20">
                                {{ $settings['site_description'] ?? 'We are an online clothing destination dedicated to bringing you stylish, high-quality women’s wear with a special focus on kurtis and tops that blend comfort with trend-setting designs.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Our Collections -->
                <div class="col-lg-2 col-md-4">
                    <div class="footer__widget">
                        <h2 class="footer__widget--title h3">Our Collections
                            <button class="footer__widget--button style3" aria-label="footer widget button">
                                <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                    <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                </svg>
                            </button>
                        </h2>
                        <ul class="footer__widget--menu footer__menu--style3 footer__widget--inner">
                            @foreach ($categories as $category)
                                @if ($category->subcategories->count() > 0)
                                    @foreach ($category->subcategories->take(5) as $subcategory)
                                        <li class="footer__widget--menu__list">
                                            <a class="footer__widget--menu__text" href="{{ route('shop', $subcategory->slug) }}">{{ $subcategory->name }}</a>
                                        </li>
                                    @endforeach
                                    @if ($category->subcategories->count() > 5)
                                        <li class="footer__widget--menu__list">
                                            <a class="footer__widget--menu__text see-more" href="{{ route('shop', $category->slug) }}">+{{ $category->subcategories->count() - 5 }} more</a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Categories -->
                <div class="col-lg-2 col-md-3">
                    <div class="footer__widget">
                        <h2 class="footer__widget--title h3">Categories
                            <button class="footer__widget--button style3" aria-label="footer widget button">
                                <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                    <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                </svg>
                            </button>
                        </h2>
                        <ul class="footer__widget--menu footer__menu--style3 footer__widget--inner">
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('about') }}">About Us</a></li>
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('contact') }}">Contact Us</a></li>
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('refund-policy') }}">Refund Policy</a></li>
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('terms-conditions') }}">Term & Conditions</a></li>
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('shipping-policy') }}">Shipping Policy</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="col-lg-2 col-md-5">
                    <div class="footer__widget">
                        <h2 class="footer__widget--title h3">Social Media
                            <button class="footer__widget--button style3" aria-label="footer widget button">
                                <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                    <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                </svg>
                            </button>
                        </h2>
                        <div class="footer__widget--inner footer__social--style3">
                            <ul class="social__shear">
                                @if (!empty($settings['facebook_url']))
                                    <li class="social__shear--list">
                                        <a class="social__shear--list__icon" target="_blank" href="{{ $settings['facebook_url'] }}">
                                            <span class="footer__social--icon__svg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8.667" height="18.524" viewBox="0 0 7.667 16.524">
                                                    <path data-name="Path 237" d="M967.495,353.678h-2.3v8.253h-3.437v-8.253H960.13V350.77h1.624v-1.888a4.087,4.087,0,0,1,.264-1.492,2.9,2.9,0,0,1,1.039-1.379,3.626,3.626,0,0,1,2.153-.6l2.549.019v2.833h-1.851a.732.732,0,0,0-.472.151.8.8,0,0,0-.246.642v1.719H967.8Z" transform="translate(-960.13 -345.407)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <span class="social__shear--title">Facebook</span>
                                        </a>
                                    </li>
                                @endif
                                @if (!empty($settings['twitter_url']))
                                    <li class="social__shear--list">
                                        <a class="social__shear--list__icon" target="_blank" href="{{ $settings['twitter_url'] }}">
                                            <span class="footer__social--icon__svg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18.489" height="15.384" viewBox="0 0 16.489 13.384">
                                                    <path data-name="Path 303" d="M966.025,1144.2v.433a9.783,9.783,0,0,1-.621,3.388,10.1,10.1,0,0,1-1.845,3.087,9.153,9.153,0,0,1-3.012,2.259,9.825,9.825,0,0,1-4.122.866,9.632,9.632,0,0,1-2.748-.4,9.346,9.346,0,0,1-2.447-1.11q.4.038.809.038a6.723,6.723,0,0,0,2.24-.376,7.022,7.022,0,0,0,1.958-1.054,3.379,3.379,0,0,1-1.958-.687,3.259,3.259,0,0,1-1.186-1.666,3.364,3.364,0,0,0,.621.056,3.488,3.488,0,0,0,.885-.113,3.267,3.267,0,0,1-1.374-.631,3.356,3.356,0,0,1-.969-1.186,3.524,3.524,0,0,1-.367-1.5v-.057a3.172,3.172,0,0,0,1.544.433,3.407,3.407,0,0,1-1.1-1.214,3.308,3.308,0,0,1-.4-1.609,3.362,3.362,0,0,1,.452-1.694,9.652,9.652,0,0,0,6.964,3.538,3.911,3.911,0,0,1-.075-.772,3.293,3.293,0,0,1,.452-1.694,3.409,3.409,0,0,1,1.233-1.233,3.257,3.257,0,0,1,1.685-.461,3.351,3.351,0,0,1,2.466,1.073,6.572,6.572,0,0,0,2.146-.828,3.272,3.272,0,0,1-.574,1.083,3.477,3.477,0,0,1-.913.8,6.869,6.869,0,0,0,1.958-.546A7.074,7.074,0,0,1,966.025,1144.2Z" transform="translate(-951.23 -1140.849)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <span class="social__shear--title">Twitter</span>
                                        </a>
                                    </li>
                                @endif
                                @if (!empty($settings['instagram_url']))
                                    <li class="social__shear--list">
                                        <a class="social__shear--list__icon" target="_blank" href="{{ $settings['instagram_url'] }}">
                                            <span class="footer__social--icon__svg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18.497" height="18.492" viewBox="0 0 19.497 19.492">
                                                    <path data-name="Icon awesome-instagram" d="M9.747,6.24a5,5,0,1,0,5,5A4.99,4.99,0,0,0,9.747,6.24Zm0,8.247A3.249,3.249,0,1,1,13,11.238a3.255,3.255,0,0,1-3.249,3.249Zm6.368-8.451A1.166,1.166,0,1,1,14.949,4.87,1.163,1.163,0,0,1,16.115,6.036Zm3.31,1.183A5.769,5.769,0,0,0,17.85,3.135,5.807,5.807,0,0,0,13.766,1.56c-1.609-.091-6.433-.091-8.042,0A5.8,5.8,0,0,0,1.64,3.13,5.788,5.788,0,0,0,.065,7.215c-.091,1.609-.091,6.433,0,8.042A5.769,5.769,0,0,0,1.64,19.341a5.814,5.814,0,0,0,4.084,1.575c1.609.091,6.433.091,8.042,0a5.769,5.769,0,0,0,4.084-1.575,5.807,5.807,0,0,0,1.575-4.084c.091-1.609.091-6.429,0-8.038Zm-2.079,9.765a3.289,3.289,0,0,1-1.853,1.853c-1.283.509-4.328.391-5.746.391S5.28,19.341,4,18.837a3.289,3.289,0,0,1-1.853-1.853c-.509-1.283-.391-4.328-.391-5.746s-.113-4.467.391-5.746A3.289,3.289,0,0,1,4,3.639c1.283-.509,4.328-.391,5.746-.391s4.467-.113,5.746.391a3.289,3.289,0,0,1,1.853,1.853c.509,1.283.391,4.328.391,5.746S17.855,15.705,17.346,16.984Z" transform="translate(0.004 -1.492)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <span class="social__shear--title">Instagram</span>
                                        </a>
                                    </li>
                                @endif
                                @if (!empty($settings['youtube_url']))
                                    <li class="social__shear--list">
                                        <a class="social__shear--list__icon" target="_blank" href="{{ $settings['youtube_url'] }}">
                                            <span class="footer__social--icon__svg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18.49" height="13.582" viewBox="0 0 16.49 11.582">
                                                    <path data-name="Path 321" d="M967.759,1365.592q0,1.377-.019,1.717-.076,1.114-.151,1.622a3.981,3.981,0,0,1-.245.925,1.847,1.847,0,0,1-.453.717,2.171,2.171,0,0,1-1.151.6q-3.585.265-7.641.189-2.377-.038-3.387-.085a11.337,11.337,0,0,1-1.5-.142,2.206,2.206,0,0,1-1.113-.585,2.562,2.562,0,0,1-.528-1.037,3.523,3.523,0,0,1-.141-.585c-.032-.2-.06-.5-.085-.906a38.894,38.894,0,0,1,0-4.867l.113-.925a4.382,4.382,0,0,1,.208-.906,2.069,2.069,0,0,1,.491-.755,2.409,2.409,0,0,1,1.113-.566,19.2,19.2,0,0,1,2.292-.151q1.82-.056,3.953-.056t3.952.066q1.821.067,2.311.142a2.3,2.3,0,0,1,.726.283,1.865,1.865,0,0,1,.557.49,3.425,3.425,0,0,1,.434,1.019,5.72,5.72,0,0,1,.189,1.075q0,.095.057,1C967.752,1364.1,967.759,1364.677,967.759,1365.592Zm-7.6.925q1.49-.754,2.113-1.094l-4.434-2.339v4.66Q958.609,1367.311,960.156,1366.517Z" transform="translate(-951.269 -1359.8)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <span class="social__shear--title">Youtube</span>
                                        </a>
                                    </li>
                                @endif
                                @if (!empty($settings['linkedin_url']))
                                    <li class="social__shear--list">
                                        <a class="social__shear--list__icon" target="_blank" href="{{ $settings['linkedin_url'] }}">
                                            <span class="footer__social--icon__svg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16.49" height="16.49" viewBox="0 0 16.49 16.49">
                                                    <path data-name="Path 322" d="M947.2,1366.585a1.208,1.208,0,0,1-1.208-1.208v-8.947a1.208,1.208,0,0,1,2.416,0v8.947A1.208,1.208,0,0,1,947.2,1366.585Zm-4.829-9.054a1.208,1.208,0,1,1,1.208-1.208A1.208,1.208,0,0,1,942.371,1357.531Zm.241,2.416h2.416v8.947a1.208,1.208,0,0,0,2.416,0v-8.947h2.416a1.208,1.208,0,0,0,1.208-1.208,1.208,1.208,0,0,0-1.208-1.208h-6.986a1.208,1.208,0,0,0-1.208,1.208A1.208,1.208,0,0,0,942.612,1359.947Z" transform="translate(-941.163 -1352.095)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <span class="social__shear--title">LinkedIn</span>
                                        </a>
                                    </li>
                                @endif
                                @if (!empty($settings['pinterest_url']))
                                    <li class="social__shear--list">
                                        <a class="social__shear--list__icon" target="_blank" href="{{ $settings['pinterest_url'] }}">
                                            <span class="footer__social--icon__svg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16.49" height="16.49" viewBox="0 0 16.49 16.49">
                                                    <path data-name="Path 323" d="M959.463,1352.095a8.245,8.245,0,0,0-8.245,8.245,8.245,8.245,0,0,0,4.829,7.5,8.245,8.245,0,0,1-1.208-4.829c0-2.416,1.208-4.829,3.621-5.829a6.037,6.037,0,0,1,5.829,1.208,6.037,6.037,0,0,1,1.208,6.037,6.037,6.037,0,0,1-4.829,4.829,1.208,1.208,0,0,0-1.208,1.208v2.416a1.208,1.208,0,0,0,2.416,0v-1.208a3.621,3.621,0,0,0,3.621-3.621,8.245,8.245,0,0,0-5.829-7.937Z" transform="translate(-951.218 -1352.095)" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <span class="social__shear--title">Pinterest</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Newsletter (FIXED) -->
                <div class="col-lg-3 col-md-5">
                    <div class="footer__widget">
                        <h2 class="footer__widget--title h3">Newsletter
                            <button class="footer__widget--button style3" aria-label="footer widget button">
                                <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                    <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                </svg>
                            </button>
                        </h2>
                        <div class="footer__widget--inner">
                            <p class="footer__widget--desc m-0">Your Style Journey Begins Here – New Kurtis & Tops Just Arrived!</p>
                            <div class="newsletter__subscribe style3 newsletter__subscribe--style3">
                                <form class="newsletter__subscribe--form position__relative" action="#">
                                    <label>
                                        <input class="newsletter__subscribe--input style3" placeholder="Email Address" type="email">
                                    </label>
                                    <button class="newsletter__subscribe--button style3" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send">
                                            <line x1="22" y1="2" x2="11" y2="13"></line>
                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer__bottom">
            <div class="row align-items-center">
                <div class="col-xl-8">
                    <p class="copyright__content style3 text-left text-black">
                        Copyright © {{ date('Y') }}
                        <a class="copyright__content--link" href="{{ route('home') }}">{{ $settings['site_name'] ?? 'Waseem Fashion Studio' }}</a>, All Rights Reserved |
                        Design and Developed By
                        <a href="https://www.jhweb.in/" target="_blank" class="text-black">J H Web Solutions</a>
                    </p>
                </div>
                <div class="col-xl-4">
                    <div class="footer__payment style3 d-flex justify-content-end">
                        <img class="display-block" src="{{ asset('assets/images/payment-visa-card.png') }}" alt="visa-card">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<a target="_blank"
   href="https://api.whatsapp.com/send?phone=917396992031&text=Hello%2C%20I%20am%20looking%20at%20this%20https%3A%2F%2Fwww.waseemfashionstudio.com%2F%20Need%20further%20information%20on%20this%20apparel%20piece%2C%20please%20help."
   class="whatsapp-button">
    <svg width="24" height="24" viewBox="0 0 32 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M16.001 2.667C8.64 2.667 2.667 8.64 2.667 16c0 2.816.832 5.44 2.262 7.637L2 30l6.582-2.878A13.26 13.26 0 0 0 16 29.333C23.36 29.333 29.333 23.36 29.333 16S23.36 2.667 16.001 2.667zm0 24c-2.293 0-4.421-.742-6.157-2.003l-.437-.314-3.907 1.71.832-4.114-.269-.421A10.61 10.61 0 0 1 5.333 16c0-5.867 4.8-10.667 10.667-10.667 5.867 0 10.667 4.8 10.667 10.667S21.868 26.667 16.001 26.667zm5.493-7.84c-.301-.149-1.778-.878-2.054-.978-.277-.102-.480-.149-.685.149-.202.296-.789.978-.968 1.178-.179.202-.356.225-.657.076-.301-.149-1.273-.47-2.425-1.502-.896-.797-1.501-1.78-1.677-2.078-.176-.296-.019-.456.132-.604.136-.135.301-.353.451-.528.149-.176.199-.3.300-.502.099-.202.050-.378-.025-.528-.075-.149-.685-1.653-.94-2.27-.247-.593-.497-.51-.685-.52-.176-.008-.378-.01-.58-.01-.202 0-.528.075-.804.378-.277.296-1.053 1.03-1.053 2.502 0 1.47 1.079 2.884 1.231 3.085.149.202 2.123 3.243 5.231 4.455.732.314 1.303.502 1.748.64.734.234 1.402.201 1.93.122.589-.087 1.778-.726 2.029-1.427.25-.702.25-1.304.176-1.427-.074-.122-.277-.198-.578-.346z"/>
    </svg>
</a>



{{-- FOOTER ACCORDION SCRIPT (unchanged from previous fix) --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const wait = setInterval(() => {
            if (typeof slideUp !== 'undefined' && typeof slideDown !== 'undefined' && typeof getSiblings !== 'undefined') {
                clearInterval(wait);
                initFooterAccordion();
            }
        }, 50);
    });

    function initFooterAccordion() {
        const buttons = document.querySelectorAll('.footer__widget--button.style3');
        buttons.forEach(btn => {
            const widget = btn.closest('.footer__widget');
            const inner  = widget.querySelector('.footer__widget--inner');
            if (window.innerWidth >= 992) {
                inner.style.display = 'block';
                widget.classList.remove('active');
                btn.setAttribute('aria-expanded', 'true');
            } else {
                inner.style.display = 'none';
                widget.classList.remove('active');
                btn.setAttribute('aria-expanded', 'false');
            }
        });

        const container = document.querySelector('.main__footer');
        if (container) {
            const fresh = container.cloneNode(true);
            container.parentNode.replaceChild(fresh, container);
        }

        document.querySelectorAll('.footer__widget--button.style3').forEach(btn => {
            btn.addEventListener('click', function () {
                if (window.innerWidth >= 992) return;
                const widget   = this.closest('.footer__widget');
                const inner    = widget.querySelector('.footer__widget--inner');
                const expanded = this.getAttribute('aria-expanded') === 'true';
                if (expanded) {
                    widget.classList.remove('active');
                    slideUp(inner);
                    this.setAttribute('aria-expanded', 'false');
                } else {
                    widget.classList.add('active');
                    slideDown(inner);
                    this.setAttribute('aria-expanded', 'true');
                    getSiblings(widget).forEach(sib => {
                        const sibInner = sib.querySelector('.footer__widget--inner');
                        if (sibInner) {
                            sib.classList.remove('active');
                            slideUp(sibInner);
                            sib.querySelector('.footer__widget--button.style3')
                               ?.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            });
        });
    }

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(initFooterAccordion, 120);
    });
</script>

<style>
.whatsapp-button{
    position: fixed;
    bottom: 50px;
    right: 20px;
    z-index: 999;
    background-color: #25d366;
    border-radius: 50%;
    color: #ffffff;
    width: 55px;
    height: 55px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0px 4px 18px rgba(0,0,0,0.3);
    text-decoration: none;
}

.whatsapp-button svg{
    width: 28px;
    height: 28px;
    fill: #fff;
}

/* Mobile devices */
@media only screen and (max-width: 767px){
    .whatsapp-button{
        bottom: 80px;
    }
}
</style>

