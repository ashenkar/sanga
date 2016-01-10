<?php
/**
 * Front page for the Utility Pro theme
 *
 * @package Utility_Pro
 * @author  Carrie Dils
 * @license GPL-2.0+
 *
 */



add_action( 'genesis_before_header', 'genesis_do_nav' );
add_action( 'genesis_after_header', 'utility_pro_add_home_welcome', 11 );

remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );


// Display content for the "Home Welcome" section
function utility_pro_add_home_welcome() {

	genesis_widget_area( 'utility-home-welcome',
		array(
			'before' => '<div class="home-welcome"><div class="wrap">',
			'after' => '</div></div>',
		)
	);
}


// Display content for the "Call to action" section
function utility_pro_add_call_to_action() {

	genesis_widget_area(
		'utility-call-to-action',
		array(
			'before' => '<div class="call-to-action-bar"><div class="wrap">',
			'after' => '</div></div>',
		)
	);
}

\

add_filter( 'body_class', 'home_body_class' );
function home_body_class( $classes ) {

   $classes[] = 'home-page';
   return $classes;

}



/**
 * To display entries from a Custom Post Type on site's front page in a 3-column responsive grid. Use this file when you have a static Page set to appear on Front page and when you want to display that Page's content above the CPT entries.
 *
 */




// Remove entry meta


//* Remove the post meta function for front page only


function featured_image_archive() {

if ( has_post_thumbnail() ) {
    echo '<div id = "featured-post-archive-image">';
    echo '<a href = "'.post_permalink( $post->$ID ).'">';
    genesis_do_post_image( $post->ID); 
    echo '</a>';
	echo '</div>';
}
}
add_action( 'genesis_entry_header', 'featured_image_archive', 14 );

	// Add WordPress archive pagination (accessibility)
	
	//*  add_action( 'genesis_before_content', 'utility_pro_post_pagination' );  *//
	
	
	
	
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );





//* Add custom body class to the head


	// Add WordPress archive pagination (accessibility)
	add_action( 'genesis_after_content', 'utility_pro_post_pagination' , 5);
	remove_action( 'genesis_before_content', 'genesis_do_breadcrumbs' , 4 );
	
add_action( 'genesis_before_footer', 'utility_pro_add_call_to_action', 1 );

	

genesis();