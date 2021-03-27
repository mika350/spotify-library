require('slick-carousel');

const $ = require('jquery');

$('.playlist-slider-preview').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.playlist-slider-navigation'
});

$('.playlist-slider-navigation').slick({
    centerMode: true,
    infinite: true,
    speed: 500,
    arrows: true,
    dots: false,
    rows: 0,
    slidesToShow: 5,
    variableWidth: true,
    asNavFor: '.playlist-slider-preview',
    autoplay: false,
    prevArrow: '<a class="slick-prev slick-arrow"><i class="bi bi-caret-left-fill"></i></a>',
    nextArrow: '<a class="slick-next slick-arrow"><i class="bi bi-caret-right-fill"></i></a>',
    responsive: [{
        breakpoint: 1024,
        settings: {
            arrows: false,
        }
    }],
});
