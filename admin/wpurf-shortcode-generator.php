
<div class='admin-padd'>
    <div class='admin-header'>
        <div class='admin-header-left'>
            <img src='<?php echo plugin_dir_url(dirname(__FILE__)); ?>img/logo.png' alt='Shortcode Generator'/>
        </div><div class='admin-header-right'><div class='title'>Shortcode Generator</div></div>
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

	?>  
	<div class="wrap ">
    <div class="wpurf-filter-form">
		<div class='form-option'>
      <h2>Instructions</h2>

			<p>WP Ultimate Reviews Pro allows components are all presented through the use of 3 shortcodes:</p>
			<ol>
				<li>The Review and Rating Display Area - choose how many reviews to display</li>
				<li>The Aggregated/Average Rating Display</li>
				<li>The Review Submission Form - please note, you can also add reviews/testimonials manually in the admin area.</li>
			</ol>
			<p>These shortcodes work independently so you can mix and match which ones you wish to display on your specified pages.<br>
				You can place shortcodes anywhere on your website. Once generated, copy and paste each one directly in to your page or post.<br>
        You can modify the design of the output by modifying your theme's own CSS, or via the plugin's theme files (see readme.txt for more information).</p>

		</div>

     </div>
      <div class="wpurf-filter-form">

       <div class='form-option'>

			<h2>Shortcode 1 - The Review and Rating Display Area</h2>
			</div>
		<div class='form-option'>Max Number of Reviews to Display (0 = all):<br>
			<input id="_max" type="number" min="0" max="9999" value="0" />
		</div>
		
       <div class='form-option'>
       		<input type="button" id="display-shortcode-generator" class="button button-primary" value="Generate Shortcode">
       </div>
       <div class='form-option'>
       	<div id="display-shortcodes" class='form-shortcodes'>Your shortcode will be displayed here...</div>
        <button  id="clp1" class="button copybtn" data-copytarget="#display-shortcodes" disabled><span>Copy Shortcode to Clipboard</span></button>
       </div>
     </div>
      <div class="wpurf-filter-form">
       <div class='form-option'>

			<h2>Shortcode 2 - The Aggregated/Average Rating Display</h2>
					</div>
		
       <div class='form-option'>
       		<input type="button" id="aggregate-shortcode-generator" class="button button-primary" value="Generate Shortcode">
       </div>
       <div class='form-option'>
       	 <div id="aggregate-shortcodes" class='form-shortcodes'>Your shortcode will be displayed here...</div>
         <button  id="clp2" class="button copybtn" data-copytarget="#aggregate-shortcodes" disabled><span>Copy Shortcode to Clipboard</span></button>
       </div>

     </div>
      <div class="wpurf-filter-form">



       <div class='form-option'>

       			<h2>Shortcode 3 - The Review Submission Form</h2>
			
		</div>
		<div class='form-option'>
       		<input type="button" id="form-shortcode-generator" class="button button-primary" value="Generate Shortcode">
       </div>
       <div class='form-option'>
       		<div id="form-shortcodes" class='form-shortcodes'>Your shortcode will be displayed here...</div>
          <button id="clp3" class="button copybtn" data-copytarget="#form-shortcodes" disabled><span>Copy Shortcode to Clipboard</span></button>
       </div>

     </div>
   </div>
   <?php echo wpurf_footer();?>

</div>