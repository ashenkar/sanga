<?php
/*
YARPP Template: Alexander
Description: Related thumbs
Author: Alexander
*/ ?>

<style>
	 
	 @media all and (min-width: 0px) and (max-width: 480px) { 
	 .relatedpost {
	 width: 100% !important;
	 max-width: 480px !important;
	 }
	 }
	  @media all and (min-width: 480px) and (max-width: 720px) { 
	 .relatedpost {
	 width: 48% !important;
	 max-width: 360px !important;
	 }
	 }
	 
	 #featured-post-archive-image {
     overflow: hidden !important;
     
      .yarpp-related {
	     margin: 0px !important;
     }
}

</style>

<h3>Related Posts</h3>
<?php if (have_posts()):?>

	<?php while (have_posts()) : the_post(); ?>
		<?php if (has_post_thumbnail()):?>
		<div class ="relatedpost" style ="width: 33%;">
		<article class=" post type-post status-publish format-standard has-post-thumbnail entry feature"><a href="<?php the_permalink() ?>" rel="bookmark">
		
		<h4 class="entry-title" itemprop="headline">
		<?php the_title(); ?></a><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
		</h4> 
		<div id="featured-post-archive-image">
		<?php the_post_thumbnail('feature-post-home'); ?></a>
		</div>
		</article>
		</div>
		<?php endif; ?>
	<?php endwhile; ?>


<?php else: ?>
<p>No related posts.</p>
<?php endif; ?>
