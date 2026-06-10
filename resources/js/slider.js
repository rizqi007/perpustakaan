// resources/js/slider.js

// Impor Swiper dan modul yang dibutuhkan
import Swiper from "swiper";
import { Navigation, Pagination, Autoplay, EffectFade } from "swiper/modules";

// Impor CSS Swiper
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/effect-fade";

// Inisialisasi Swiper
const swiper = new Swiper(".hero-slider", {
    // Gunakan modul
    modules: [Navigation, Pagination, Autoplay, EffectFade],

    // Konfigurasi lainnya
    direction: "horizontal",
    loop: true,
    effect: "fade",
    fadeEffect: {
        crossFade: true,
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
