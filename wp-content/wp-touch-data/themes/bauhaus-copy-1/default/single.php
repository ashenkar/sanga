<?php get_header(); ?>


	<div id="content">
		<?php while ( wptouch_have_posts() ) { ?>

			<?php wptouch_the_post(); ?>

			<div class="<?php wptouch_post_classes(); ?>">
				<div class="post-page-head-area bauhaus">
					<span class="post-date-comments">
						<?php if ( bauhaus_should_show_date() ) { ?>
							<?php wptouch_the_time(); ?>
						<?php } ?>
						<?php if ( bauhaus_should_show_comment_bubbles() ) { ?>
							<?php if ( bauhaus_should_show_date() && ( comments_open() || wptouch_have_comments() ) ) echo '&harr;'; ?>
							<?php if ( comments_open() || wptouch_have_comments() ) comments_number( __( 'no comments', 'wptouch-pro' ), __( '1 comment', 'wptouch-pro' ), __( '% comments', 'wptouch-pro' ) ); ?>
						<?php } ?>
					</span>
					<h2 class="post-title heading-font"><?php wptouch_the_title(); ?></h2>
					<?php if ( bauhaus_should_show_author() ) { ?>
						<span class="post-author"><?php the_author(); ?></span>
					<?php } ?>
				</div>

				<div class="post-page-content">
					<?php if ( bauhaus_should_show_thumbnail() && wptouch_has_post_thumbnail() ) { ?>
						<div class="post-page-thumbnail">
							<?php the_post_thumbnail('large', array( 'class' => 'post-thumbnail wp-post-image' ) ); ?>
						</div>
					<?php } ?>


<?php  theme_author_box(); ?>
<?php  social_share_buttons(); ?>
<?php post_context(); ?>
<?php featured_oembed(); ?>
<?php  summary_bullets(); ?>


                                		<?php wptouch_the_content(); ?>

<?php  social_share_buttons(); ?>
									

					<?php if ( bauhaus_should_show_taxonomy() ) { ?>
						<?php if ( wptouch_has_categories() || wptouch_has_tags() ) { ?>
							<div class="cat-tags">
								<?php if ( wptouch_has_categories() ) { ?>
									<?php _e( 'Categories', 'wptouch-pro' ); ?>: <?php wptouch_the_categories(); ?><br />
								<?php } ?>
								<?php if ( wptouch_has_tags() ) { ?>
									<?php _e( 'Tags', 'wptouch-pro' ); ?>: <?php wptouch_the_tags(); ?>
								<?php } ?>
							</div>
						<?php } ?>

						<?php if ( wptouch_has_tags() ) { ?>
						<?php } ?>
					<?php } ?>
				</div>
			</div>

		<?php } ?>
	</div> <!-- content -->

	<?php get_template_part( 'related-posts' ); ?>

	<?php get_template_part( 'nav-bar' ); ?>
	<?php if ( comments_open() || wptouch_have_comments() ) { ?>
		<div id="comments">
			<?php comments_template(); ?>
		</div>
	<?php } ?>

<?php get_footer(); ?>

<?php 
// EoEmbed

function featured_oembed() {
if(get_field('media-source')) {

echo '<div class="embed-container"><h3>Media Source:</h3>';
the_field('media-source');
echo '</div>';
}
}


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

// Social Share Buttons
function social_share_buttons() {

echo '<div id = "socialshare">';
echo do_shortcode('[ultimatesocial networks="total, facebook, twitter, comments" align="center"]');
echo '</div>';
}


?>