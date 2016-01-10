

<?php
add_action( 'genesis_after_header', 'utility_pro_add_home_welcome' );
add_action( 'genesis_before_footer', 'utility_pro_add_call_to_action', 1 );
add_action( 'genesis_before_entry' , 'yoastbreadcrumps' );


remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action ('genesis_entry_content', 'featured_image' );

remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action ('genesis_entry_content', 'featured_image' );
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



//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = 'Publish date: [post_date] Source: [post_author_posts_link] [post_comments] [post_edit]';
	return $post_info;
}


// Featured image

function single_post_featured_image() {

if ( has_post_thumbnail() ) {
    echo '<div id = "featured-post-image">';
    the_post_thumbnail( $post->ID, 'feature-post' ); 
	echo '</div>';
}
}

add_action( 'genesis_entry_header', 'single_post_featured_image', 14 );

// Post Meta

function post_editor() {

if(get_field('post-editor')) 
{
$editor = the_field('post-editor');
echo '<p>' . $editor[3] . '</p>'; 
}
}
//add_action( 'genesis_entry_header', 'post_editor', 18 );

// Disclaimer
function post_disclaimer() {
if(get_field('disclaimer')) {

echo '<div class="content-box-red"><b>Disclaimer:</b> ';
echo do_shortcode( '[post_author_posts_link]' );
echo ' was not personally involved or connected with the production of this post. </br> Post transcribed, edited and produced by <a href = "http://iskcon.us/source/ashenkar/">Alexander Shenkar</a>.</div>';
}
}
add_action('genesis_entry_header', 'post_disclaimer', 17);


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

// EoEmbed

function featured_oembed() {
if(get_field('media-source')) {

echo '<div class="embed-container-two"><h3>Media Source:</h3>';
the_field('media-source');
echo '</div>';
}
}

add_action('genesis_entry_header', 'featured_oembed', 18);

// Summary Bullets:

function summary_bullets() {

// check if the repeater field has rows of data
if( have_rows('summary_bullets') ):

echo '<div id = "post_summary"><h3>Key Points:</h3><ul>'; 	
// loop through the rows of data
    while ( have_rows('summary_bullets') ) : the_row();
         echo '<li><b>';
        // display a sub field value
        the_sub_field('summary_bullets_row');
        echo '</b></li>'; 
    endwhile;
echo '</ul></div>'; 
else :

    // no rows found

endif;

	
}

add_action('genesis_entry_header', 'summary_bullets', 19);



function post_context() {
if(get_field('post_context')) {

echo '<div class="embed-container-two"><h3>Context:</h3>';
the_field('post_context');
echo '</div>';
}
}

add_action('genesis_entry_header', 'post_context', 17);

// Social Share Buttons
function social_share_buttons() {

echo '<div id = "socialshare">';
echo do_shortcode('[ultimatesocial networks="total, facebook, twitter, comments" align="center"]');
echo '</div>';
}

// Social Share Buttons
function social_share_buttons_two() {

echo '<div id = "socialsharetwo">';
echo do_shortcode('[ultimatesocial networks="total, facebook, twitter, comments" align="center"]');
echo '</div>';
}

add_action( 'genesis_entry_header', 'social_share_buttons', 16 );
add_action( 'genesis_entry_footer', 'social_share_buttons_two', 1 );
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 ); 

add_action('genesis_entry_header', 'theme_author_box', 15);

/* add_action( 'genesis_entry_header', 'genesis_do_author_box_single', 15 ); */


function relatedposts() {


/* echo '<div id = "relatedposts" style = "background: #f9f9f9; padding: 24px;">'; */
	 related_posts();
/*echo '</div>'; */	 
}


function disqusstart() {
	 echo '<div id = "disqus_thread" style = "background: #f9f9f9; padding: 24px;">'; 
	echo '</div>'; 

}

 add_action( 'genesis_after_entry' , 'relatedposts', 1);
add_action( 'genesis_after_entry' , 'disqusstart', 5);



 



genesis();    

?>
