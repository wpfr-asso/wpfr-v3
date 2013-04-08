<?php get_header(); ?>

<div id="content" class="blog single">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Lien permanent vers <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<div class="entry">
				<?php the_content('<p class="serif">Lire la suite de l\'article &raquo;</p>'); ?>
				<div class="clear"></div>					
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>					
			</div>		
		</div>
	<?php endwhile; else: ?>
		
		<?php include (TEMPLATEPATH . '/404.content.php'); ?>
		
	<?php endif; ?>
</div>

<div id="sidebar1" class="sidebar">
	<ul>
		<?php if ( function_exists('dynamic_sidebar') ) dynamic_sidebar(2); ?>
	</ul>
</div>

<div class="clear"></div>

<?php get_footer(); ?>