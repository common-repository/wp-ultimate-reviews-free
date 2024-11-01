(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';

		var i;

		$('.starselecter').on("mouseover",function() {
		    var rating = parseInt($(this).attr("data-rating"));
		    var rnd = $(this).attr("data-rnd");
		    for(i=1;i<=rating;i++){
			    $('#starover_'+rnd+'_'+i).removeClass("none");
			    $('#starover_'+rnd+'_'+i).removeClass("far");
			    $('#starover_'+rnd+'_'+i).addClass("fas");
		    }
		});

		$('.starselecter').on("mouseout",function() {
		    $('.starselecter').addClass("none");
			$('.starselecter').addClass("far");
			$('.starselecter').removeClass("fas");
		});

		$('.starselecter').on("click",function() {
		    $('.starselecter').addClass("none");
			$('.starselecter').addClass("far");
			$('.starselecter').removeClass("fas");
		    var rating = parseInt($(this).attr("data-rating"));
		    var rnd = $(this).attr("data-rnd");
		    $('#_review_rating').val(rating);
		    for(i=1;i<=rating;i++){
			    $('#starover_'+rnd+'_'+i).removeClass("none");
			    $('#starover_'+rnd+'_'+i).removeClass("far");
			    $('#starover_'+rnd+'_'+i).addClass("fas");
		    }
		    $('.starselecter').unbind("mouseout");
		    $('.starselecter').unbind("mouseover");
		});

		/* attach a submit handler to the form */
            $("#wpurf_review_submit").submit(function(event) {

	                /* stop form from submitting normally */
	                event.preventDefault();
	                var $form = $(this);

	                if($form.find('input[name="_review_rating"]').val()<1){
	                	$('#star_validate_text').show();
	                }else{
	                	$('#star_validate_text').hide();
		                $('#review_submit').attr('disabled','disabled');
		                $('#review_submit').prop('value', 'Submitting');
		                /* get some values from elements on the page: */

		                var _name = $form.find('input[name="_review_name"]').val(),
		                    _email = $form.find('input[name="_review_email"]').val(),
		                    _rating = $form.find('input[name="_review_rating"]').val(),
		                    _review = $form.find('textarea[name="_review_review"]').val(),
		                    _nonce = $form.find('input[name="_review_wpurf_nonce"]').val(),
		                    _pid = $form.find('input[name="_review_pid"]').val(),
		                    _type = $form.find('input[name="_review_type"]').val();

		                var data = {
										'action' : "wpurf_save_review",
										'_review_type' : _type,
										'_review_pid' : _pid,
										'_review_wpurf_nonce' : _nonce,
										'_review_rating' : _rating,
										'_review_review' : _review,
										'_review_email' : _email,
										'_review_name' : _name,
										'contentType': "application/x-www-form-urlencoded"
						};
						jQuery.ajax(
					    {
					        type: "post",
					        /*dataType: "json",*/
					        url: wpurf_submitter.ajax_url,
					        data: data,
					        success: function(response){
					               console.log(response);
					            if(response=="1"){
								var content = "<div class='wpurf_success'>"+document.success_text+"</div>";                    	
								$("#wpurf_submit_form_container").find('.wpurf_failed').remove();
								$("#wpurf_submit_form_container").empty().append(content);
							}else{
								var content = "<div class='wpurf_failed'>"+document.fail_text+"</div>";
							    $("#wpurf_submit_form_container").find('.wpurf_failed').remove();
							    $("#wpurf_submit_form_container").append(content);
								$('#review_submit').removeAttr("disabled");
		                		$('#review_submit').prop('value', document.submit_button);
							}
					        },
					        error: function(errorThrown){
					               //alert('error');
					               console.log(errorThrown);
					               var content = "<div class='wpurf_failed'>"+document.fail_text+" (errcode 2)"+"</div>";
								   $("#wpurf_submit_form_container").find('.wpurf_failed').remove();
								   $("#wpurf_submit_form_container").append(content);
								   $('#review_submit').removeAttr("disabled");
		                		   $('#review_submit').prop('value', document.submit_button);
					        }
					    });
					}

            });


	});


	
})(jQuery, this);
