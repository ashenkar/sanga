<?php
/**
 * Front page for the Utility Pro theme
 *
 * @package Utility_Pro
 * @author  Carrie Dils
 * @license GPL-2.0+
 *
 */




add_action( 'genesis_after_header', 'utility_pro_add_home_welcome', 11 );
add_action( 'genesis_after_header', 'utility_pro_add_call_to_action' , 12);
add_action( 'genesis_site_title', 'genesis_seo_site_title' );

//* Enqueue Masonry
wp_enqueue_script( 'masonry' );
//* Initialize Masonry
wp_enqueue_script( 'masonry-init', get_bloginfo( 'stylesheet_directory' ) . '/js/masonry-init.js', '', '', true );



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

/* stop */


// Display latest posts instead of static page

add_filter( 'body_class', 'home_body_class' );
function home_body_class( $classes ) {

   $classes[] = 'home-page';
   return $classes;

}


/**
 * To display entries from a Custom Post Type on site's front page in a 3-column responsive grid. Use this file when you have a static Page set to appear on Front page and when you want to display that Page's content above the CPT entries.
 *
 */

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'homepage_do_loop' , 5);
/**
 * Outputs a custom loop
 *
 * @global mixed $paged current page number if paginated
 * @return void
 */
function homepage_do_loop() {

	global $paged;

	// accepts any wp_query args
	$args = (array(
		'post_type'      => 'post', // Set your CPT name here
	 	'paged'          => $paged,
	 	'posts_per_page' => 12 // Set your desired number of entries per page here
	));

remove_action( 'genesis_entry_content', 'genesis_do_post_image' , 8);
genesis_custom_loop( $args );

}

// Remove entry meta





//Add Post Class Filter
add_filter('post_class', 'sk_post_class');
function sk_post_class($classes) {
	global $loop_counter;
	$classes[] = 'one-third';
	if (($loop_counter + 3) % 3 == 0) {
		$classes[] .= 'first';
	}
	$loop_counter++;
	return $classes;
}





//* Add custom body class to the head
add_filter( 'body_class', 'sk_body_class' );
function sk_body_class( $classes ) {

	$classes[] = 'masonry-page';
	return $classes;

}




// Modify the Excerpt read more link
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {

	return '... <a class="more-link" href="' . get_permalink() . '">Read more</a>';

}


	// Add WordPress archive pagination (accessibility)
	add_action( 'genesis_after_content', 'utility_pro_post_pagination' , 5);
	add_action( 'genesis_before_content', 'utility_pro_post_pagination' , 5 );

	add_action( 'genesis_before_content', 'genesis_do_breadcrumbs' , 4 );
	
	
	//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date] [post_author_posts_link] [post_comments] [post_edit]';
	return $post_info;
}

genesis();