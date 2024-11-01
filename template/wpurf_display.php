<?php 
/*V1.0.0
Display Review Page
------
Please retain the above lines of code.
$the_reviews is an array of data containing all important review data
$html contains the html code that will be outputted to screen. Please ensure all new html code is added to this variable and not outputted directly on this page
*/

$html='<a name="reviews"></a><div class="wpurf-reviews">';

if(count($the_reviews)==0){

	$html .= '<div class="review">';
    $html .= "<em>".__("No Reviews were found.","wpurf")."</em>";
    $html .= '</div>';


}else{

	foreach($the_reviews as $review){

		$reviewer_name = $review[0];
		$stars_graphic = $review[1];
		$review_text = str_replace("\n","<br>",$review[2]);

		$html .= '<div class="review">';
        $html .= '<div class="review-name"><label>'.__("Reviewer","wpurf").':</label> '.$reviewer_name.'</div>';
		$html .= '<div class="rating-section"><label>'.__("Rating","wpurf").':</label> '.$stars_graphic.'</div>';
        $html .= '<div class="review-text">'.$review_text.'</div>';
		$html .= '</div>';
		 
	}
}

$html .="</div>";
