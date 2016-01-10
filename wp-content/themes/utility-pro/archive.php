<?php

add_action( 'genesis_after_header', 'utility_pro_add_home_welcome', 11 );
remove_action( 'genesis_header', 'genesis_do_header' );

add_action( 'genesis_before_header', 'genesis_do_nav' );
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
add_action( 'genesis_before_content_sidebar_wrap' , 'yoastbreadcrumps' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
// Display content for the "Home Welcome" section


function utility_pro_add_home_welcome() {

	genesis_widget_area( 'utility-home-welcome',
		array(
			'before' => '<div class="home-welcome"><div class="wrap">',
			'after' => '</div></div>',
		)
	);
}


remove_action( 'genesis_before_content', 'genesis_do_author_box_archive' ,8); 
add_filter( 'get_the_author_genesis_author_box_archive', '__return_false' );

add_action('genesis_before_content', 'theme_author_box', 15);


/* add_action ( 'genesis_before_content_sidebar_wrap', 'genesis_taxonomy' , 15);

function genesis_taxonomy() {

if (is_category()||is_tag()) {
	echo '<div id = "taxonomy-archive">';
    genesis_do_breadcrumbs();
	echo '</div>';
}
}
*/



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
	//*add_action( 'genesis_after_content', 'utility_pro_post_pagination' ); *//
	//*  add_action( 'genesis_before_content', 'utility_pro_post_pagination' );  *//
	
	
	
	
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
/*add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 ); */

add_action( 'genesis_before_footer', 'utility_pro_add_call_to_action', 1 );
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

	
	
	

genesis();

?>