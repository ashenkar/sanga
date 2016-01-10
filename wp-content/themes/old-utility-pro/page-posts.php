<?php

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'recent_do_loop' );

/**
 * Outputs a custom loop
 *
 * @global mixed $paged current page number if paginated
 * @return void
 */
function recent_do_loop() {

	global $paged;

	// accepts any wp_query args
	$args = (array(
		'post_type'      => 'post', // Set your CPT name here
	 	'paged'          => $paged,
	 	'posts_per_page' => 10 // Set your desired number of entries per page here
	));


genesis_custom_loop( $args );

}

function featured_image_archive() {

if ( has_post_thumbnail() ) {
    echo '<div id = "featured-post-archive-image">';
    echo '<a href = "'.post_permalink( $post->$ID ).'">';
    the_post_thumbnail( $post->ID, 'feature-post-archive' ); 
    echo '</a>';
	echo '</div>';
}
}



  add_filter( 'the_content', 'archive_featured_image' ); 
 
 function archive_featured_image ( $content ) { 
    if ( has_post_thumbnail()) {
        $thumbnail = false;
        $test = TEST35;
        $content = $thumbnail . $content . $test ;
		
		}

    return $content;
}

genesis();

?>