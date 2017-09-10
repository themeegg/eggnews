var $ = jQuery;
$(document).ready(function () {
	'use strict';
	// Ticker
	$('#teg-newsTicker').bxSlider({
		minSlides: 1,
		maxSlides: 1,
		speed: 3000,
		mode: 'vertical',
		auto: true,
		controls: false,
		pager: false
	});
	// Slider
	$('.eggnewsSlider').bxSlider({
		pager: false,
		controls: true,
		prevText: '<i class="fa fa-arrow-left"> </i>',
		nextText: '<i class="fa fa-arrow-right"> </i>',
	});
	$('.eggnewsCarousel').bxSlider({
		slideWidth: 350,
		minSlides: 1,
		maxSlides: 3,
		slideMargin: 10,
		controls: true,
		auto: true,
		moveSlides: 1,
		prevText: '<i class="fa fa-arrow-left"> </i>',
		nextText: '<i class="fa fa-arrow-right"> </i>',
	});
	//Search toggle
	$('.header-search-wrapper .search-main').click(function () {
		$('.search-form-main').toggleClass('active-search');
		$('.search-form-main .search-field').focus();
	});

	//responsive menu toggle
	$('.bottom-header-wrapper .menu-toggle').click(function () {
		$('.bottom-header-wrapper #site-navigation').slideToggle('slow');
	});
	//responsive sub menu toggle
	$('#site-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-angle-right"></i> </span>');
	$('#site-navigation .sub-toggle').click(function () {
		$(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
		$(this).children('.fa-angle-right').first().toggleClass('fa-angle-down');
	});
	// Scroll To Top
	$(window).scroll(function () {
		if ($(this).scrollTop() > 700) {
			$('#teg-scrollup').fadeIn('slow');
		} else {
			$('#teg-scrollup').fadeOut('slow');
		}
	});
	$('#teg-scrollup').click(function () {
		$('html, body').animate({scrollTop: 0}, 600);
		return false;
	});
	//column block wrap js
	var divs = $('section.eggnews_block_column');
	for (var i = 0; i < divs.length;) {
		i += divs.eq(i).nextUntil(':not(.eggnews_block_column').andSelf().wrapAll('<div class="eggnews_block_column-wrap"> </div>').length;
	}
});
