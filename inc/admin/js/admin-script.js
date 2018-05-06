jQuery(document).ready(function ($) {
	"use strict";

	/**
	 * Script for switch option
	 */
	$('.switch_options').each(function () {
		//This object
		var obj = $(this);

		obj.children('.switch_part.' + input_val);
		var switchPart = obj.children('.switch_part').attr('data-switch');
		var input = obj.children('input'); //cache the element where we must set the value
		var input_val = obj.children('input').val(); //cache the element where we must set the value


		if (obj.children('.switch_part.' + input_val).length > 0) {
			obj.children('.switch_part.' + input_val).addClass('selected');
		}
		obj.children('.switch_part').on('click', function () {
			var switchVal = $(this).attr('data-switch');
			obj.children('.switch_part').removeClass('selected');
			$(this).addClass('selected');

			$(input).val(switchVal).change(); //Finally change the value to 1
		});

	});
	$('body').on('click','.selector-labels label', function(){
		var $this = $(this);
		var value = $this.attr('data-val');
		$this.siblings().removeClass('selector-selected');
		$this.addClass('selector-selected');
		$this.closest('.selector-labels').next('input').val(value);
		$this.closest('.selector-labels').next('input').trigger('change');
	});

	/**
	 * Script for image selected from radio option
	 */
	$('.controls#eggnews-img-container li img').click(function () {
		$('.controls#eggnews-img-container li').each(function () {
			$(this).find('img').removeClass('eggnews-radio-img-selected');
		});
		$(this).addClass('eggnews-radio-img-selected');
	});


});
