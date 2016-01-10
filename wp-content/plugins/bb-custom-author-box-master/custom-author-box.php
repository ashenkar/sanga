<?php
/**
 * Plugin Name: Custom Author Box
 * Plugin URI: http://www.blackbirdconsult.com
 * Description: Customize the Genesis Authorbox
 * Version: 1.0
 * Author: Jason Chafin
 * Author URI: http://www.blackbirdconsult.com
 * License: GPL2
 */
 
 
 // REGISTER STYLES
function plugin_style() { 
	   wp_register_style( 'plugin-style', plugins_url('custom-author-box.css', __FILE__));
	  wp_enqueue_style( 'plugin-style');
	 }

  add_action('wp_enqueue_scripts', 'plugin_style');

//Change contact info methods
function change_contact_info($contactmethods) {
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
    unset($contactmethods['gplus']);
    $contactmethods['website_title'] = 'Website Title';
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['facebook'] = 'Facebook';
    $contactmethods['linkedin'] = 'Linked In';
    $contactmethods['gplus'] = 'Google +';
    return $contactmethods;
}

add_filter('user_contactmethods','change_contact_info',10,1);

//Remove old author box and replace with new one

if ( is_single() ) {
remove_action( 'genesis_entry_header', 'genesis_do_author_box_single', 15 );
add_action('genesis_entry_header', 'theme_author_box', 15);

	}
	

function theme_author_box() {
  $authinfo = "<div class=\"postauthor vcard\">\r\n";
	$authinfo .= "<span class=\"sourceavatar\">".get_avatar(get_the_author_id() , 300)."</span>";
	$authinfo .= "<h4> About the source: "."<span class=\"fn\">".get_the_author_meta('display_name')."</span>" ."</h4>\r\n";
	$authinfo .= "<p><span class=\"note\">" . get_the_author_meta('description') . "</span></p>\r\n";
	
	$facebook = get_the_author_meta('facebook');
	$twitter = get_the_author_meta('twitter');
	$gplus = get_the_author_meta('gplus');
	$blog_title = get_the_author_meta('user_url');

$flength = strlen($facebook);
$tlength = strlen($twitter);
$glength = strlen($gplus);
$llength = strlen($blog_title);
	
$authsocial = "<div class=\"postauthor-bottom\"> <p>\r\n";			
if ($flength > 1) {
	$authsocial .= "<i class=\"fa fa-facebook-official\"></i><a class=\"author-fb url\" href=\"http://facebook.com/" . $facebook . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " on Facebook\">Facebook</a>";
}

if ($glength > 1) {	
	$authsocial .="<i class=\"fa fa-google-plus-square\"></i><a class=\"author-gplus url\" href=\"" . $gplus . "\" rel=\"me\" target=\"_blank\" title=\"" . get_the_author_meta('display_name') . " on Google+\">Google+</a>";
}

if ($tlength > 1) {	
	$authsocial .= "<i class=\"fa fa-twitter-square\"></i><a class=\"author-twitter url\" href=\"http://twitter.com/" . $twitter . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " on Twitter\">Twitter</a>";
}

if ($llength > 1) {	
	$authsocial .= "<i class=\"fa fa-wordpress\"></i><a class=\"author-blog url\" href=\"" . $blog_title . "\" target=\"_blank\" rel=\"nofollow\" title=\"" . get_the_author_meta('display_name') . " Personal Blog\">Website</a>";
}

	$authsocial .= "</p>\r\n";

	$authsocial .= "</div></div>\r\n";
	
	if ( is_single() || is_author() ) {
		echo $authinfo;
		echo $authsocial;
	}
}