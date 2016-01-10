<?php
/*
YARPP Template: Alexander
Description: Requires a theme which supports post thumbnails
Author: Alexander
*/ ?>
<h3>Related Posts</h3>
<?php if (have_posts()):?>
<ol>
	<?php while (have_posts()) : the_post(); ?>
		<?php if (has_post_thumbnail()):?>
		<li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('feature-post-home'); ?></a></li>
		<?php endif; ?>
	<?php endwhile; ?>
</ol>

<?php else: ?>
<p>No related posts.</p>
<?php endif; ?>
