<?php
/**
* Plugin Name: WP Ultimate Reviews FREE
* Plugin URI: http://www.jamestibbles.co.uk/wp-ultimate-reviews/
* Description: Add reviews, testimonials and ratings to your site quickly and easily. Highly customisable.
* Version: 1.0.2
* Author: James Tibbles
* Author URI: http://www.jamestibbles.co.uk
* Author Email: jamestibbles.jt@gmail.com
**/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

include(plugin_dir_path( __FILE__ ) . '/functions/email.php');

include(plugin_dir_path( __FILE__ ) . '/functions/setup.php');

include(plugin_dir_path( __FILE__ ) . '/functions/admin.php');

include(plugin_dir_path( __FILE__ ) . '/functions/reviews-ratings.php');


global $wpurf_version;

$wpurf_version = "1.0.1";


register_activation_hook(__FILE__,'wpurf_install'); //hook must be here in the main function
register_activation_hook(__FILE__,'wpurf_activate');
register_activation_hook( __FILE__, 'wpurf_admin_notice_example_activation_hook' );
add_action( 'admin_notices', 'wpurf_admin_notice_example_notice' );


//handle requests - set up actions

add_action( 'plugins_loaded', 'wpurf_translation_init');

add_shortcode( 'wpurf-display-reviews', 'wpurf_show_reviews' );

add_shortcode( 'wpurf-display-average', 'wpurf_show_average_rating' );

add_shortcode( 'wpurf-display-form', 'wpurf_show_create_review' );



//Allow translation
function wpurf_translation_init() {
    load_plugin_textdomain( 'wpurf', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
