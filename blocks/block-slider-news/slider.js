// js/slider.js
document.addEventListener('DOMContentLoaded', function () {
    // Récupérer la valeur du champ ACF depuis l'attribut data
    const swiperContainer = document.querySelector('.swiper-items');
    const slidesPerView = swiperContainer ? parseInt(swiperContainer.dataset.slidesPerView) || 1 : 1;
    
    console.log('Slides per view:', slidesPerView);
    
    const swiper = new Swiper('.swiper-items', {
        direction: 'horizontal',
        loop: false,
        slidesPerView: slidesPerView,
        spaceBetween: 50,
        centeredSlides: false,
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            640: {
                slidesPerView: slidesPerView -1 ,
                spaceBetween: 40
            },
            1100: {
                slidesPerView: slidesPerView,
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