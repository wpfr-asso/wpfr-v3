<?php get_header(); ?>

<div id="content" class="blog">

	<?php if (have_posts()) : ?>
		<h2>Toute l'actualité de WordPress</h2>
	
		<?php while (have_posts()) : the_post(); ?>			
		<div class="post">
			<small><?php the_time('l j F Y') ?> - <?php the_author_posts_link(); ?></small>
			<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Lien permanent vers <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<div class="entry">
				<?php the_content('Lire le reste de cet article &raquo;'); ?>
				<div class="clear"></div>
			</div>
			<p class="postmetadata">
				Publié dans <?php the_category(', ') ?> | <?php edit_post_link('Modifier', '', ' | '); ?>  
				<?php comments_popup_link('Aucun commentaire »', '1 commentaire »', '% commentaires »', 'comments-link', 'Les commentaires sont fermés'); ?>
				<?php the_tags('<br />Tags: ', ', ', ''); ?> 
			</p>
		</div>
		<?php endwhile; ?>
		
		<div class="clear"></div>			
		<div class="navigation">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
	
	<?php else : ?>
	
		<?php include (TEMPLATEPATH . '/404.content.php'); ?>	
		
	<?php endif; ?>

</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>