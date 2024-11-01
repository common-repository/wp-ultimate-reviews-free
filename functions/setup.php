<?php
/*Initial setup and preparation*/

global $wpdb;
global $wpurf_reviews;

$wpurf_reviews = $wpdb->prefix . 'wpur_reviews';

add_image_size( 'bd-thumbnail', 400, 300, true );
add_image_size( 'bd-logo-small', 130, 130, true );



function wpurf_install(){

    global $wpdb;
    global $wpurf_reviews;


    $sql="";

    if($wpdb->get_var("show tables like '$wpurf_reviews'") != $wpurf_reviews) 
    {

        $sql .= "CREATE TABLE " . $wpurf_reviews . " (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `_pid` int(11) NOT NULL DEFAULT '0',
            `_type` VARCHAR(3) NOT NULL,
            `_rating` varchar(180) NOT NULL,
            `_name` varchar(180) NOT NULL,
            `_email` varchar(75) NOT NULL,
            `_review` text NOT NULL,
            `_active` FLOAT( 2 ) NOT NULL,
            `_created` datetime NOT NULL,
            `_updated` datetime NOT NULL
        ) ENGINE=MYISAM;";
    }
    

    if($sql!=""){

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

    }

}


 
/**
 * Runs only when the plugin is activated.
 * @since 0.1.0
 */
function wpurf_admin_notice_example_activation_hook() {
 
    /* Create transient data */
    set_transient( 'wpurf-admin-notice-welcome', true, 5 );
}

function wpurf_activate(){
    //on re-activating, perform any updates here   
   /* global $wpdb;
    global $wpurf_reviews;

    $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = {$wpurf_reviews} AND column_name = '_type'"  );

    if(empty($row)){
       $wpdb->query("ALTER TABLE {$wpurf_reviews} ADD _type VARCHAR(3) NOT NULL");
    }*/

} 
 
add_action( 'admin_enqueue_scripts', 'wpurf_media_enqueue' );
function wpurf_media_enqueue($hook) {
    try{
        wp_enqueue_media();
    }catch(Exception $e){
    }
}

/**
 * Admin Notice on Activation.
 * @since 0.1.0
 */
function wpurf_admin_notice_example_notice(){
 
    /* Check transient, if available display notice */
    if( get_transient( 'wpurf-admin-notice-welcome' ) ){
        ?>
        <style>
            .admin-header .admin-header-right .title {
                font-size: 3em;
                font-weight: 300;
                padding: 0;
                line-height: 1em;
                border-left: 2px solid rgba(0, 0, 0, 0.05);
                vertical-align: middle;
                display: block;
                color: rgba(0, 0, 0, 0.55);
            }
            .admin-header .admin-header-left {
                display: inline-block;
                text-align: left;
                -webkit-box-sizing: border-box;
                moz-box-sizing: border-box;
                box-sizing: border-box;
                vertical-align: middle;
            }
            .admin-header .admin-header-right {
                display: inline-block;
                text-align: left;
                -webkit-box-sizing: border-box;
                moz-box-sizing: border-box;
                box-sizing: border-box;
                padding-left: 20px;
                vertical-align: middle;
                padding-top: 20px;
                padding-bottom: 20px;
            }
            .admin-header {
                width: 100%;
                display: block;
                margin: auto;
                border: 0;
                padding: 0 0px;
                line-height: 0;
                background-color: #fff;
                -webkit-box-sizing: border-box;
                moz-box-sizing: border-box;
                box-sizing: border-box;
            }
        </style>
        <div class="updated notice is-dismissible">
                <div class='admin-header'>
                    <div class='admin-header-left'>
                            <img src='<?php echo plugin_dir_url(dirname(__FILE__)); ?>img/logo.png' alt='WP Ultimate Reviews'/>
                    </div><div class='admin-header-right'>
                        <div class='title'>Installed</div>
                        <p>Your review system is installed and ready.<br>
                            Head over to the <a target='_blank' href='admin.php?page=wpurf_shortcodes'>Shortcode Generator</a> to add the shortcodes to your site.</p>
                    </div><div class='clear'></div>
                </div>
        </div>
        <?php
        /* Delete transient, only display this notice once. */
        delete_transient( 'wpurf-admin-notice-welcome' );
    }
}

?>