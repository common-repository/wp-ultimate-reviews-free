<?php 
/* Review and Rating functions */


//remove review
function wpurf_remove_review_page(){
    if( current_user_can('editor') || current_user_can('administrator') ){
        global $wpdb;
        
        $params= "pg=".(isset($_GET['pg']) ? $_GET['pg'] : "")."&filter-name=".(isset($_GET['filter-name']) ? $_GET['filter-name'] : "");
        $params.="&filter-rating=".(isset($_GET['filter-rating']) ? $_GET['filter-rating'] : "")."&filter-sort=".(isset($_GET['filter-sort']) ? $_GET['filter-sort'] : "");
        $params.="&filter-ascdesc=".(isset($_GET['filter-ascdesc']) ? $_GET['filter-ascdesc'] : "");

        if(isset($_GET['delid'])){
            if(wpurf_remove_review($_GET['delid'])){
                echo '<script>window.location = "admin.php?page=wpurf_view_reviews&del=1&'.$params.'";</script>'; 
            }else{
                echo '<script>window.location = "admin.php?page=wpurf_view_reviews&del=-1&'.$params.'";</script>';
            }
        }else if(isset($_GET['theids'])){
            $id_array = explode("|",$_GET['theids']);#
            $ok = true;
            foreach($id_array as $id){
                if($id>0){
                    if(!wpurf_remove_review($id)){
                        $ok = false;
                    }
                }
            }
            if($ok){
                 echo '<script>window.location = "admin.php?page=wpurf_view_reviews&dels=1&'.$params.'";</script>';
            }else{
                echo '<script>window.location = "admin.php?page=wpurf_view_reviews&dels=-1&'.$params.'";</script>';
            }
        }
    }
}


function wpurf_remove_review($id){

    if (current_user_can( 'edit_posts' ) ) {
        global $wpdb;
        global $wpurf_reviews;

        //$pid = $wpdb->get_var($wpdb->prepare("SELECT _pid from {$wpurf_reviews} WHERE id=%d;",array($id) )); 

        $wpdb->delete( $wpurf_reviews, array( 'id' => $id ), array( '%d' ) );

        return true;

    }else{

        return false;

    }
}



