

<?php
add_action( 'genesis_after_header', 'utility_pro_add_home_welcome' );
add_action( 'genesis_before_footer', 'utility_pro_add_call_to_action', 1 );
add_action( 'genesis_before_entry' , 'yoastbreadcrumps' );


remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action ('genesis_entry_content', 'featured_image' );

remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action ('genesis_entry_content', 'featured_image' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

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

// Fill Width Content

function full_width_shortcode() {
if(get_field('full_width_shortcode')) {

echo '<div class="full-width-shortcode">';
$shortcode= get_field('full_width_shortcode');
echo do_shortcode( $shortcode );
echo '</div>';
}
}

add_action('genesis_entry_header', 'full_width_shortcode', 18);

echo '<h2>';
the_field('source_name'); 
echo '</h2>';


 



genesis();    

?>
