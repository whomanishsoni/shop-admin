"use strict";

// Preloader function with null check
const preLoader = function () {
    let preloaderWrapper = document.getElementById("preloader");
    if (preloaderWrapper) {
        window.onload = () => {
            preloaderWrapper.classList.add("loaded");
        };
    }
};
preLoader();

// Utility function to get sibling elements
var getSiblings = function (elem) {
    const siblings = [];
    let sibling = elem.parentNode.firstChild;
    for (; sibling;) {
        1 === sibling.nodeType && sibling !== elem && siblings.push(sibling);
        sibling = sibling.nextSibling;
    }
    return siblings;
};

// Slide up animation
const slideUp = (target, time) => {
    const duration = time || 500;
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + "ms";
    target.style.boxSizing = "border-box";
    target.style.height = target.offsetHeight + "px";
    target.offsetHeight;
    target.style.overflow = "hidden";
    target.style.height = 0;
    window.setTimeout(() => {
        target.style.display = "none";
        target.style.removeProperty("height");
        target.style.removeProperty("overflow");
        target.style.removeProperty("transition-duration");
        target.style.removeProperty("transition-property");
    }, duration);
};

// Slide down animation
const slideDown = (target, time) => {
    const duration = time || 500;
    target.style.removeProperty("display");
    let display = window.getComputedStyle(target).display;
    "none" === display && (display = "block");
    target.style.display = display;
    const height = target.offsetHeight;
    target.style.overflow = "hidden";
    target.style.height = 0;
    target.offsetHeight;
    target.style.boxSizing = "border-box";
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + "ms";
    target.style.height = height + "px";
    window.setTimeout(() => {
        target.style.removeProperty("height");
        target.style.removeProperty("overflow");
        target.style.removeProperty("transition-duration");
        target.style.removeProperty("transition-property");
    }, duration);
};

// Get top offset of an element
function TopOffset(el) {
    let rect = el.getBoundingClientRect(),
        scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    return { top: rect.top + scrollTop };
}

// Sticky header functionality
const headerStickyWrapper = document.querySelector("header");
const headerStickyTarget = document.querySelector(".header__sticky");
if (headerStickyTarget) {
    let headerHeight = headerStickyWrapper.clientHeight;
    window.addEventListener("scroll", function () {
        let TargetElementTopOffset = TopOffset(headerStickyWrapper).top;
        window.scrollY > TargetElementTopOffset ? headerStickyTarget.classList.add("sticky") : headerStickyTarget.classList.remove("sticky");
    });
}

// Scroll to top button
const scrollTop = document.getElementById("scroll__top");
if (scrollTop) {
    scrollTop.addEventListener("click", function () {
        window.scroll({ top: 0, left: 0, behavior: "smooth" });
    });
    window.addEventListener("scroll", function () {
        window.scrollY > 300 ? scrollTop.classList.add("active") : scrollTop.classList.remove("active");
    });
}

// Initialize Swiper sliders with enhanced logic
let swiperMediaNav = null;
let swiperMediaPreview = null;

