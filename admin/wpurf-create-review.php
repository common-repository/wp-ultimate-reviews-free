
<div class='admin-padd'>
    <div class='admin-header'>
        <div class='admin-header-left'>
            <img src='<?php echo plugin_dir_url(dirname(__FILE__)); ?>img/logo.png' alt='Create A Review / Testimonial'/>
        </div><div class='admin-header-right'><div class='title'>Create A Review / Testimonial</div></div>
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
}

?>  <div class="wrap">

        <form action="admin.php?page=wpurf_view_reviews" method="POST" class='wpurf-filter-form'>
            <input type='hidden' name='wpurf_add' value="1" />
            <input type='hidden' name='wpurf_nonce' value="<?php echo wp_create_nonce('_review_wpurf_add_nonce'); ?>" />

            <div class='form-option'><strong>Reviewer Name (and/or company) *</strong><br />
                <input type="text" name="_name" id="_name"  value="" size="180" required placeholder="" />    
            </div>
            <div class='form-option'><strong>Email Address</strong><br />
                <input type="email" name="_email" id="_email"  value="" size="75" placeholder="" />    
            </div>
            <div class="form-option"><strong>Rating *</strong><br/>
                <input type="number" name="_rating" id="_rating" size="8" placeholder="" value="5" min="0" max="5" required style="max-width:50px !important;" /> out of 5 
            </div>
            <div class="form-option"><strong>Message *</strong><br/>
                <textarea required name="_message" id="_message"></textarea>
            </div>
            <div class="form-option"><strong>Status</strong><br/>
                <label><input type="checkbox" value="1" id="_status" name="_status" checked /> Enabled</label>
            </div>
            <div class="form-option">
                <input type="submit" value="Save Review" class="button button-primary" id="_submit" />
            </div>
        </form>

   </div>
   <?php echo wpurf_footer();?>

</div>