// js/slider.js
document.addEventListener('DOMContentLoaded', function () {
    console.log('slider-items.js');
    const swiper = new Swiper('.swiper-items', {
        direction: 'horizontal',
        loop: false,
        slidesPerView: 3,
        spaceBetween: 50,
        centeredSlides: false,
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 40
            },
            1100: {
                slidesPerView: 3,
                spaceBetween: 40
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