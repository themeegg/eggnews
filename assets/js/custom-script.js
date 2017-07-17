jQuery(document).ready(function () {
    'use strict';
    // Ticker
    jQuery('#teg-newsTicker').bxSlider({
        minSlides: 1,
        maxSlides: 1,
        speed: 3000,
        mode: 'vertical',
        auto: true,
        controls: true,
        prevText: '<i class="fa fa-backward"> </i>',
        nextText: '<i class="fa fa-forward"> </i>',
        pager: false
    });
    // Slider
    jQuery('.eggnewsSlider').bxSlider({
        pager: false,
        controls: true,
        prevText: '<i class="fa fa-chevron-left"> </i>',
        nextText: '<i class="fa fa-chevron-right"> </i>'
    });
    //Search toggle
    jQuery('.header-search-wrapper .search-main').click(function () {
        jQuery('.search-form-main').toggleClass('active-search');
        jQuery('.search-form-main .search-field').focus();
    });
    //widget title wrap
    jQuery('.widget .widget-title,.related-articles-wrapper .related-title').wrap('<div class="widget-title-wrapper"></div>');
    //responsive menu toggle
    jQuery('.bottom-header-wrapper .menu-toggle').click(function () {
        jQuery('.bottom-header-wrapper #site-navigation').slideToggle('slow');
    });
    //responsive sub menu toggle
    jQuery('#site-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-angle-right"></i> </span>');
    jQuery('#site-navigation .sub-toggle').click(function () {
        jQuery(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        jQuery(this).children('.fa-angle-right').first().toggleClass('fa-angle-down');
    });
    // Scroll To Top
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 700) {
            jQuery('#teg-scrollup').fadeIn('slow');
        } else {
            jQuery('#teg-scrollup').fadeOut('slow');
        }
    });
    jQuery('#teg-scrollup').click(function () {
        jQuery('html, body').animate({scrollTop: 0}, 600);
        return false;
    });
    //column block wrap js
    var divs = jQuery('section.eggnews_block_column');
    for (var i = 0; i < divs.length;) {
        i += divs.eq(i).nextUntil(':not(.eggnews_block_column').andSelf().wrapAll('<div class="eggnews_block_column-wrap"> </div>').length;
    }
});