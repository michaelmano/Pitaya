"use strict";

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
$(".nav-toggle").click(function(event) {
  $(this).toggleClass('toggled');
  $('.navigation__primary').toggleClass('show');
});

$('.navigation__primary li').find('a').click(function(event) {
  if($(this).next().length > 0 && !$(this).parent('li').hasClass('hover')) {
    if(deviceDetection() === true) event.preventDefault();
    $(this).parent('li').addClass('hover')
  }
});

$(window).on('load resize', function () {
  navigationSizeCheck()
})
