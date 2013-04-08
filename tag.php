<?php get_header(); ?>

<div id="content" class="blog category">

	<?php if (have_posts()) : ?>
		<h2>Archive du tag &#8216;<?php single_tag_title(); ?>&#8217;</h2>
		
		<?php
		$i = 0;
		while (have_posts()) : the_post();
			$i++;
			if ( $i == 1 ) echo '<div class="clear"></div>';
		?>			
		<div class="post <?php if ( $i == 2 ) { echo 'col_right'; $i = 0; } ?>">
			<small><?php the_time('l j F Y') ?> - <?php the_author_posts_link(); ?></small>
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
			<p class="postmetadata">
				Publié dans <?php the_category(', ') ?> | <?php edit_post_link('Modifier', '', ' | '); ?>  
				<?php comments_popup_link('Aucun commentaire »', '1 commentaire »', '% commentaires »', 'comments-link', 'Les commentaires sont fermés'); ?>
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

<div class="clear"></div>
<?php include (TEMPLATEPATH . '/asides.php'); ?>

<?php get_footer(); ?>