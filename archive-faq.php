<?php get_header(); ?>

<div id="content" class="blog archives_container">

	<?php if (have_posts()) : ?>
		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a daily archive */ if (is_day()) { ?>
			<h2>Archive pour la journée du <?php the_time('j F Y'); ?></h2>
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h2>Archive pour le mois de <?php the_time('F Y'); ?></h2>
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h2>Archive pour l'année <?php the_time('Y'); ?></h2>
		<?php } elseif( is_tax() ) { ?>
			<h2>Questions de la rubrique &#8216;<?php echo single_term_title(); ?>&#8217;</h2>
		<?php /* If this is a paged archive */ } else { ?>
			<h2>FAQ</h2>
		<?php } ?>

	<?php
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