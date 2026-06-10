import "./bootstrap";
import "./slider.js";
// Alpine.js is bundled and started automatically by Livewire 3 via @livewireScripts
// Do NOT import or start Alpine here to avoid double-initialization conflicts

// Tambahkan kelas ke body untuk mencegah scroll saat preloader aktif
document.body.classList.add("preloader-active");

window.addEventListener("load", function () {
    const preloader = document.getElementById("preloader");
    if (preloader) {
        // Mulai transisi fade out
        preloader.style.opacity = "0";

        // Hapus kelas dari body dan sembunyikan preloader setelah transisi selesai
        setTimeout(() => {
            preloader.style.display = "none";
            document.body.classList.remove("preloader-active");
        }, 700); // Durasi harus cocok dengan durasi transisi di CSS
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi Swiper hanya jika elemen ada dan Swiper didefinisikan
    if (document.querySelector(".hero-slider") && typeof Swiper !== 'undefined') {
        const heroSwiper = new Swiper(".hero-slider", {
            effect: "fade",
            fadeEffect: {
                crossFade: true,
            },
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            loop: true,
            speed: 1500,
            parallax: true,
            navigation: {
                nextEl: ".swiper-button-next-custom",
                prevEl: ".swiper-button-prev-custom",
            },
            pagination: {
                el: ".swiper-pagination-custom",
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + '"></span>';
                },
            },
            on: {
                slideChange: function () {
                    // Reset dan trigger ulang animasi text pada slide aktif
                    const activeSlide = this.slides[this.activeIndex];
                    const animatedElements =
                        activeSlide.querySelectorAll(".animate-slide-up");

                    animatedElements.forEach((el, index) => {
                        el.style.animation = "none";
                        el.offsetHeight; // Trigger reflow
                        el.style.animation = `slide-up 1s ease-out ${index * 0.3 + 0.5
                            }s forwards`;
                    });
                },
                init: function () {
                    // Trigger animasi pada slide pertama
                    const firstSlide = this.slides[0];
                    const animatedElements =
                        firstSlide.querySelectorAll(".animate-slide-up");

                    animatedElements.forEach((el, index) => {
                        el.style.animationDelay = `${index * 0.3 + 0.5}s`;
                        el.style.animationFillMode = "forwards";
                    });
                },
            },
        });
    }

    // Parallax effect untuk background images
    window.addEventListener("scroll", function () {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll(
            "[data-swiper-parallax-scale]"
        );

        parallaxElements.forEach((element) => {
            const speed = 0.5;
            element.style.transform = `translateY(${scrolled * speed
                }px) scale(1.1)`;
        });
    });

    // Smooth scroll untuk scroll indicator
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });
});
