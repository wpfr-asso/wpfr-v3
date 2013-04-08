<?php
/*
 * Template Name: Page des vitrines
 */
?>

<?php get_header(); ?>

<div id="content" class="blog wide_page">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">Lire le reste de cette page &raquo;</p>'); ?>
				<div class="clear"></div>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>		
		<div class="clear"></div>
		
	<?php endwhile; endif; ?>
	<?php edit_post_link('Modifier cette page.', '<p>', '</p>'); ?>
	<div class="clear"></div>
</div>
	
<?php include (STYLESHEETPATH . '/sidebar.list.php'); ?>

<?php get_footer(); ?>