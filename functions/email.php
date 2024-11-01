<?php 
//ADMIN emails----------------------------------------------------------


//Contact admin if new review is posted
function wpurf_reviewNotification($email,$return){

    $blog_title = get_bloginfo();

    $message = "This is an automated email.\n\nA new review is waiting to be moderated at ".$blog_title.". Please log in to your admin area and visit the WP Ultimate Reviews section.";
    $message.="\n\n".network_site_url( '/' );
    $subject = "A review has been posted to your site";
    
    if(wp_mail( $email, $subject, $message, '', array() )){ 
        if($return){return true;}
    }else{
         if($return){return false;}
    }
}