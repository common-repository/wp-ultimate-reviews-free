(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';

		$('#_type').change(function() {
		    if($(this).val() =="pg"){
		    	$('#_woo-choice').hide();
		    	$('#_edd-choice').hide();
		    	$('#_page-choice').show();
		    }else if($(this).val() =="woo"){
		    	$('#_woo-choice').show();
		    	$('#_edd-choice').hide();
		    	$('#_page-choice').hide();
		    }else if($(this).val() =="edd"){
		    	$('#_woo-choice').hide();
		    	$('#_edd-choice').show();
		    	$('#_page-choice').hide();
		    }else{
		    	$('#_woo-choice').hide();
		    	$('#_edd-choice').hide();
		    	$('#_page-choice').hide();
		    }

		});


	});


	
})(jQuery, this);
