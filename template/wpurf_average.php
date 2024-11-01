<?php 
/*V1.0.0
Display Average Rating
------
Please retain the above lines of code.
$average_data Array contains the vital data
$html contains the html code that will be outputted to screen. Please ensure all new html code is added to this variable and not outputted directly on this page
*/

$html = "<div class='wpurf-average-rating'>";

$stars_graphic = $average_data[0];
$total_reviews = $average_data[1];

if($average_data==null ){
		$html.="<em>".__("No ratings were found.","wpurf")."</em>";
}else{
	    $html.= $stars_graphic;
	    $html.="<div class='review-count'>( <a href='#reviews'>".$total_reviews."</a> ".__("Reviews","wpurf")." )</div>";
}

$html.="</div>";
