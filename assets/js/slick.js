require('slick-carousel');

const $ = require('jquery');

$('.playlist-slider').slick({
    centerMode: true,
    infinite: true,
    speed: 500,
    arrows: false,
    dots: false,
    rows: 0,
    slidesToShow: 5,
    variableWidth: true,
    autoplay: false,
});