//update name or review via ajax
function wurf_update_review() {

   $id = (int) $_POST['_review_id'];
   $name = sanitize_text_field(@$_POST['_review_name']);
   $review = wp_kses( @$_POST['_review_review'], array( 
        'a' => array(
            'href' => array(),
            'title' => array(),
            'target' => array()
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
    ));

   $nonce = sanitize_text_field($_POST['_wpurf_nonce']);

   if(  $id!="" && 
        ($name!="" || $review!="") && 
        wp_verify_nonce($nonce, '_review_wpurf_edit_nonce')  
    ){

        global $wpdb;
        global $wpurf_reviews;

        if($name!=""){
            $data = array(
                    '_name' => $name,
                    '_updated' => current_time( 'mysql' )
            );
        }else if($review!=""){
            $data = array(
                    '_review' => $review,
                    '_updated' => current_time( 'mysql' )
            );            
        }

            
        $format = array(
                    '%s',
                    '%s'
        );
        
        $success=$wpdb->update( $wpurf_reviews, $data, array( 'id' => $id ), $format, array( '%d' ) );

        if(!$success){
            echo "0";
        }else{
            echo "1";
        }

   }else{
     echo "0";
   }

   wp_die();
}
add_action( 'wp_ajax_wpdbp_update_free_review', 'wpdbp_update_review' );
add_action( 'wp_ajax_nopriv_wpdbp_update_free_review', 'wurf_update_review' );

//Activate a review
function wpurf_act_review(){

    if( current_user_can('editor') || current_user_can('administrator') ){

        global $wpdb;

        $params= "pg=".(isset($_GET['pg']) ? $_GET['pg'] : "")."&filter-name=".(isset($_GET['filter-name']) ? $_GET['filter-name'] : "");
        $params.="&filter-rating=".(isset($_GET['filter-rating']) ? $_GET['filter-rating'] : "")."&filter-sort=".(isset($_GET['filter-sort']) ? $_GET['filter-sort'] : "");
        $params.="&filter-ascdesc=".(isset($_GET['filter-ascdesc']) ? $_GET['filter-ascdesc'] : "");

        if(isset($_GET['id'])){

            if(wpurf_status_review($_GET['id'],1)){

                echo '<script>window.location = "admin.php?page=wpurf_view_reviews&act=1&'.$params.'";</script>';

            }else{

                echo '<script>window.location = "admin.php?page=wpurf_view_reviews&act=-1&'.$params.'";</script>';

            }

        }else if(isset($_GET['theids'])){

            $id_array = explode("|",$_GET['theids']);

            $ok = true;

            foreach($id_array as $id){

                if($id>0){

                    if(!wpurf_status_review($id,1)){

                        $ok = false;

                    }

                }

            }

            if($ok){

                 echo '<script>window.location = "admin.php?page=wpurf_view_reviews&acts=1&'.$params.'";</script>';

            }else{

                echo '<script>window.location = "admin.php?page=wpurf_view_reviews&acts=-1&'.$params.'";</script>';

            }
        }else{
            echo '<script>window.location = "admin.php?page=wpurf_view_reviews&act=-1&'.$params.'";</script>';
        }
    }
}

//Deactivate a review
function wpurf_deact_review(){

    if( current_user_can('editor') || current_user_can('administrator') ){

        global $wpdb;

        $params= "pg=".(isset($_GET['pg']) ? $_GET['pg'] : "")."&filter-name=".(isset($_GET['filter-name']) ? $_GET['filter-name'] : "");
        $params.="&filter-rating=".(isset($_GET['filter-rating']) ? $_GET['filter-rating'] : "")."&filter-sort=".(isset($_GET['filter-sort']) ? $_GET['filter-sort'] : "");
        $params.="&filter-ascdesc=".(isset($_GET['filter-ascdesc']) ? $_GET['filter-ascdesc'] : "");

        if(isset($_GET['id'])){

            if(wpurf_status_review($_GET['id'],0)){

                echo '<script>window.location = "admin.php?page=wpurf_view_reviews&deact=1&'.$params.'";</script>';

            }else{

                echo '<script>window.location = "admin.php?page=wpurf_view_reviews&deact=-1&'.$params.'";</script>';

            }

        }else if(isset($_GET['theids'])){

            $id_array = explode("|",$_GET['theids']);

            $ok = true;

            foreach($id_array as $id){

                if($id>0){

                    if(!wpurf_status_review($id,0)){

                        $ok = false;

                    }
                }
            }

            if($ok){
                 echo '<script>window.location = "admin.php?page=wpurf_view_reviews&deacts=1&'.$params.'";</script>';
            }else{
                echo '<script>window.location = "admin.php?page=wpurf_view_reviews&deacts=-1&'.$params.'";</script>';
            }

        }else{
            echo '<script>window.location = "admin.php?page=wpurf_view_reviews&deact=-1&'.$params.'";</script>';
        }
    }
}


//Change status of review
function wpurf_status_review($id,$act){

    if (current_user_can( 'edit_posts' ) ) {

        global $wpdb;
        global $wpurf_reviews;

        //If it is not already in this state then set it
        if( wpurf_get_review_status($id)!=$act){

            $data = array(
                    '_active'    => (int)$act,
                    '_updated' => current_time( 'mysql' )
            );
            
            $format = array(
                    '%d',
                    '%s'
            );

            
            $success = $wpdb->update( 
                    $wpurf_reviews, 
                    $data, 
                    array( 'id' => $id ), 
                    $format, 
                    array( '%d' ) 
            );

            return $success;

        }else{
            return false;
        }
    }else{
        return false;
    }
}


function wpurf_get_review_status($id){

    global $wpdb;
    global $wpurf_reviews;
    $curr_state = $wpdb->get_var($wpdb->prepare("SELECT _active from {$wpurf_reviews} where id=%d",array($id))); 
    return $curr_state;
}



//get review array
function wpurf_getReviews($act,$max){
    global $wpdb;
    global $wpurf_reviews; 
    if( (int) $max > 0){
        $limit = "LIMIT 0,".$max;
    }else{
        $limit = "";
    }
    $sql = "SELECT _name,_review,_rating FROM {$wpurf_reviews}  WHERE _active=%d  and _pid=0 ORDER BY _created DESC {$limit};";
    $results = $wpdb->get_results($wpdb->prepare($sql, array($act) ) );
    return $results;
}

//get av rating
function wpurf_getAvRating($act){
    global $wpdb;
    global $wpurf_reviews;
    $sql = "SELECT _rating FROM {$wpurf_reviews}  WHERE _active=%d and _pid=0 ORDER BY _created DESC;";
    $results = $wpdb->get_results($wpdb->prepare($sql, array($act) ) );
    $total = count($results);
    $rating = 0;
    foreach($results as $result){
        $rating+= $result->_rating;
    }

    if(count($results)<1){
        return [-1,null];
    }else{
        $rating = floor($rating / $total);
        return [$rating,count($results)];
    }
}



//Ajax query to save new reviews from User Front End
function wpurf_fe_save_review() {

   $name = sanitize_text_field($_POST['_review_name']);
   $email = sanitize_email($_POST['_review_email']);
   $review = sanitize_text_field($_POST['_review_review']);
   $review = wp_kses( @$_POST['_review_review'], array( 
        'br' => array(),
        'em' => array(),
        'strong' => array(),
        'b' => array(),
   ));
   $rating = (int) $_POST['_review_rating'];
   $nonce = sanitize_text_field($_POST['_review_wpurf_nonce']);

   if (defined('DOING_AJAX') && DOING_AJAX &
        $name!="" && 
        $review!="" && 
        $rating>0 && 
        wp_verify_nonce($nonce, '_review_submit_wpurf_nonce')  
    ){


        global $wpdb;
        global $wpurf_reviews;

        if($type=="global"){
            $pid = 0;
            $type = "";
        }

        $data = array(
                        '_pid' => 0,
                        '_type' => '',
                        '_name' => $name,
                        '_email' => $email,
                        '_review' => $review,
                        '_rating' => $rating,                
                        '_active'    => -1,
                        '_created' => current_time( 'mysql' ),
                        '_updated' => current_time( 'mysql' )
        );

                
        $format = array(
                        '%d',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%d',
                        '%d',
                        '%s',
                        '%s'
        );
        
        $success=$wpdb->insert( $wpurf_reviews, $data, $format );
        $success = true;

        //echo $wpdb->last_error;
        if(!$success){
                echo "0";
        }else{
                wpurf_reviewNotification(get_option("admin_email"),false);
                echo "1";
        }


   }else{
    echo "-1";
   }

   wp_die();
}
add_action( 'wp_ajax_wpurf_save_review', 'wpurf_fe_save_review' );
add_action( 'wp_ajax_nopriv_wpurf_save_review', 'wpurf_fe_save_review' );




//Create a review fom Admin area
function wpurf_create_review($name,$email,$message,$status,$rating){
   $success = 0;

   if(  $name!="" && $message!="" && $rating!="" ){

        global $wpdb;
        global $wpurf_reviews;


     
            $data = array(
                        '_pid' => 0,
                        '_type' => '',
                        '_name' => sanitize_text_field($name),
                        '_email' => sanitize_email($email),
                        '_review' => sanitize_text_field($message),
                        '_rating' => (int) $rating,                
                        '_active'    => (int) $status,
                        '_created' => current_time( 'mysql' ),
                        '_updated' => current_time( 'mysql' )
            );

                
            $format = array(
                        '%d',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%d',
                        '%d',
                        '%s',
                        '%s'
            );
            
            $success=$wpdb->insert( $wpurf_reviews, $data, $format );

        
   }
   if(!$success){
    $success = -1;
   }
   return $success;
}

function wpurf_show_reviews($atts){

        global $html;
        $html = "";        

        wp_enqueue_style('font-awesome-regular-min', plugin_dir_url(dirname(__FILE__))."css/fa-regular.min.css");
        wp_enqueue_style('font-awesome-solid-min', plugin_dir_url(dirname(__FILE__))."css/fa-solid.min.css");

        $a = shortcode_atts(array('max'=>999),$atts);

        global $the_reviews;

        $the_reviews = array();
        
        $max = $a['max'];



        //parse reviews---------------------------------------------    
              
        $review_Array = wpurf_getReviews(1,$max);

        $reviews = wpurf_parse_reviews($review_Array);

        //Display Reviews------------------------------------------------------------




        if(count($reviews)>0){

            $microdata_text_all = "";

            foreach($reviews as $review){

                    array_push($the_reviews, array(stripslashes($review['name']),$review['ratingcode'],stripslashes($review['review'])));

            }

        }


                if('' != locate_template( 'wpurf/wpurf_display.php' ) ){
                    include( locate_template( 'wpurf/wpurf_display.php') );
                }else{
                    include(plugin_dir_path(dirname(__FILE__))."template/wpurf_display.php");
                }
            
                if('' != locate_template( 'wpurf/css/wpurf-global-style.css' ) ){
                  wp_enqueue_style('wpurf-global-style', get_template_directory()."wpurf/css/wpurf-global-style.css");
                }else{
                 wp_enqueue_style('wpurf-global-style', plugin_dir_url(dirname(__FILE__))."template/css/wpurf-global-style.css");
                }

                return $html;


}

function wpurf_show_average_rating($atts){

        wp_enqueue_style('font-awesome-regular-min', plugin_dir_url(dirname(__FILE__))."css/fa-regular.min.css");
        wp_enqueue_style('font-awesome-solid-min', plugin_dir_url(dirname(__FILE__))."css/fa-solid.min.css");
                
        $a = shortcode_atts(array(),$atts);

        global $average_data;
        global $html;

        $html = "";

        $microdata = "";
        
        $average_data = array();

                    $id = 0;
                    $typ = "global";
                    $productname = get_bloginfo('name');
        
        list($ratingamt,$totalcounts) = wpurf_getAvRating(1);


               
        if($ratingamt!=-1){                

                $stars = "<div class='wpurf-stars'>";

                for($i=0; $i<floor($ratingamt);$i++){

                    $stars .= "<span class='star fas fa-star'></span>"; 

                }

                if(floor($ratingamt) < $ratingamt){

                    $stars .= "<span class='star half fas fa-star-half'></span><span class='star half far fa-star overlapper'></span>"; 

                }

                for($i=floor($ratingamt); $i<5;$i++){

                    $stars .= "<span class='star far fa-star none'></span>"; 

                }
                $stars .= "</div>";

                $average_data = [$stars,$totalcounts];
        }else{
                    $average_data = null;
                }


                if('' != locate_template( 'wpurf/wpurf_average.php' ) ){
                    include( locate_template( 'wpurf/wpurf_average.php') );
                }else{
                    include(plugin_dir_path(dirname(__FILE__))."template/wpurf_average.php");
                }

            
                if('' != locate_template( 'wpurf/css/wpurf-global-style.css' ) ){
                   wp_enqueue_style('wpurf-global-style', get_template_directory()."wpurf/css/wpurf-global-style.css");
                }else{
                   wp_enqueue_style('wpurf-global-style', plugin_dir_url(dirname(__FILE__))."template/css/wpurf-global-style.css");
                }

                return $html;

}

function wpurf_show_create_review($atts){

        global $html;
        global $required_data;
        global $stars_graphic;

        $html = "";
        $stars_graphic = "";
        
        wp_enqueue_style('font-awesome-regular-min', plugin_dir_url(dirname(__FILE__))."css/fa-regular.min.css");
        wp_enqueue_style('font-awesome-solid-min', plugin_dir_url(dirname(__FILE__))."css/fa-solid.min.css");

        $a = shortcode_atts(array(),$atts);

        

            $nonce = wp_create_nonce('_review_submit_wpurf_nonce');

            $required_data = "<input type='hidden' id='_review_wpurf_nonce' name='_review_wpurf_nonce' value='".$nonce."' />";    

            $stars_graphic = "<div class='stars' id='rater'>";
            $rnd = rand(0,999)."_".rand(0,999);

            for($i=1; $i<=5;$i++){

                $stars_graphic .= "<div class='star far fa-star none starselecter' data-rating='".$i."' data-rnd='".$rnd."' id='starover_".$rnd."_".$i."'></div>"; 

            }

            $stars_graphic .= "</div>";

            //echo "<script>var ajaxurl = '".admin_url('admin-ajax.php')."';</script>";

            wp_enqueue_script( 'wpurf-create-fe-review-script', plugins_url( '../js/create-fe-review-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );

            wp_localize_script( 'wpurf-create-fe-review-script', 'wpurf_submitter', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

            if('' != locate_template( 'wpurf/wpurf_create.php' ) ){
                include( locate_template( 'wpurf/wpurf_create.php') );
            }else{
                include(plugin_dir_path(dirname(__FILE__))."template/wpurf_create.php");
            }
                
            if('' != locate_template( 'wpurf/css/wpurf-global-style.css' ) ){
                wp_enqueue_style('wpurf-global-style', get_template_directory()."wpurf/css/wpurf-global-style.css");
            }else{
                wp_enqueue_style('wpurf-global-style', plugin_dir_url(dirname(__FILE__))."template/css/wpurf-global-style.css");
            }

        
        return $html;

}



function wpurf_parse_reviews($review_Array){

            $reviews = [];
            $ratingamt_total = 0;
            
            foreach ($review_Array as $key) {

                    $rating_individual = $key->_rating;
                    $ratingamt_total+=$rating_individual;
                    $review_individual = ($key->_review);
                    $name_individual = ($key->_name);

                    $rating_individual_code = "<div class='wpurf-stars'>";

                    for($i=0; $i<floor($rating_individual);$i++){

                        $rating_individual_code .= "<span class='star fas fa-star'></span>"; 

                    }

                    if(floor($rating_individual) < $rating_individual){

                        $rating_individual_code .= "<span class='star half fas fa-star-half'></span><span class='star half far fa-star overlapper'></span>"; 

                    }

                    for($i=floor($rating_individual); $i<5;$i++){

                        $rating_individual_code .= "<span class='star far fa-star none'></span>"; 

                    }

                    $rating_individual_code .="</div>";

                    $reviews[] = ["name"=>$name_individual,"review"=>$review_individual,"rating"=>$rating_individual,"ratingcode"=>$rating_individual_code];

            }
            return $reviews;
}



?>