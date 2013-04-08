<?php get_header(); ?>

<div id="content" class="blog wide_page">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); // This also populates the iconsize for the next line ?>
		<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; // This lets us style narrow icons specially ?>
		
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<div class="entry">
				<p class="<?php echo $classname; ?>"><?php echo $attachment_link; ?><br /><?php echo basename($post->guid); ?></p>
				<h3><a href="<?php echo get_permalink($post->post_parent); ?>">Retour à la page précédente</a></h3>
			</div>
		</div>
		
	<?php endwhile; else: ?>
	
		<?php include (TEMPLATEPATH . '/404.content.php'); ?>
		
	<?php endif; ?>
</div>

<?php get_footer(); ?>