Macy.init({
    container: '.gallery',
    trueOrder: false,
    waitForImages: false,
    margin: 10,
    columns: 5,
    breakAt: {
        1200: 4,
        940: 3,
        520: 2,
        400: 1
    }
});
$('.carousel').slick({
    infinite: true,
    arrows: true,
    dots: true,
    fade: true,
    speed: 600,
    slide: '.carousel__item',
    lazyLoad: 'progressive',
    autoplay: false,
    autoplaySpeed: 4000,
});
$('.gallery__item a').featherlightGallery({
    openSpeed: 300
});