if (typeof Swiper !== "undefined") {
    const initSwiper = () => {
        const navElement = document.querySelector(".product__media--nav");
        const previewElement = document.querySelector(".product__media--preview");
        const heroElement = document.querySelector(".hero__slider--activation");
        const productElement = document.querySelector(".product__swiper--activation");
        const productColumn4Element = document.querySelector(".product__swiper--column4__activation");
        const productSidebarElement = document.querySelector(".product__sidebar--column4__activation");
        const productColumn3Element = document.querySelector(".product__swiper--column3");
        const testimonialElement = document.querySelector(".testimonial__swiper--activation");
        const testimonialColumn1Element = document.querySelector(".testimonial__activation--column1");
        const blogElement = document.querySelector(".blog__swiper--activation");
        const quickviewElement = document.querySelector(".quickview__swiper--activation");
        const relatedProductsElement = document.querySelector(".product__swiper--column4__activation");

        if (navElement) {
            const navSlides = navElement.querySelectorAll(".swiper-slide").length;
            const navWrapper = navElement.querySelector(".swiper-wrapper");
            const navNext = navElement.querySelector(".swiper-button-next");
            const navPrev = navElement.querySelector(".swiper-button-prev");
            if (navSlides === 0) {
                return;
            }
            if (!navWrapper) {
                return;
            }
            if (!navNext || !navPrev) {
            }
        }
        if (previewElement) {
            const previewSlides = previewElement.querySelectorAll(".swiper-slide").length;
            const previewWrapper = previewElement.querySelector(".swiper-wrapper");
            if (previewSlides === 0) {
                return;
            }
            if (!previewWrapper) {
                return;
            }
        }
        if (relatedProductsElement) {
            const relatedSlides = relatedProductsElement.querySelectorAll(".swiper-slide").length;
            const relatedWrapper = relatedProductsElement.querySelector(".swiper-wrapper");
            const relatedNext = relatedProductsElement.querySelector(".swiper-button-next");
            const relatedPrev = relatedProductsElement.querySelector(".swiper-button-prev");
            if (relatedSlides === 0) {
                return;
            }
            if (!relatedWrapper) {
                return;
            }
        }

        // Hero Slider
        if (heroElement && heroElement.querySelector(".swiper-wrapper")) {
            new Swiper(".hero__slider--activation", {
                slidesPerView: 1,
                loop: true,
                clickable: true,
                speed: 800,
                spaceBetween: 30,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }

        // Product Slider
        if (productElement && productElement.querySelector(".swiper-wrapper")) {
            new Swiper(".product__swiper--activation", {
                slidesPerView: 5,
                loop: true,
                clickable: true,
                spaceBetween: 30,
                breakpoints: {
                    1200: { slidesPerView: 5 },
                    992: { slidesPerView: 4 },
                    768: { slidesPerView: 3, spaceBetween: 30 },
                    280: { slidesPerView: 2, spaceBetween: 20 },
                    0: { slidesPerView: 1 },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }

        // Product Column 4 Slider
        if (productColumn4Element && productColumn4Element.querySelector(".swiper-wrapper")) {
            new Swiper(".product__swiper--column4__activation", {
                slidesPerView: 4,
                loop: true,
                clickable: true,
                spaceBetween: 30,
                breakpoints: {
                    1200: { slidesPerView: 4 },
                    992: { slidesPerView: 4 },
                    768: { slidesPerView: 3, spaceBetween: 30 },
                    280: { slidesPerView: 2, spaceBetween: 20 },
                    0: { slidesPerView: 1 },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }

        // Product Sidebar Slider
        if (productSidebarElement && productSidebarElement.querySelector(".swiper-wrapper")) {
            new Swiper(".product__sidebar--column4__activation", {
                slidesPerView: 4,
                loop: true,
                clickable: true,
                spaceBetween: 30,
                breakpoints: {
                    1200: { slidesPerView: 4 },
                    992: { slidesPerView: 3 },
                    768: { slidesPerView: 3, spaceBetween: 30 },
                    280: { slidesPerView: 2, spaceBetween: 20 },
                    0: { slidesPerView: 1 },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }

        // Product Column 3 Slider
        if (productColumn3Element && productColumn3Element.querySelector(".swiper-wrapper")) {
            new Swiper(".product__swiper--column3", {
                slidesPerView: 4,
                loop: true,
                autoplay: true,
                spaceBetween: 30,
                breakpoints: {
                    1200: { slidesPerView: 4 },
                    992: { slidesPerView: 2 },
                    768: { slidesPerView: 2, spaceBetween: 30 },
                    280: { slidesPerView: 2, spaceBetween: 20 },
                    0: { slidesPerView: 1 },
                },
                navigation: {
                    nextEl: ".new__product--sidebar .swiper-button-next",
                    prevEl: ".new__product--sidebar .swiper-button-prev",
                },
            });
        }

        // Testimonial Slider
        if (testimonialElement && testimonialElement.querySelector(".swiper-wrapper")) {
            new Swiper(".testimonial__swiper--activation", {
                slidesPerView: 3,
                loop: true,
                clickable: true,
                spaceBetween: 30,
                breakpoints: {
                    1200: { slidesPerView: 3 },
                    768: { spaceBetween: 30, slidesPerView: 2 },
                    576: { slidesPerView: 2, spaceBetween: 20 },
                    0: { slidesPerView: 1 },
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        }

        // Testimonial Column 1 Slider
        if (testimonialColumn1Element && testimonialColumn1Element.querySelector(".swiper-wrapper")) {
            new Swiper(".testimonial__activation--column1", {
                slidesPerView: 1,
                loop: true,
                clickable: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        }

        // Blog Slider
        if (blogElement && blogElement.querySelector(".swiper-wrapper")) {
            new Swiper(".blog__swiper--activation", {
                slidesPerView: 4,
                loop: true,
                clickable: true,
                spaceBetween: 30,
                breakpoints: {
                    1200: { slidesPerView: 4 },
                    992: { slidesPerView: 3 },
                    768: { slidesPerView: 3, spaceBetween: 30 },
                    480: { slidesPerView: 2, spaceBetween: 20 },
                    0: { slidesPerView: 1 },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }

        // Quickview Slider
        if (quickviewElement && quickviewElement.querySelector(".swiper-wrapper")) {
            new Swiper(".quickview__swiper--activation", {
                slidesPerView: 1,
                loop: true,
                clickable: true,
                spaceBetween: 30,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        }

        // Product Media Navigation
        if (navElement && navElement.querySelector(".swiper-wrapper") && !swiperMediaNav) {
            swiperMediaNav = new Swiper(".product__media--nav", {
                loop: false,
                spaceBetween: 10,
                slidesPerView: 5,
                breakpoints: {
                    768: { slidesPerView: 5 },
                    480: { slidesPerView: 4 },
                    320: { slidesPerView: 3 },
                    200: { slidesPerView: 2 },
                    0: { slidesPerView: 1 },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            if (Array.isArray(swiperMediaNav)) {
                swiperMediaNav = swiperMediaNav[0];
            }
        }

        // Product Media Preview
        if (previewElement && previewElement.querySelector(".swiper-wrapper") && !swiperMediaPreview) {
            try {
                swiperMediaPreview = new Swiper(".product__media--preview", {
                    loop: false,
                    spaceBetween: 10,
                });
                if (Array.isArray(swiperMediaPreview)) {
                    swiperMediaPreview = swiperMediaPreview[0];
                }
            } catch (error) {
            }
        }

        // Add click event to thumbnails to update main preview
        if (swiperMediaNav && navElement) {
            const navSlides = navElement.querySelectorAll(".swiper-slide");
            navSlides.forEach((slide, index) => {
                slide.addEventListener("click", () => {
                    if (swiperMediaPreview && typeof swiperMediaPreview.slideTo === "function") {
                        swiperMediaPreview.slideTo(index);
                    } else {
                        const previewElement = document.querySelector(".product__media--preview");
                        if (previewElement && previewElement.querySelector(".swiper-wrapper")) {
                            try {
                                swiperMediaPreview = new Swiper(".product__media--preview", {
                                    loop: false,
                                    spaceBetween: 10,
                                });
                                if (Array.isArray(swiperMediaPreview)) {
                                    swiperMediaPreview = swiperMediaPreview[0];
                                }
                                if (swiperMediaPreview && typeof swiperMediaPreview.slideTo === "function") {
                                    swiperMediaPreview.slideTo(index);
                                }
                            } catch (error) {
                            }
                        }
                    }
                });
            });
        }
    };

    // MutationObserver to ensure DOM is ready
    const observer = new MutationObserver((mutations, obs) => {
        if (document.querySelector(".product__media--nav") && document.querySelector(".product__media--preview")) {
            initSwiper();
            obs.disconnect();
        }
    });
    observer.observe(document.body, { childList: true, subtree: true });

    // Initial call to try initialization
    initSwiper();
}

// Tab functionality
const tab = function (wrapper) {
    let tabContainer = document.querySelector(wrapper);
    if (tabContainer) {
        tabContainer.addEventListener("click", function (evt) {
            let listItem = evt.target;
            if (listItem.hasAttribute("data-toggle")) {
                let targetId = listItem.dataset.target,
                    targetItem = document.querySelector(targetId);
                if (targetItem) {
                    listItem.parentElement.querySelectorAll('[data-toggle="tab"]').forEach(function (list) {
                        list.classList.remove("active");
                    });
                    listItem.classList.add("active");
                    targetItem.classList.add("active");
                    setTimeout(function () {
                        targetItem.classList.add("show");
                    }, 150);
                    getSiblings(targetItem).forEach(function (pane) {
                        pane.classList.remove("show");
                        setTimeout(function () {
                            pane.classList.remove("active");
                        }, 150);
                    });
                }
            }
        });
    }
};
tab(".product__tab--one");
tab(".product__tab--two");
tab(".product__details--tab");
tab(".product__grid--column__buttons");

// Countdown timer
document.querySelectorAll("[data-countdown]").forEach(function (elem) {
    if (elem) {
        const countDownItem = function (value, label) {
            return `<div class="countdown__item" ${label}"><span class="countdown__number">${value}</span><p class="countdown__text">${label}</p></div>`;
        };
        const date = new Date(elem.getAttribute("data-countdown")).getTime();
        const second = 1000,
            minute = 60000,
            hour = 3600000,
            day = 86400000;
        const countDownInterval = setInterval(function () {
            let currentTime = new Date().getTime();
            let timeDistance = date - currentTime;
            let daysValue = Math.floor(timeDistance / day);
            let hoursValue = Math.floor(timeDistance % day / hour);
            let minutesValue = Math.floor(timeDistance % hour / minute);
            let secondsValue = Math.floor(timeDistance % minute / second);
            if (elem) {
                elem.innerHTML = countDownItem(daysValue, "days") + countDownItem(hoursValue, "hrs") + countDownItem(minutesValue, "mins") + countDownItem(secondsValue, "secs");
                if (timeDistance < 0) clearInterval(countDownInterval);
            }
        }, 1000);
    }
});

// Active class toggle
const activeClassAction = function (toggle, target) {
    const to = document.querySelector(toggle);
    const ta = document.querySelector(target);
    if (to && ta) {
        to.addEventListener("click", function (e) {
            e.preventDefault();
            let triggerItem = e.target;
            if (triggerItem.classList.contains("active")) {
                triggerItem.classList.remove("active");
                ta.classList.remove("active");
            } else {
                triggerItem.classList.add("active");
                ta.classList.add("active");
            }
        });
        document.addEventListener("click", function (event) {
            if (!event.target.closest(toggle) && !event.target.classList.contains(toggle.replace(/\./, "")) &&
                !event.target.closest(target) && !event.target.classList.contains(target.replace(/\./, ""))) {
                to.classList.remove("active");
                ta.classList.remove("active");
            }
        });
    }
};
activeClassAction(".account__currency--link", ".dropdown__currency");
activeClassAction(".language__switcher", ".dropdown__language");
activeClassAction(".offcanvas__language--switcher", ".offcanvas__dropdown--language");
activeClassAction(".offcanvas__account--currency__menu", ".offcanvas__account--currency__submenu");
activeClassAction(".footer__language--link", ".footer__dropdown--language");
activeClassAction(".footer__currency--link", ".footer__dropdown--currency");

// Off-canvas sidebar
function offcanvsSidebar(openTrigger, closeTrigger, wrapper) {
    let OpenTriggerprimary__btn = document.querySelectorAll(openTrigger);
    let closeTriggerprimary__btn = document.querySelector(closeTrigger);
    let WrapperSidebar = document.querySelector(wrapper);
    let wrapperOverlay = wrapper.replace(".", "");

    function handleBodyClass(evt) {
        let eventTarget = evt.target;
        if (!eventTarget.closest(wrapper) && !eventTarget.closest(openTrigger)) {
            if (WrapperSidebar) {
                WrapperSidebar.classList.remove("active");
                document.querySelector("body")?.classList.remove(`${wrapperOverlay}_active`);
            }
        }
    }

    if (OpenTriggerprimary__btn && WrapperSidebar) {
        OpenTriggerprimary__btn.forEach(function (singleItem) {
            singleItem.addEventListener("click", function (e) {
                e.preventDefault();
                if (singleItem.hasAttribute("data-offcanvas") || e.target.closest("[data-offcanvas]")) {
                    WrapperSidebar.classList.add("active");
                    document.querySelector("body")?.classList.add(`${wrapperOverlay}_active`);
                    document.body.addEventListener("click", handleBodyClass);
                }
            });
        });
    }

    if (closeTriggerprimary__btn && WrapperSidebar) {
        closeTriggerprimary__btn.addEventListener("click", function (e) {
            e.preventDefault();
            if (e.target.hasAttribute("data-offcanvas") || e.target.closest("[data-offcanvas]")) {
                WrapperSidebar.classList.remove("active");
                document.querySelector("body")?.classList.remove(`${wrapperOverlay}_active`);
                document.body.removeEventListener("click", handleBodyClass);
            }
        });
    }
}
offcanvsSidebar(".minicart__open--btn", ".minicart__close--btn", ".offCanvas__minicart");
offcanvsSidebar(".search__open--btn", ".predictive__search--close__btn", ".predictive__search--box");
offcanvsSidebar(".widget__filter--btn", ".offcanvas__filter--close", ".offcanvas__filter--sidebar");

// Off-canvas header menu
const offcanvasHeader = function () {
    const offcanvasOpen = document.querySelector(".offcanvas__header--menu__open--btn");
    const offcanvasClose = document.querySelector(".offcanvas__close--btn");
    const offcanvasHeader = document.querySelector(".offcanvas__header");
    const offcanvasMenu = document.querySelector(".offcanvas__menu");
    const body = document.querySelector("body");

    if (offcanvasMenu) {
        offcanvasMenu.querySelectorAll(".offcanvas__sub_menu").forEach(function (ul) {
            const subMenuToggle = document.createElement("button");
            subMenuToggle.classList.add("offcanvas__sub_menu_toggle");
            ul.parentNode.appendChild(subMenuToggle);
        });
    }

    if (offcanvasOpen) {
        offcanvasOpen.addEventListener("click", function (e) {
            e.preventDefault();
            if (e.target.hasAttribute("data-offcanvas") || e.target.closest("[data-offcanvas]")) {
                offcanvasHeader.classList.add("open");
                body.classList.add("mobile_menu_open");
            }
        });
    }

    if (offcanvasClose) {
        offcanvasClose.addEventListener("click", function (e) {
            e.preventDefault();
            if (e.target.hasAttribute("data-offcanvas") || e.target.closest("[data-offcanvas]")) {
                offcanvasHeader.classList.remove("open");
                body.classList.remove("mobile_menu_open");
            }
        });
    }

    let mobileMenuWrapper = document.querySelector(".offcanvas__menu_ul");
    if (mobileMenuWrapper) {
        mobileMenuWrapper.addEventListener("click", function (e) {
            let targetElement = e.target;
            if (targetElement.classList.contains("offcanvas__sub_menu_toggle")) {
                const parent = targetElement.parentElement;
                if (parent.classList.contains("active")) {
                    targetElement.classList.remove("active");
                    parent.classList.remove("active");
                    parent.querySelectorAll(".offcanvas__sub_menu").forEach(function (subMenu) {
                        subMenu.parentElement.classList.remove("active");
                        subMenu.nextElementSibling.classList.remove("active");
                        slideUp(subMenu);
                    });
                } else {
                    targetElement.classList.add("active");
                    parent.classList.add("active");
                    slideDown(targetElement.previousElementSibling);
                    getSiblings(parent).forEach(function (item) {
                        item.classList.remove("active");
                        item.querySelectorAll(".offcanvas__sub_menu").forEach(function (subMenu) {
                            subMenu.parentElement.classList.remove("active");
                            subMenu.nextElementSibling.classList.remove("active");
                            slideUp(subMenu);
                        });
                    });
                }
            }
        });
    }

    if (offcanvasHeader) {
        document.addEventListener("click", function (event) {
            if (!event.target.closest(".offcanvas__header--menu__open--btn") && !event.target.classList.contains(".offcanvas__header--menu__open--btn".replace(/\./, "")) &&
                !event.target.closest(".offcanvas__header") && !event.target.classList.contains(".offcanvas__header".replace(/\./, ""))) {
                offcanvasHeader.classList.remove("open");
                body.classList.remove("mobile_menu_open");
            }
        });

        window.addEventListener("resize", function () {
            if (window.outerWidth >= 992) {
                offcanvasHeader.classList.remove("open");
                body.classList.remove("mobile_menu_open");
            }
        });
    }
};
offcanvasHeader();

// Quantity input handler
const quantityWrapper = document.querySelectorAll(".quantity__box");
if (quantityWrapper.length > 0) {
    quantityWrapper.forEach(function (singleItem) {
        let increaseButton = singleItem.querySelector(".increase");
        let decreaseButton = singleItem.querySelector(".decrease");
        let input = singleItem.querySelector("input[type='number']");

        if (increaseButton && decreaseButton && input) {
            increaseButton.addEventListener("click", function (e) {
                e.preventDefault();
                let value = parseInt(input.value, 10);
                value = isNaN(value) ? 1 : value;
                value++;
                input.value = value;
                input.dispatchEvent(new Event('change')); // Trigger change event
            });

            decreaseButton.addEventListener("click", function (e) {
                e.preventDefault();
                let value = parseInt(input.value, 10);
                value = isNaN(value) ? 1 : value;
                if (value > 1) {
                    value--;
                    input.value = value;
                    input.dispatchEvent(new Event('change')); // Trigger change event
                }
            });
        }
    });
}

// Modal functionality
const openEls = document.querySelectorAll("[data-open]");
const closeEls = document.querySelectorAll("[data-close]");
const isVisible = "is-visible";
for (const el of openEls) {
    el.addEventListener("click", function () {
        const modalId = this.dataset.open;
        document.getElementById(modalId)?.classList.add(isVisible);
    });
}
for (const el of closeEls) {
    el.addEventListener("click", function () {
        this.parentElement.parentElement.parentElement?.classList.remove(isVisible);
    });
}

// Custom accordion
function customAccordion(accordionWrapper, singleItem, accordionBody) {
    document.querySelectorAll(accordionWrapper).forEach(function (item) {
        item.addEventListener("click", function (evt) {
            let itemTarget = evt.target;
            if (itemTarget.classList.contains("accordion__items--button") || itemTarget.classList.contains("widget__categories--menu__label")) {
                let singleAccordionWrapper = itemTarget.closest(singleItem);
                let singleAccordionBody = singleAccordionWrapper.querySelector(accordionBody);
                if (singleAccordionWrapper && singleAccordionBody) {
                    singleAccordionWrapper.classList.contains("active") ?
                        (singleAccordionWrapper.classList.remove("active"), slideUp(singleAccordionBody)) :
                        (singleAccordionWrapper.classList.add("active"), slideDown(singleAccordionBody),
                        getSiblings(singleAccordionWrapper).forEach(function (item) {
                            let siblingSingleAccordionBody = item.querySelector(accordionBody);
                            item.classList.remove("active");
                            slideUp(siblingSingleAccordionBody);
                        }));
                }
            }
        });
    });
}
customAccordion(".accordion__container", ".accordion__items", ".accordion__items--body");
customAccordion(".widget__categories--menu", ".widget__categories--menu__list", ".widget__categories--sub__menu");

// Modal close on outside click or Escape key
document.addEventListener("click", e => {
    if (e.target == document.querySelector(".modal.is-visible")) {
        document.querySelector(".modal.is-visible")?.classList.remove(isVisible);
    }
});
document.addEventListener("keyup", e => {
    if (e.key === "Escape" && document.querySelector(".modal.is-visible")) {
        document.querySelector(".modal.is-visible")?.classList.remove(isVisible);
    }
});

// Footer widget accordion with DOMContentLoaded
const footerWidgetAccordion = function () {
    let footerWidgetContainer = document.querySelector(".main__footer");
    if (footerWidgetContainer) {
        footerWidgetContainer.addEventListener("click", function (evt) {
            let singleItemTarget = evt.target;
            if (singleItemTarget.classList.contains("footer__widget--button")) {
                const footerWidget = singleItemTarget.closest(".footer__widget");
                const footerWidgetInner = footerWidget.querySelector(".footer__widget--inner");
                if (footerWidget && footerWidgetInner) {
                    footerWidget.classList.contains("active") ?
                        (footerWidget.classList.remove("active"), slideUp(footerWidgetInner)) :
                        (footerWidget.classList.add("active"), slideDown(footerWidgetInner),
                        getSiblings(footerWidget).forEach(function (item) {
                            const footerWidgetInner = item.querySelector(".footer__widget--inner");
                            item.classList.remove("active");
                            slideUp(footerWidgetInner);
                        }));
                }
            }
        });
    }
};

document.addEventListener("DOMContentLoaded", function () {
    footerWidgetAccordion();
});

window.addEventListener("resize", function () {
    if (document.querySelectorAll(".footer__widget").length > 0) {
        document.querySelectorAll(".footer__widget").forEach(function (item) {
            if (window.outerWidth >= 768) {
                item.classList.remove("active");
                item.querySelector(".footer__widget--inner").style.display = "";
            }
        });
        footerWidgetAccordion();
    }
});

// Custom lightbox with GLightbox
const customLightboxHTML = '<div id="glightbox-body" class="glightbox-container">\n    <div class="gloader visible"></div>\n    <div class="goverlay"></div>\n    <div class="gcontainer">\n    <div id="glightbox-slider" class="gslider"></div>\n    <button class="gnext gbtn" tabindex="0" aria-label="Next" data-customattribute="example">{nextSVG}</button>\n    <button class="gprev gbtn" tabindex="1" aria-label="Previous">{prevSVG}</button>\n    <button class="gclose gbtn" tabindex="2" aria-label="Close">{closeSVG}</button>\n    </div>\n    </div>';
const lightbox = GLightbox({
    touchNavigation: true,
    lightboxHTML: customLightboxHTML,
    loop: true,
});

// Counter animation
const wrapper = document.getElementById("funfactId");
if (wrapper) {
    const counters = wrapper.querySelectorAll(".js-counter");
    const duration = 1000;
    let isCounted = false;
    document.addEventListener("scroll", function () {
        const wrapperPos = wrapper.offsetTop - window.innerHeight;
        if (!isCounted && window.scrollY > wrapperPos) {
            counters.forEach(counter => {
                const countTo = counter.dataset.count;
                const countPerMs = countTo / duration;
                let currentCount = 0;
                const countInterval = setInterval(function () {
                    if (currentCount >= countTo) clearInterval(countInterval);
                    counter.textContent = Math.round(currentCount);
                    currentCount += countPerMs;
                }, 1);
            });
            isCounted = true;
        }
    });
}

// Newsletter popup
const newsletterPopup = function () {
    let newsletterWrapper = document.querySelector(".newsletter__popup");
    let newsletterCloseButton = document.querySelector(".newsletter__popup--close__btn");
    let dontShowPopup = document.querySelector("#newsletter__dont--show");
    let popuDontShowMode = localStorage.getItem("newsletter__show");

    if (newsletterWrapper && !popuDontShowMode) {
        window.addEventListener("load", event => {
            setTimeout(function () {
                document.body.classList.add("overlay__active");
                newsletterWrapper.classList.add("newsletter__show");
                document.addEventListener("click", function (event) {
                    if (!event.target.closest(".newsletter__popup--inner")) {
                        document.body.classList.remove("overlay__active");
                        newsletterWrapper.classList.remove("newsletter__show");
                    }
                });
                if (newsletterCloseButton) {
                    newsletterCloseButton.addEventListener("click", function () {
                        document.body.classList.remove("overlay__active");
                        newsletterWrapper.classList.remove("newsletter__show");
                    });
                }
                if (dontShowPopup) {
                    dontShowPopup.addEventListener("click", function () {
                        if (dontShowPopup.checked) {
                            localStorage.setItem("newsletter__show", true);
                        } else {
                            localStorage.removeItem("newsletter__show");
                        }
                    });
                }
            }, 3000);
        });
    }
};
newsletterPopup();

// jQuery ready block for additional initialization (if needed)
$(document).ready(function () {
    // Add jQuery-dependent code here if any
});
