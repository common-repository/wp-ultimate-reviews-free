<?php 
/*V1.0.0
Create Review Page
------
Please retain the above lines of code.
Please retain the ids, names, actions and data attributes of the form items below.
$html contains the html code that will be outputted to screen. Please ensure all new html code is added to this variable and not outputted directly on this page.
*/

$html = "<script>";
	$html.="document.success_text='".__("Your review has been submitted for moderation.","wpurf")."';";
	$html.="document.fail_text='".__("Your review could not be submitted at this time.","wpurf")."';";
	$html.="document.submit_button='".__("Submit Review","wpurf")."';";
$html.="</script>";

$html .= "<div class='wpurf-review-create' id='wpurf_submit_form_container' >";
	$html .= "<form id='wpurf_review_submit' method='post' action='wpurf_save_review'>";
		$html .= $required_data; //required hidden data
		$html .= "<div class='line'><label for='_review_name'>".__("Name","wpurf").":</label> <input type='text' name='_review_name'  id='_review_name' placeholder='' maxlength='20'  required /></div>";
		$html .= "<div class='line'><label for='_review_email'>".__("Email","wpurf").":</label> <input type='email' name='_review_email'  id='_review_email' placeholder='".__("Optional","wpurf")."' maxlength='75' /></div>";
		$html .= "<div class='line'><label for='_review_rating'>".__("Rating","wpurf")."<span id='star_validate_text'>(".__("required","wpurf").")</span>:</label>".$stars_graphic."<input type='hidden' name='_review_rating' id='_review_rating'  value='0' /></div>";
		$html .= "<div class='line'><label for='_review_review'>".__("Review","wpurf").":</label> <textarea name='_review_review'  id='_review_review' placeholder='Only <strong>, <em> and <br> HTML tags are allowed...' required ></textarea></div>";
		$html .= "<div class='line'>";
			$html.= "<input type='submit' name='review_submit'  id='review_submit' data-label='Submit Review ›' value='".__("Submit Review","wpurf")." ›' />";
		$html.="</div>";
	$html.="</form>";
$html.="</div>";
