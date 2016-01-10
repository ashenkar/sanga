=== WP Conditional Shortcodes ===
Contributors: TomHarrigan, jrrl
Tags: shortcode, shortcodes, conditional, conditional tags
Requires at least: 2.5
Tested up to: 3.5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Use conditional tags as shortcodes.

== Description ==

This plugin gives content developers shortcode equivalents to the conditional tags that WordPress provides for theme developments.  Each shortcode only includes its contents if a certain condition is true.  This allows them to modify what content is shown in any given context on a post-by-post basis. is_page, is_single and is_category allow specific pages, posts, categories to be specified by using the "ids" parameter.

The shortcodes and when they include contents are:

* is_single - if showing a single post. Use the optional parameter “ids” to specify specific posts.
* is_singular - if showing a single post or page.
* is_page - if showing a page. Use the optional parameter “ids” to specify specific pages.
* is_home - if showing the blog home.
* is_front_page - if showing the front page of the site.
* is_sticky - if the current post or page is 'sticky'.
* is_category - if showing a category-based archive. Use the optional parameter “ids” to specify specific categories.
* is_page - if showing a page.
* is_tag - if showing a tag-based archive.
* is_tax - if showing a tag- or category-based archive.
* is_author - if showing an author-based archive.
* is_archive - if showing any archive.
* is_year - if showing a yearly archive.
* is_month - if showing a monthly archive.
* is_day - if showing a daily archive.
* is_time - if showing an hourly or shorter archive.
* is_feed - if generating a feed.
* is_search - if showing search results.
* comments_open - if comments are open for the current post or page.

Each shortcode also has an "else" shortcode that can go inside it.  For example:

    [is_single]
    This is only shown if showing just this post.
    [not_single]
    This is shown everywhere else.
    [/is_single]

The is_page, is_category and is_single shortcodes allow you to specify pages, categories, posts on which to show the content if you'd like to only show content within the shortcode on specific pages, posts or categories.

    [is_page ids="76, 339"]hello[/is_page]

    [is_category ids="5, 7"]hello[/is_page]

    [is_single ids="94, 63"]hello[/is_single]

In general, the "else" shortcode is just replacing "is" with "not".  The one exception is "not_comments_open" as the "else" shortcode for "comments_open".

Whichever chunk of content is included is processed for shortcodes, so you can use all your other shortcodes and even nest these if you need to.


== Installation ==

1. Activate the plugin through the 'Plugins' menu in WordPress

== Further Instructions ==

Any other information I have can be found at the [WP Conditional Shortcodes Homepage](http://thomasharrigan.com/wordpress-conditional-shortcodes/).

== Changelog ==

= 1.1.2 = 
* 2013-02-27
* Fixed bug with is_front_page not working

= 1.1.1 = 
* 2013-02-08
* Added parameter to is_single shortcode to allow for specific posts

= 1.1.0 = 
* 2013-02-05
* Forked plugin
* Added parameters to is_category to allow check for specific categories
* Added is_page shortcode
* Added parameter to is_page shortcode to allow for specific pages

= 1.0.0 =
*Initial version, pre-fork
