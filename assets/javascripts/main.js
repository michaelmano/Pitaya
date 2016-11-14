Macy.init({
    container: '.macy',
    trueOrder: false,
    waitForImages: false,
    margin: 10,
    columns: 6,
    breakAt: {
        1200: 5,
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
$('.macy__child a').featherlightGallery({
    openSpeed: 300
});
