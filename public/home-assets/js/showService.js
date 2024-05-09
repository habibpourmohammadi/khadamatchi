var swiper = new Swiper(".mySwiper", {
    slidesPerView: 5,
    centeredSlides: false,
});


swiper.on('resize', function() {
    console.log("ok");
    var screenWidth = window.innerWidth;
    if (screenWidth >= 1200) {
        swiper.params.slidesPerView = 5;
    } else if (screenWidth >= 1024) {
        swiper.params.slidesPerView = 3;
    } else if (screenWidth >= 768) {
        swiper.params.slidesPerView = 2;
    } else if (screenWidth <= 500) {
        swiper.params.slidesPerView = 1;
    }

    swiper.update();
});
