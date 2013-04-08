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
		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h2>Archives du blog</h2>
		<?php } ?>

	<?php
	$i = 0;
	while (have_posts()) : the_post();
		$i++;
		if ( $i == 1 ) echo '<div class="clear"></div>';
	?>			
		<div class="post <?php if ( $i == 2 ) { echo 'col_right'; $i = 0; } ?>">
			<small>
				<strong><?php comments_popup_link('0 commentaire', '1 commentaire', '% commentaires', 'comments-link', ''); ?></strong>
				<?php the_time('j/m/y') ?> - <?php the_author_posts_link(); ?>
			</small>
			<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Lien permanent vers <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<div class="entry">
				<?php
				$img = get_the_image( 'large', true, true );
				if ( !empty($img) ) :
				?>
				<a href="<?php the_permalink() ?>" class="link_thumb"><img class="img_thumb" src="<?php the_thumb( $img, 48, 48, true ); ?>" alt="<?php the_title_attribute(); ?>" /></a>
				<?php endif; ?>
				
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
		<li class="archives"><h2>Archives</h2>
			<ul>
				<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
			</ul>
		</li>
	</ul>
	<div class="clear"></div>
</div>

<div class="clear"></div>
<?php include (TEMPLATEPATH . '/asides.php'); ?>

<?php get_footer(); ?>