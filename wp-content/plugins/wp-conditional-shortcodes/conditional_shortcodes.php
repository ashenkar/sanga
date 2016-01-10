<?php
/**
 * @package WP Conditional Shortcodes
 * @author Tom Harrigan, John Leavitt
 * @version 1.1.2
 */
/*
Plugin Name: WP Conditional Shortcodes
Plugin URI: http://thomasharrigan.com/wordpress-conditional-shortcodes/
Description: Provides a set of shortcodes for conditionally including content in a post based on context.
Author: Tom Harrigan, John Leavitt
Version: 1.1.2
Author URI: http://thomasharrigan.com/
*/




class jrrl_conditional_shortcode_handler {

  function generic_handler ($atts, $content, $condition, $elsecode) {
    //    $elsecode = str_replace ('[', '\[', $elsecode);
    list ($if, $else) = explode ($elsecode, $content, 2);
    //    list ($if, $else) = preg_split("/$elsecode/i", $content, 2);
    /*    error_log(sprintf("elsecode = \"$elsecode\""));
     
    error_log(sprintf("content = \"$content\""));
    error_log(sprintf("if = [%s]\n", $if));
    error_log(sprintf("else = [%s]\n", $else));  */
    return do_shortcode($condition ? $if : $else);
  }
  
  function is_single_shortcode_handler ($atts, $content="") {
  	if ( ! empty( $atts['ids'] ) ) {
		$atts['include'] = $atts['ids'];
		extract( shortcode_atts( array(	'include' => ''), $atts ) );
		foreach((array)$include as $f){
	        $f = split(",",$f);
	    }
        if(count($f) == 1)
       		$f =$include;
      
        return $this->generic_handler ($atts, $content, is_single($f), '[not_single]');
    }
    return $this->generic_handler ($atts, $content, is_single(), '[not_single]');
  }
  
  function is_page_shortcode_handler ($atts, $content="") {
  	if ( ! empty( $atts['ids'] ) ) {
		$atts['include'] = $atts['ids'];
		extract( shortcode_atts( array(	'include' => ''), $atts ) );
		foreach((array)$include as $f){
	        $f = split(",",$f);
	    }
        if(count($f) == 1)
       		$f =$include;
      
        return $this->generic_handler ($atts, $content, is_page($f), '[not_page]');
    }
    return $this->generic_handler ($atts, $content, is_page(), '[not_page]');
  }

  function is_singular_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_singular(), '[not_singular]');
  }
  
  function is_home_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_home(), '[not_home]');
  }
  
  function is_front_page_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_front_page(), '[not_front_page]');
  }
  
  function is_sticky_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_sticky(), '[not_sticky]');
  }
  
  function is_category_shortcode_handler ($atts, $content="") {
  	if ( ! empty( $atts['ids'] ) ) {
		$atts['include'] = $atts['ids'];
		extract( shortcode_atts( array(	'include' => ''), $atts ) );
		foreach((array)$include as $f){
	        $f = split(",",$f);
	    }
        if(count($f) == 1)
       		$f =$include;
      
        return $this->generic_handler ($atts, $content, is_category($f), '[not_category]');
    }
    return $this->generic_handler ($atts, $content, is_category(), '[not_category]');
  }
  
  function is_tag_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_tag(), '[not_tag]');
  }
  
  function is_tax_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_tax(), '[not_tax]');
  }
  
  function is_author_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_author(), '[not_author]');
  }
  
  function is_archive_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_archive(), '[not_archive]');
  }
  
  function is_date_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_date(), '[not_date]');
  }
  
  function is_year_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_year(), '[not_year]');
  }
  
  function is_month_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_month(), '[not_month]');
  }
  
  function is_day_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_day(), '[not_day]');
  }
  
  function is_time_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_time(), '[not_time]');
  }
  
  function is_feed_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_feed(), '[not_feed');
  }

  function is_search_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, is_search(), '[not_search]');
  }
  
  function comments_open_shortcode_handler ($atts, $content="") {
    return $this->generic_handler ($atts, $content, comments_open(), '[not_comments_open]');
  }
  
}




$jrrl_conditional_shortcode_handler = new jrrl_conditional_shortcode_handler;

add_shortcode('is_single',     array($jrrl_conditional_shortcode_handler, 'is_single_shortcode_handler'));
add_shortcode('is_page',       array($jrrl_conditional_shortcode_handler, 'is_page_shortcode_handler'));
add_shortcode('is_singular',   array($jrrl_conditional_shortcode_handler, 'is_singular_shortcode_handler'));
add_shortcode('is_home',       array($jrrl_conditional_shortcode_handler, 'is_home_shortcode_handler'));
add_shortcode('is_front_page', array($jrrl_conditional_shortcode_handler, 'is_front_page_shortcode_handler'));
add_shortcode('is_sticky',     array($jrrl_conditional_shortcode_handler, 'is_sticky_shortcode_handler'));
add_shortcode('is_category',   array($jrrl_conditional_shortcode_handler, 'is_category_shortcode_handler'));
add_shortcode('is_tag',        array($jrrl_conditional_shortcode_handler, 'is_tag_shortcode_handler'));
add_shortcode('is_tax',        array($jrrl_conditional_shortcode_handler, 'is_tax_shortcode_handler'));
add_shortcode('is_author',     array($jrrl_conditional_shortcode_handler, 'is_author_shortcode_handler'));
add_shortcode('is_archive',    array($jrrl_conditional_shortcode_handler, 'is_archive_shortcode_handler'));
add_shortcode('is_year',       array($jrrl_conditional_shortcode_handler, 'is_year_shortcode_handler'));
add_shortcode('is_month',      array($jrrl_conditional_shortcode_handler, 'is_month_shortcode_handler'));
add_shortcode('is_day',        array($jrrl_conditional_shortcode_handler, 'is_day_shortcode_handler'));
add_shortcode('is_time',       array($jrrl_conditional_shortcode_handler, 'is_time_shortcode_handler'));
add_shortcode('is_feed',       array($jrrl_conditional_shortcode_handler, 'is_feed_shortcode_handler'));
add_shortcode('is_search',     array($jrrl_conditional_shortcode_handler, 'is_search_shortcode_handler'));
add_shortcode('comments_open', array($jrrl_conditional_shortcode_handler, 'comments_open_shortcode_handler'));


?>