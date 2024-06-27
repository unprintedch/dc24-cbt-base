// js/slider.js
document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.swiper-video', {
        direction: 'horizontal',
        loop: false,
        slidesPerView: 4,
        spaceBetween: 120,
        centeredSlides: false,
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 60
            },
            1100: {
                slidesPerView: 4,
                spaceBetween: 60
            }
        },
        pagination: {
            el: ".dc24-swiper-pagination-primary",
            type: "progressbar",
            modiferClass: "dc24-swiper-pagination",
        },
        navigation: {
            nextEl: '.dc24-swiper-button-next-items',
            prevEl: '.dc24-swiper-button-prev-items',
        },
    });
});