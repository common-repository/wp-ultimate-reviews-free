(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';

		function copyToClipboard(element) {
		  var $temp = $("<input>");
		  $("body").append($temp);
		  $temp.val($(element).text()).select();
		  document.execCommand("copy");
		  $temp.remove();
		}

		$('.copybtn').on("click",function(){
			copyToClipboard($(this).attr("data-copytarget"));
			var obj = $(this).find("span");
			obj.text('Shortcode Copied');
			var parobj = $(this);
			parobj.addClass("copied");
			setTimeout(function() {obj.text('Copy Shortcode to Clipboard');parobj.removeClass("copied"); }, 1500);
		});



		$('#display-shortcode-generator').on("click",function(){
			var shortcode = "[wpurf-display-reviews";
			
			if($('#_max').val()>0){
				shortcode+=" max="+$('#_max').val();
			}
			
			shortcode+="]";
			$('#display-shortcodes').html(shortcode);
			$('#clp1').removeAttr('disabled');
		});



		$('#aggregate-shortcode-generator').on("click",function(){
			var shortcode = "[wpurf-display-average";
			shortcode+="]";
			$('#aggregate-shortcodes').html(shortcode);
			$('#clp2').removeAttr('disabled');
		});

		$('#form-shortcode-generator').on("click",function(){
			var shortcode = "[wpurf-display-form";
			shortcode+="]";
			$('#form-shortcodes').html(shortcode);
			$('#clp3').removeAttr('disabled');
		});

	});


	
})(jQuery, this);
