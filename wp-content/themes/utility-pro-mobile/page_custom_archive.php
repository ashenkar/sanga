<?php
/**
 * Put together by Sridhar Katakam using the code linked in StudioPress forum post
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/forums/topic/creating-custom-page-templates/#post-82959
 */

//* Template Name: Custom Archive

remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

add_action( 'genesis_before_header', 'genesis_do_nav' );
add_action( 'genesis_after_header', 'utility_pro_add_home_welcome' );
add_action( 'genesis_before_footer', 'utility_pro_add_call_to_action', 1 );
add_action( 'genesis_before_entry' , 'yoastbreadcrumps' );

remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action ('genesis_entry_content', 'featured_image' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Remove standard post content output
remove_action( 'genesis_post_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

add_action( 'genesis_entry_content', 'sk_page_archive_content' );
add_action( 'genesis_post_content', 'sk_page_archive_content' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );

/**
 * This function outputs posts grouped by year and then by months in descending order.
 *
 */
function sk_page_archive_content() {

	global $post;
	echo '<ul class="archives">';
		$lastposts = get_posts('numberposts=-1');
		$year = '';
		$month = '';
		foreach($lastposts as $post) :
			setup_postdata($post);

			if(ucfirst(get_the_time('F')) != $month && $month != ''){
				echo '</ul></li>';
			}
			if(get_the_time('Y') != $year && $year != ''){
				echo '</ul></li>';
			}
			if(get_the_time('Y') != $year){
				$year = get_the_time('Y');
				echo '<li><h2>' . $year . '</h2><ul class="monthly-archives">';
			}
			if(ucfirst(get_the_time('F')) != $month){
				$month = ucfirst(get_the_time('F'));
				echo '<li><h3>' . $month . '</h3><ul>';
			}
		?>
			<li>
				<span class="the_date"><?php the_time('d') ?>:</span>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php
}

remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

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



genesis();