<?php get_header(); ?>

<div id="content" class="blog archives_container">
	<h2>Résultats de la recherche : &#8216;<?php the_search_query(); ?>&#8217;</h2>
	<div class="stats_search">
		<?php detailResultSearch(); ?>
	</div>
	<br />
	
	<?php
	if ( have_posts() ) :
	$i = 0;
	while (have_posts()) : the_post();
		$i++;
		if ( $i == 1 ) echo '<div class="clear"></div>';
	?>			
		<div class="post <?php if ( $i == 2 ) { echo 'col_right'; $i = 0; } ?>">
			<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Lien permanent vers <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<div class="entry">
				<?php the_excerpt_light(); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php endwhile; ?>
		
		<div class="clear"></div>
		<div class="navigation">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
	
	<?php else : ?>
	
		<?php include (TEMPLATEPATH . '/404.content.php'); ?>	
		
	<?php endif; ?>
	<div class="clear"></div>
</div>

<div id="sidebar1" class="sidebar">
	<ul>
		<?php if ( function_exists('dynamic_sidebar') ) dynamic_sidebar(2); ?>
	</ul>
</div>

<div class="clear"></div>

<?php get_footer(); ?>