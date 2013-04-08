<?php get_header(); ?>

<div id="content" class="blog single">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2>
				<a href="<?php echo get_permalink() ?>" rel="bookmark" title="Lien permanent vers <?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
				<a href="<?php echo esc_url(get_post_meta( get_the_ID(), 'lien_amazon', true )); ?>" target="_blank">
					<span>Acheter</span>
				</a>
			</h2>
			
			<div class="top-meta">
				<?php the_terms( get_the_ID(), 'type-publication', '<span style="font-weight:700;">', ', ', '</span> | ' ); ?>
				<?php the_terms( get_the_ID(), 'sujet-publication', '', ', ', '' ); ?>
			</div>
			
			<div class="entry">
				<?php the_content('<p class="serif">Lire la suite de l\'article &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
	<?php endwhile; else: ?>
		
		<?php include (TEMPLATEPATH . '/404.content.php'); ?>
		
	<?php endif; ?>
</div>

<div class="global_twocol">
	<div class="two_col back-link">
		<a href="<?php echo get_post_type_archive_link('publication'); ?>">Retour à la liste des publications</a>
	</div>
	
	<div class="two_col big-image">
		<?php the_post_thumbnail( 'single-thumbnail' ); ?>
		<div class="clear"></div>
	</div>
	
	<div class="two_col back-link">
		<a href="<?php echo esc_url(get_post_meta( get_the_ID(), 'lien_amazon', true )); ?>" target="_blank">Acheter</a>
	</div>
</div>

<?php get_footer(); ?>