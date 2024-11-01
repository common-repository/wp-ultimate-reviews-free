<?php 
/*-------------------------------Admin functions------------------------------*/

add_action( 'admin_menu', 'wpurf_admin_menu' );
function wpurf_admin_menu() {
	add_menu_page('WP Ultimate Review', 'WP Ultimate Reviews',  'edit_pages', 'wpurf', 'wpurf_view_reviews', 'dashicons-admin-comments', 11  );
    add_submenu_page( 'wpurf', 'View All Reviews', 'View All Reviews', 'edit_pages', 'wpurf_view_reviews', 'wpurf_view_reviews');
    add_submenu_page( 'wpurf', 'Create a Review', 'Create a Review', 'edit_pages', 'wpurf_add_reviews', 'wpurf_add_reviews');
    add_submenu_page( 'wpurf', 'Shortcode Generator', 'Shortcode Generator', 'edit_posts', 'wpurf_shortcodes', 'wpurf_shortcode_generator'  );

    add_submenu_page( 'null', 'Remove Review', 'Remove Review', 'edit_pages', 'wpurf_remove_review_page', 'wpurf_remove_review_page');
    add_submenu_page( 'null', 'Activate Review', 'Activate Review', 'edit_pages', 'wpurf_act_review', 'wpurf_act_review');
    add_submenu_page( 'null', 'Deactivate Review', 'Deactivate Review', 'edit_pages', 'wpurf_deact_review', 'wpurf_deact_review');
}

