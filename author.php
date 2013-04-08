<?php 
get_header();

// Init current author
$current_author = new Author();
?>

<div id="content" class="blog author">

	<?php if (have_posts()) : ?>
		<h2>Articles écrits par <?php echo $current_author->get_the_author(); ?></h2>

		<?php
		$i = 0;
		while (have_posts()) : the_post();
			$i++;
			if ( $i == 1 ) echo '<div class="clear"></div>';
		?>			
			<div class="post <?php if ( $i == 2 ) { echo 'col_right'; $i = 0; } ?>">
			<small>
				<strong><?php comments_popup_link('0 commentaire', '1 commentaire', '% commentaires', 'comments-link', ''); ?></strong>
				<?php the_time('j/m/y') ?>
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
			<p class="postmetadata">Publié dans <?php the_category(', ') ?><?php the_tags('<br />Tags: ', ', ', ''); ?></p>
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

<div id="author_meta" class="two_col">
	<?php echo get_avatar( $current_author->get_the_author_email(), 96 ); ?>

	<h4><span><?php echo $current_author->get_the_author(); ?></span></h5>
	<p><?php echo $current_author->get_the_author_description(); ?></p>
	
	<?php 
	$nb_post = $current_author->count('post'); 
	$nb_comm = $current_author->count('comment');
	?>
	<div>Il a écrit:
		<ul>
			<li><?php echo $nb_post; ?> article<?php if ( $nb_post > 1 ) echo 's'; ?></li>
			<li><?php echo $nb_comm; ?> commentaire<?php if ( $nb_comm > 1 ) echo 's'; ?> <small>(en mode connecté)</small></li>
		</ul>
	</div>
</div>
	
<?php get_sidebar(); ?>

<div class="clear"></div>
<?php include (TEMPLATEPATH . '/asides.php'); ?>

<?php get_footer(); ?>
