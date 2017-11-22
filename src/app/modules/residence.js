// Slider
$('.js-residence-slider').slick({
	slidesToShow: 1,
	infinite: true,
	arrows: true,
	prevArrow: '.js-residence-slider-previous',
	nextArrow: '.js-residence-slider-next',
	// autoplay: true,
});

// Services
$('.js-residence-services-image').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	fade: true,
	asNavFor: '.js-residence-services-content',
});

$('.js-residence-services-content').slick({
	asNavFor: '.js-residence-services-image',
	arrows: false,
	slidesToShow: 1,
	slidesToScroll: 1,
	dots: true,
	focusOnSelect: true,
});


// Appartments
$('.js-residence-apartments-image').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	fade: true,
	asNavFor: '.js-residence-apartments-content',
});

$('.js-residence-apartments-content').slick({
	asNavFor: '.js-residence-apartments-image',
	arrows: true,
	slidesToShow: 1,
	slidesToScroll: 1,
	// dots: true,
	focusOnSelect: true,
	prevArrow: '.js-residence-apartments-previous',
	nextArrow: '.js-residence-apartments-next',
});
