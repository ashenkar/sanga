<?php
/**
 * Utility Pro.
 *
 * @package      Utility_Pro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

// Load internationalization components

// English users do not need to load the text domain and can comment out or remove
load_child_theme_textdomain( 'utility-pro', get_stylesheet_directory() . '/languages' );

// This file loads the Google fonts used in this theme
require get_stylesheet_directory() . '/includes/google-fonts.php';

// This file contains search form improvements
require get_stylesheet_directory() . '/includes/class-search-form.php';

add_action( 'genesis_setup', 'utility_pro_setup', 15 );
/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function utility_pro_setup() {

	define( 'CHILD_THEME_NAME', 'utility-pro' );
	define( 'CHILD_THEME_URL', 'https://store.carriedils.com/utility-pro' );
	define( 'CHILD_THEME_VERSION', '1.0.0' );

	// Add HTML5 markup structure
	add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

	// Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	// Add support for custom background
	add_theme_support( 'custom-background', array( 'wp-head-callback' => '__return_false' ) );

	// Add support for three footer widget areas
	add_theme_support( 'genesis-footer-widgets', 3 );

	// Add support for additional color style options
	add_theme_support(
		'genesis-style-selector',
		array(
			'utility-pro-purple' =>	__( 'Purple', 'utility-pro' ),
			'utility-pro-green'  =>	__( 'Green', 'utility-pro' ),
			'utility-pro-red'    =>	__( 'Red', 'utility-pro' ),
		)
	);

	// Add support for structural wraps (all default Genesis wraps unless noted)
	add_theme_support(
		'genesis-structural-wraps',
		array(
			'footer',
			'footer-widgets',
			'footernav', // Custom
			'menu-footer', // Custom
			'header',
			'home-gallery', // Custom
			'nav',
			'site-inner',
			'site-tagline',
		)
	);

	// Add support for two navigation areas (theme doesn't use secondary navigation)
	add_theme_support(
		'genesis-menus',
		array(
			'primary'   => __( 'Primary Navigation Menu', 'utility-pro' ),
			'footer'    => __( 'Footer Navigation Menu', 'utility-pro' ),
		)
	);

	// Add theme support aesop
add_theme_support("aesop-component-styles", array("parallax", "image", "quote", "gallery", "content", "video", "audio", "collection", "chapter", "document", "character", "map", "timeline" ) );

      // Add custom image sizes
	add_image_size( 'feature-large', 960, 330, array( 'center', 'center' ) );
	add_image_size( 'feature-post', 1144 );
	add_image_size( 'feature-post-archive', 743, 458, array( 'center', 'center' ) );
	add_image_size( 'feature-post-home', 360, 223, array( 'center', 'center' ) );

	// Unregister secondary sidebar
	unregister_sidebar( 'sidebar-alt' );

	// Unregister layouts that use secondary sidebar
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	// Register the default widget areas
	utility_pro_register_widget_areas();

	// Add Utility Bar above header
	add_action( 'genesis_before_header', 'utility_pro_add_bar' );

	// Add featured image above posts
	
    
	// Add a navigation area above the site footer
	add_action( 'genesis_before_footer', 'utility_pro_do_footer_nav' );

	// Remove Genesis archive pagination (Genesis pagination settings still apply)
	remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

	// Add WordPress archive pagination (accessibility)


	// Load accesibility components if the Genesis Accessible plugin is not active
	if ( ! utility_pro_genesis_accessible_is_active() ) {

		// Load skip links (accessibility)
		include get_stylesheet_directory() . '/includes/skip-links.php';
	}

	// Apply search form enhancements (accessibility)
	add_filter( 'get_search_form', 'utility_pro_get_search_form', 25 );

	// Load files in admin
	if ( is_admin() ) {

		// Add suggested plugins nag
		include get_stylesheet_directory() . '/includes/suggested-plugins.php';

		// Add theme license (don't remove, unless you don't want theme support)
		include get_stylesheet_directory() . '/includes/theme-license.php';
	}
}

/**
 * Add Utility Bar above header.
 *
 * @since 1.0.0
 */
function utility_pro_add_bar() {

	genesis_widget_area( 'utility-bar', array(
		'before' => '<div class="utility-bar"><div class="wrap">',
		'after'  => '</div></div>',
	) );
}


/**
* Add featured image above single posts.
*
* Outputs image as part of the post content, so it's included in the RSS feed.
* H/t to Robin Cornett for the suggestion of making image available to RSS.
*
* @since 1.0.0
*
* @return null Return early if not a single post or there is no thumbnail.
*/







add_filter( 'genesis_footer_creds_text', 'utility_pro_footer_creds' );
/**
 * Change the footer text.
 *
 * @since  1.0.0
 *
 * @return null Return early if not a single post or post does not have thumbnail.
 */
function utility_pro_footer_creds( $creds ) {

	return '[footer_copyright first="2015"] &middot; <a href="http://iskcon.us">Universal Sanga</a>.';
}

add_filter( 'genesis_author_box_gravatar_size', 'utility_pro_author_box_gravatar_size' );
/**
 * Customize the Gravatar size in the author box.
 *
 * @since 1.0.0
 *
 * @return integer Pixel size of gravatar.
 */
function utility_pro_author_box_gravatar_size( $size ) {
	return 96;
}

// Add theme widget areas
include get_stylesheet_directory() . '/includes/widget-areas.php';

// Add footer navigation components
include get_stylesheet_directory() . '/includes/footer-nav.php';

// Add scripts to enqueue
include get_stylesheet_directory() . '/includes/enqueue-assets.php';

// Miscellaenous functions used in theme configuration
include get_stylesheet_directory() . '/includes/theme-config.php';


/**
 * CUSTOM
 * 
 */


add_theme_support ("feature-post");
add_theme_support ("feature-post-archive");
add_theme_support ("feature-post-archive");
add_theme_support ("feature-post-home");

// Enable PHP in widgets
add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}




add_filter( 'genesis_author_box_gravatar_size', 'author_box_gravatar_size' );
function author_box_gravatar_size( $size ) {	return '200'; }



// Featured image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

function site_featured_image() {

if (is_front_page()) 
if ( has_post_thumbnail() ) {
    echo '<div id = "home-post-image">';
    echo get_the_post_thumbnail( $post_id, 'feature-post-home' ); 
	echo '</div>';
                            }
                           
}
                               
add_action( 'genesis_entry_header', 'site_featured_image', 15 );

function sangalogo(){
echo '<div id = "sangalogo">';
echo '<a href="http://iskcon.us/">';
echo '<img src = "http://iskcon.us/wp-content/uploads/2015/05/ISKCON-Us-Logo-4.png">';
echo '</a>';
echo '</div>';
}

add_action ('genesis_site_title', 'sangalogo', 5);


function sangatitlestart(){
echo '<div id = "sangatitle">';
}

function sangatitleend() {
echo '</div>';
}
add_action ('genesis_site_title', 'sangatitlestart', 6);
add_action ('genesis_after_header', 'sangatitleend', 10);


?>