//Show shortcode generator page
function wpurf_shortcode_generator(){
    wp_enqueue_style('admin-css', plugins_url( '../css/admin.css' , __FILE__ ));
    wp_enqueue_script( 'create-shortcode-free', plugins_url( '../js/create-shortcode-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
    include( plugin_dir_path( __FILE__ ) . '../admin/wpurf-shortcode-generator.php');
}

//Admin - Show all reviews in a list
function wpurf_view_reviews(){ 
    wp_enqueue_style('admin-css', plugins_url( '../css/admin.css' , __FILE__ ));
    wp_enqueue_script( 'view-all-reviews-free', plugins_url( '../js/view-all-reviews-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
    include( plugin_dir_path( __FILE__ ) . '../admin/wpurf-view-all-reviews.php');
}
//Admin - Add review
function wpurf_add_reviews(){ 
    wp_enqueue_style('admin-css', plugins_url( '../css/admin.css' , __FILE__ ));
    wp_enqueue_script( 'create-review-free', plugins_url( '../js/create-review-script.js' , __FILE__ ), array('jquery'), '1.0.0', true );
    include( plugin_dir_path( __FILE__ ) . '../admin/wpurf-create-review.php');
}


function wpurf_footer(){
  global $wpurf_version;
  return "<div class='admin-footer'><div class='admin-footer-left'>WP Ultimate Reviews <strong>v".$wpurf_version."</strong> developed by <a href='https://www.jamestibbles.co.uk' style='color:#6ca23a;' target='_blank'>www.jamestibbles.co.uk</a> - <a href='https://www.jamestibbles.co.uk/wp-ultimate-reviews-pro' target='_blank'>CLICK HERE TO GO PRO</a></div><div class='admin-footer-right'>Need help? Need a bespoke plugin, a custom website or web hosting? <a href='https://www.jamestibbles.co.uk/contact/' style='color:#6ca23a;' target='_blank'>Contact Me</a>.</div></div>";
}



function wpurf_get_admin_table(){
  global $wpdb;
  global $wpurf_reviews;
  $html = "";
  if(isset($_GET['pg'])){
                $page = $_GET['pg'];
  }else{
                $page = 1;
  }
 
  if($page<1){
                $page=1;
  }
  $where = "";
  $order = "ORDER BY a._created Desc";
            if(@$_GET['filter-name']!=""){
                if($where == ""){$where = "WHERE ";}else{$where .= " AND ";}
                $where .= "(a._name = '".$_GET['filter-name']."' or a._name REGEXP '".$_GET['filter-name']."' )";
            }
            if(@$_GET['filter-email']!=""){
                if($where == ""){$where = "WHERE ";}else{$where .= " AND ";}
                $where .= "(a._email = '".$_GET['filter-email']."' or a._email REGEXP '".$_GET['filter-email']."' )";
            }
            if(@$_GET['filter-rating']!=""){
                if($where == ""){$where = "WHERE ";}else{$where .= " AND ";}
                $where .= "(a._rating = ".$_GET['filter-rating']." )";
            }
            if(@$_GET['filter-status']!=""){
                if($where == ""){$where = "WHERE ";}else{$where .= " AND ";}
                $where .= "(a._active = ".$_GET['filter-status']." )";
            }

            if(@$_GET['filter-sort']!=""){

                $order = "ORDER BY ";
                if($_GET['filter-sort']=='email'){
                    $order .= "a._email "; 
                }else if($_GET['filter-sort']=='name'){
                    $order .= "a._name "; 
                }else if($_GET['filter-sort']=='newest'){
                    $order .= "a._created "; 
                }else if($_GET['filter-sort']=='updated'){
                    $order .= "a._updated "; 
                }else if($_GET['filter-sort']=='rating'){
                    $order .= "a._rating "; 
                }
                if($order != "ORDER BY " && @$_GET['filter-ascdesc']=="asc"){
                    $order .= "asc";
                }else if($order != "ORDER BY " && @$_GET['filter-ascdesc']=="desc"){
                    $order .= "desc";
                }
                
            }


            $sql = "SELECT COUNT(a.id) as cnt FROM {$wpurf_reviews} a ".$where;
            $count = $wpdb->get_var($wpdb->prepare($sql, array() ) );

            $perpage=50;
            if($page>1){
                $start = ( ($page)*$perpage)-($perpage);
            }else{
                $start=0;
            }
            $sql = "SELECT a.* FROM {$wpurf_reviews} a ".$where." ".$order." LIMIT %d, %d";
            $results = $wpdb->get_results($wpdb->prepare($sql, array($start,$perpage) ) );

            $brs = array("<br>","<br />","<BR>","<BR />");
   
            foreach($results as $key => $row) {
            
                        $total++;
                        $theid = $row->id;
                        $act= $row->_active;

                        $html.="<tr";

                        if($act==0){
                            $html.=" style='background-color:#FFEFEF !important;'";
                        }else if($act==-1){
                            //to be administered
                            $html.=" style='background-color:#fffaef !important;'";
                        }
                        $html.=">";


                        $acttext = '';
                        if($act==-1){
                            $acttext = "Unmoderated";
                        }else if($act==0){
                            $acttext = "Disabled";
                        }else if($act==1){
                            $acttext = "Enabled";
                        }

                        if(stripslashes($row->_email)==""){
                            $email = "-none-";
                        }else{
                            $email = stripslashes($row->_email);
                        }


                        $html.="<td class='center'><input type='checkbox' class='multi-check 'name='multi-check' value='".$row->id."' /></td><td class='center'><input type='text' value='".stripslashes($row->_name)."' id='reviewer_".$row->id."' size='180' /><br><button class='button edit-name-btn' data-id='".$theid."' style='width: 100%;margin-top:5px;' data-label='Update Name'>Update Name</button></td><td class='center'>".$email."</td><td  class='center' style='width:100px !important;'>".stripslashes($row->_rating)." / 5</td><td class='center'><textarea style='min-height:100px;' id='review_".$row->id."'>".str_replace($brs,"\n",stripslashes($row->_review))."</textarea><br><button class='button edit-review-btn' data-id='".$theid."' style='width: 100%;margin-top:5px;max-width: 500px;' data-label='Update Review'>Update Review</button></td><td class='center' style='width:100px !important;'>".$acttext."</td><td class='center'>".$row->_created."</td><td class='center'>";

                        if($act==-1){
                            $html.="<button class='button act-btn' data-id='".$theid."' style='width: 100%;margin-bottom:3px;'>Enable</button><br><button class='button deact-btn' data-id='".$theid."' style='width: 100%;margin-bottom:3px;'>Disable</button>";
                        }else if($act==0){
                            $html.="<button class='button act-btn' data-id='".$theid."' style='width: 100%;margin-bottom:3px;'>Enable</button>";
                        }else if($act==1){
                            $html.="<button class='button deact-btn' data-id='".$theid."' style='width: 100%;margin-bottom:3px;'>Disable</button>";
                        }
                        $html.="<br><button class='button delete-btn' data-id='".$theid."' style='width: 100%;'>Remove Review</button></td>";
                   

                        $html.="</td></tr>";
                       
            }
            if($total == 0){
                $html.="<tr><td colspan='7'><i>No results found.<br><Br><a href='admin.php?page=wpurf_add_reviews'>Click here to create one</a></i></td></tr>";      
            }
            return  array($html,$count,$perpage,$page);
}

?>