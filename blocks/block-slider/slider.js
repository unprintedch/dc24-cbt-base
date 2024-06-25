// js/slider.js
document.addEventListener('DOMContentLoaded', function () {
    console.log('slider.js');
    const swiper = new Swiper('.swiper', {
        direction: 'horizontal',
        loop: true,
        pagination: {
            el: ".dc24-swiper-pagination",
            type: "progressbar",
            modiferClass: "dc24-swiper-pagination",
        },
        navigation: {
            nextEl: '.dc24-swiper-button-next',
            prevEl: '.dc24-swiper-button-prev',
        },
    });
});