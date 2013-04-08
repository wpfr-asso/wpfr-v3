<?php
global $wp_query;
if ( isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] == 'vitrine' ) {
	include( TEMPLATEPATH . '/search.vitrine.php' );
	exit();
} elseif ( isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] == 'faq' ) {
	include( TEMPLATEPATH . '/search.faq.php' );
	exit();
}


get_header(); 
// Todo: mettre 9 artciles
?>

<div id="content" class="blog search">
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
			<p class="postmetadata">Publié dans <?php the_category(', ') ?></p>
		</div>
		<?php endwhile; ?>

		<div class="clear"></div>			
		<div class="navigation">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		
		<div class="clear"></div>
		<?php include (TEMPLATEPATH . '/asides.php'); ?>
		
	<?php else : ?>
	
		<?php include (TEMPLATEPATH . '/404.content.php'); ?>
			
	<?php endif; ?>
</div>
	
<?php get_footer(); ?>