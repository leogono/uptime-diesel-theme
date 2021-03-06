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
	wp_enqueue_script( 'respond-js', get_stylesheet_directory_uri() . '/js/respond.min.js', array(), '1.3.0', false );
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

//* Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = 'Copyright [footer_copyright] &middot; <a href="'.get_bloginfo( 'url' ).'">Uptime Diesel</a>';
	return $creds;
}

add_filter('widget_text', 'do_shortcode');

//add shortcode with attribs
function contact_s($atts, $content = null) {
	extract(shortcode_atts(array(
    'phone'	=> '0409 227 527',
    'url'		=> 'book-now'
	), $atts));
	$contactUs .= '<div class="contact-us">';
	$contactUs .= '<p>Call us now</p>';
	$contactUs .= '<p class="tel">'.$phone.'</p>';
	$contactUs .= '<p><a href="'.get_bloginfo( 'url' ).'/'.$url.'" class="btn btn-contact">Click Here to Book Online</a></p>';
	$contactUs .= '</div>';


	return $contactUs;
}
add_shortcode('contact', 'contact_s');


/** Force full width layout on single posts only*/
add_filter( 'genesis_pre_get_option_site_layout', 'full_width_layout_single_posts' );
function full_width_layout_single_posts( $opt ) {
if ( is_single() ) {
    $opt = 'sidebar-content'; 
    return $opt;
 
    }
 
}

add_action( 'genesis_after_header', 'be_change_sidebar_order' );
/**
 * Swap Primary and Secondary Sidebars on Sidebar-Sidebar-Content
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/switch-genesis-sidebars/
 */
function be_change_sidebar_order() {
 
    $site_layout = genesis_site_layout();
 
    if ( 'sidebar-content' == $site_layout ) {
        // Remove the Primary Sidebar from the Primary Sidebar area.
        remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
 
        // Place the Secondary Sidebar into the Primary Sidebar area.
        add_action( 'genesis_sidebar', 'genesis_do_sidebar_alt' );
    }
 
}

function do_sidebar_alt_icon() {
	echo '<div class="wren-icon"></div>';
}
add_action('genesis_after_sidebar_alt_widget_area', 'do_sidebar_alt_icon');

// Custom Post Type
register_post_type('crews', array(	'label' => 'Crews','description' => 'A list of previous works created.','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => 'crews'),'query_var' => true,'supports' => array('title','editor','excerpt','custom-fields','comments','revisions','thumbnail','author','page-attributes',),'labels' => array (
  'name' => 'Crews',
  'singular_name' => 'Crew',
  'menu_name' => 'Crews',
  'add_new' => 'Add Crew',
  'add_new_item' => 'Add New Crew',
  'edit' => 'Edit',
  'edit_item' => 'Edit Crew',
  'new_item' => 'New Crew',
  'view' => 'View Crew',
  'view_item' => 'View Crew',
  'search_items' => 'Search Crews',
  'not_found' => 'No Crews Found',
  'not_found_in_trash' => 'No Crews Found in Trash',
  'parent' => 'Parent Crew',
),) );

add_image_size( 'crew-photo', 150, 150, TRUE );

function do_crew_member_loop() {
	if(is_page('about')) {
		$args = array(
			'post_type' => 'crews',
			'posts_per_page' => -1
		);
		$the_query = new WP_Query( $args );
		echo '<ul class="crew-list">';
		// The Loop
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post(); ?>
				<li>
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail('thumbnail', array('class' => 'crew-avatar'));
					} ?>
					<h3 class="crew-name"><?php the_title(); ?></h3>
					<div class="crew-desc"><?php the_content(); ?></div>
				</li>
				<?php
			}
		} else {
			// no posts found
		}
		echo '</ul>';
		/* Restore original Post Data */
		wp_reset_postdata();
	}
}
add_action( 'genesis_after_entry', 'do_crew_member_loop' );
