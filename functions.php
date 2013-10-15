<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Uptime Diesel Theme' );
define( 'CHILD_THEME_URL', 'http://www.leogono.com/' );
define( 'CHILD_THEME_VERSION', '2.0.1' );

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'genesis_google_fonts' );
function genesis_google_fonts() {
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Lato:400,900,400italic|Anton', array(), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

add_filter('widget_text', 'do_shortcode');

//add shortcode with attribs
function contact_s($atts, $content = null) {
	extract(shortcode_atts(array(
    'phone'	=> '0409 227 527',
    'url'		=>	''
	), $atts));
	$contactUs .= '<div class="contact-us">';
	$contactUs .= '<p>Call us now</p>';
	$contactUs .= '<p class="tel">'.$phone.'</p>';
	$contactUs .= '<p><a href="#" class="btn btn-contact">Click Here to Book Online</a></p>';
	$contactUs .= '</div>';


	return $contactUs;
}
add_shortcode('contact', 'contact_s');