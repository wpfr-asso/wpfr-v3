<?php get_header(); ?>

<div id="content" class="blog wide_page">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
			<div class="entry">
				<div class="single_postmetadata">
					<h4>M&eacute;ta</h4>
					<?php if(function_exists('print_link')) { print_link(); } ?>
					<?php if(function_exists('wp_email')) { email_link(); } ?> 
					<?php if(function_exists('the_views')) { echo '<p>Page vue '; the_views(); echo ' fois.</p>'; } ?>			 
					<?php if(function_exists('sociable_html')) { echo sociable_html(); } ?>
				</div>
				
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

<?php if ( is_page(3) ) : ?>
	<!-- ui-dialog -->
	<div style="display:none;">
		<?php
		$post = get_post( $id = 2603 );
		echo $post->post_content;
		?> 
	</div>
<?php endif; ?>
	
<?php get_footer(); ?>