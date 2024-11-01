
<div class='admin-padd'>
    <div class='admin-header'>
        <div class='admin-header-left'>
            <img src='<?php echo plugin_dir_url(dirname(__FILE__)); ?>img/logo.png' alt='View All Reviews'/>
        </div><div class='admin-header-right'><div class='title'>View All Reviews</div></div>
        <div class="admin-header-right-ad">
                <div style="width:60%;vertical-align:top;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;display:inline-block;margin:auto;">
                        <strong style="margin-bottom: 0px;height:5px;display: block;">READY TO GO PRO?</strong><br>
                        - Schema.org / Microdata compatible<br>
                        - Google friendly ratings<br>
                        - More shortcode customisations for Microdata<br>
                        - Imports your current reviews<br>
                        - Review the webste, a page or a product</div><div style="width:40%;vertical-align:top;text-align:center;-webkit-box-sizing: border-box;moz-box-sizing: border-box;box-sizing: border-box;display:inline-block;margin:auto;">
                        <strong>LOW PRICE!</strong><br><br><a href="https://www.jamestibbles.co.uk/wp-ultimate-reviews-pro" class="button button-orange" style="height:auto;" target="_blank">GO PRO</a>
                </div>
        </div><div class='clear'></div>
    </div>
    <?php	
    if ( ! current_user_can( 'edit_posts' ) ) {
        echo "<div class='error'>You do not have the correct privileges to access this page</div>"; 
        die();
    };
    ?>
    <div class="wrap">
        <div class='form-option'>
            <p><i>Please modify and amend where required. Reviews are pushed live once accepted.</i></p>
        </div>
        <?php

        $html = "";

        if(@$_POST['wpurf_add']==1 && wp_verify_nonce($_POST['wpurf_nonce'], '_review_wpurf_add_nonce')){
                //Create new review
                $added = wpurf_create_review($_POST['_name'],$_POST['_email'],$_POST['_message'],$_POST['_status'],$_POST['_rating']);
        }
        if(isset($added) && $added==1 ){
                $html="<div class='success'>Review has been successfully added.</div>";
        }else if(isset($added) && $added==-1 ){
                $html="<div class='error'>Error - Review could not be added at this time</div>";
        }else if(@$_GET['del']==1){
                $html="<div class='success'>Review has been successfully removed.</div>";
        }else if(@$_GET['del']==-1){
                $html="<div class='error'>Error - Review could not be removed at this time.</div>";
        }else if(@$_GET['dels']==1){
                $html="<div class='success'>Reviews have been successfully removed.</div>";
        }else if(@$_GET['dels']==-1){
                $html="<div class='error'>Error - One or more review could not be removed at this time. Please check the results in the table below.</div>";
        }else if(@$_GET['edit']==1){        
                $html="<div class='success'>Review has been successfully edited.</div>";
        }else if(@$_GET['edit']==-1){
                $html="<div class='error'>Error - Review could not be edited at this time.</div>";
        }else if(@$_GET['act']==1){
                $html="<div class='success'>Review has been enabled.</div>";
        }else if(@$_GET['act']==-1){
                $html="<div class='error'>Error - Review could not be enabled at this time.</div>";
        }else if(@$_GET['acts']==1){
                $html="<div class='success'>Reviews have been enabled.</div>";
        }else if(@$_GET['acts']==-1){
                $html="<div class='error'>Error - One or more reviews could not be enabled at this time. Please check the results in the table below.</div>";
        }else if(@$_GET['deact']==1){
                $html="<div class='success'>Review has been disabled.</div>";
        }else if(@$_GET['deact']==-1){
                $html="<div class='error'>Error - Review could not be disabled at this time.</div>";
        }else if(@$_GET['deacts']==1){
                $html="<div class='success'>Reviews have been disabled.</div>";
        }else if(@$_GET['deacts']==-1){
                $html="<div class='error'>Error - One or more reviews could not be disabled at this time. Please check the results in the table below.</div>";
        }
        echo @$html;

        ?>
        <form action="" method="GET" class='wpurf-filter-form'>
            <input type='hidden' name='page' value='wpurf_view_reviews' />
            <input type='hidden' name='pg' value='<?php echo @$_GET['pg']; ?>' />
            <input type='hidden' id='wpurf_nonce' name='wpurf_nonce' value="<?php echo wp_create_nonce('_review_wpurf_edit_nonce'); ?>" />

            <div class='wpurf-form-title'>Reviewer Name Filter:</div><div class='wpurf-form-field'><input type='text' name='filter-name' id='filter-name' placeholder='Enter reviewer name...' value='<?php echo @$_GET['filter-name']; ?>' /></div><div class='wpurf-form-title'>Rating Filter:</div><div class='wpurf-form-field'><select name='filter-rating' id='filter-rating'  style='width:90px;'><option value='' selected>Any</option><option value='5' <?php if(@$_GET['filter-rating']=="5"){ echo "selected"; }?>>5</option><option value='4' <?php if(@$_GET['filter-rating']=="4"){ echo "selected"; }?>>4</option><option value='3' <?php if(@$_GET['filter-rating']=="3"){ echo "selected"; }?>>3</option><option value='2' <?php if(@$_GET['filter-rating']=="2"){ echo "selected"; }?>>2</option><option value='1' <?php if(@$_GET['filter-rating']=="1"){ echo "selected"; }?>>1</option><option value='0' <?php if(@$_GET['filter-rating']=="0"){ echo "selected"; }?>>0</option></select></div><div class='wpurf-form-title'>Email Filter:</div><div class='wpurf-form-field'><input type='email' name='filter-email' id='filter-email' placeholder='Enter email...' value='<?php echo @$_GET['filter-email']; ?>' /></div><div class='wpurf-form-title'>Status:</div><div class='wpurf-form-field'><select name='filter-status' id='filter-status'><option value='' selected>Any</option><option value='1' <?php if(@$_GET['filter-status']=="1"){ echo "selected"; }?>>Enabled</option><option value='0'  <?php if(@$_GET['filter-status']=="0"){ echo "selected"; }?>>Disabled</option><option value='-1' <?php if(@$_GET['filter-status']=="-1"){ echo "selected"; }?>>Unmoderated</option></select></div><div class='wpurf-form-title'>Sort By:</div><div class='wpurf-form-field'><select name='filter-sort' id='filter-sort'  style='width:90px;'><option value='' selected>Any</option><option value='rating' <?php if(@$_GET['filter-sort']=="rating"){ echo "selected"; }?>>Rating</option><option value='name' <?php if(@$_GET['filter-sort']=="name"){ echo "selected"; }?>>Name</option><option value='email' <?php if(@$_GET['filter-sort']=="email"){ echo "selected"; }?>>Email</option><option value='newest' <?php if(@$_GET['filter-sort']=="newest"){ echo "selected"; }?>>Newest</option><option value='updated' <?php if(@$_GET['filter-sort']=="updated"){ echo "selected"; }?>>Updated</option></select><select name='filter-ascdesc' id='filter-ascdesc' style='width:90px;'><option value='' selected>Any</option><option value='desc' <?php if(@$_GET['filter-ascdesc']=="desc"){ echo "selected"; }?>>Desc</option><option value='asc' <?php if(@$_GET['filter-ascdesc']=="asc"){ echo "selected"; }?>>Asc</option></select> <input type='submit' class="button button-primary" value='Filter Results' /></div>
        </form>
        <table class='wpurf-all-table wp-list-table widefat fixed striped posts'>
            <thead><tr><th class='center' style='width:15px;'></th><th class='center' style='width:200px;'>Reviewer</th><th class='center' style='width:140px;'>Email</th><th class='center' style='width:80px !important;'>Rating</th><th class='center'>Review</th><th class='center' style='width:80px !important;'>Status</th><th class='center' style='width:140px;'>Created</th><th class='center' style='width:140px;'>Options</th></tr></thead><?php list($html,$count,$perpage,$page) = wpurf_get_admin_table(); echo $html; ?>
        </table>

        <div class="under-table">
            <div class="left">
                <span id="multi-select-span">With Selected: </span><select id='multi-select-option'><option value=''>--Select--</option><option value='enable'>Enable</option><option value='disable'>Disable</option><option value='rem'>Remove</option></select>
            </div><div class="right">
                <?php //echo wpurf_pagination('admin.php?page=wpurf_view_reviews',$count,$perpage,$page); ?>
            </div>
        </div>


        <div style='margin-top:40px;'><a href='admin.php?page=wpurf_add_reviews'  class='button button-primary'>+ Create New Testimonial/Review</a></div>

   </div>
    <?php echo wpurf_footer();?>

</div>