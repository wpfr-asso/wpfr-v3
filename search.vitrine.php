<?php get_header(); ?>

<div id="content" class="blog category">

<?php if (have_posts()) : ?>
	<h2>Résultats de la recherche : &#8216;<?php the_search_query(); ?>&#8217;</h2>
	<div class="stats_search">
		<?php detailResultSearch(); ?>
	</div>
	
	<?php
		$i = 0;
		while (have_posts()) : the_post();
			$i++;
			if ( $i == 1 ) echo '<div class="clear"></div>';
		?>			
		<div class="post <?php if ( $i == 3 ) { $i = 0; } ?>">
			
			<!--<small>
				<?php the_time('j/m/Y') ?>
			</small>-->
			<h3 id="post-<?php the_ID(); ?>">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Lien permanent vers <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h3>
			<div class="entry">
				<?php
				$img = get_the_image( 'large', true, true );
				if ( !empty($img) ) :
					?>
					<a href="<?php the_permalink() ?>" class="link_thumb">
						<?php the_post_thumbnail( 'listing-thumbnail' ); ?>
					</a>
					<?php
				endif;
				?>
				<div class="clear"></div>
			</div>
			<?php the_tags('<p class="postmetadata">', ', ', '</p>'); ?>
			
		</div>
		<?php endwhile; ?>

		<div class="clear"></div>
		<div class="navigation">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		
		<div class="clear"></div>

	<?php else : ?>
	
		<?php include (TEMPLATEPATH . '/404.content.php'); ?>
			
	<?php endif; ?>
</div>

<?php include (STYLESHEETPATH . '/sidebar.list.php'); ?>
<?php get_footer(); ?>