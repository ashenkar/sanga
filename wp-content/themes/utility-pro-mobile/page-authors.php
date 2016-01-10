<?php

add_action( 'genesis_after_header', 'utility_pro_add_home_welcome' );
add_action( 'genesis_before_footer', 'utility_pro_add_call_to_action', 1 );
add_action( 'genesis_before_entry' , 'yoastbreadcrumps' );

remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action ('genesis_entry_content', 'featured_image' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );



// Display content for the "Home Welcome" section

function authorspage(){
$args  = array(
    'meta_query' => array(
                             array( 
                                     'who' => 'authors' // List only authors, not other users
        )
     ),
);
 
$site_url = get_site_url(); //get the site url
// Create the WP_User_Query object
$wp_user_query = new WP_User_Query($args);
// Get the results
$authors = $wp_user_query->get_results();
// Check for results
if (!empty($authors))
{
    // loop trough each author
    foreach ($authors as $author)
    {
         
 
       $author_info = get_userdata($author->ID);
        theme_author_box ();
    }
} else {
    echo 'No authors found';
}
}

add_action ('genesis_entry_content','authorspage');
genesis();
 
?>