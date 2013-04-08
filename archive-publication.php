<?php
global $wp_query;
get_header();

?>

<div id="content" class="blog archives_container">

	<?php if (have_posts()) : ?>
		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php if( is_tax('type-publication') ) { ?>
			<h2>Publications du type &#8216;<?php echo single_term_title(); ?>&#8217;</h2>
		<?php } elseif( is_tax() ) { ?>
			<h2>Publications de la rubrique &#8216;<?php echo single_term_title(); ?>&#8217;</h2>
		<?php /* If this is a paged archive */ } else { ?>
			<h2>Déjà <?php echo count($wp_query->posts); ?> publications !</h2>
		<?php } ?>

	<?php
	$i = 0;
	while (have_posts()) : the_post();
		$i++;
		if ( $i == 1 ) echo '<div class="clear"></div>';
	?>			
		<div class="post <?php if ( $i == 2 ) { echo 'col_right'; $i = 0; } ?>">
			<small>
				<?php the_terms( get_the_ID(), 'type-publication', '', ', ', '' ); ?>
				- <span style="font-weight:700;"><a href="<?php echo get_post_meta( get_the_ID(), 'lien_amazon', true ); ?>" target="_blank">Acheter</a></span>
			</small>
			<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Lien permanent vers <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<div class="entry">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink() ?>" class="link_thumb">
						<?php the_post_thumbnail( 'listing-publi-thumbnail' ); ?>
					</a>
				<?php endif; ?>
				
				<?php the_excerpt_light(); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php endwhile; ?>
		
		<div class="clear"></div>
	
	<?php else : ?>
	
		<?php include (TEMPLATEPATH . '/404.content.php'); ?>	
		
	<?php endif; ?>
	<div class="clear"></div>
</div>

<div id="sidebar1" class="sidebar">
	<ul>
		<li class="widget widget_text">
			<!--<h2 class="widgettitle">Publications</h2>-->
			<div class="textwidget">
				<p>Retrouvez ici l'ensemble des publications réalisées autour de WordPress.</p>
				<p>Si vous planifiez l'achat d'une de ses ressources, n'oubliez pas de passer par les liens de cette rubrique afin de soutenir les activités de l'association par le biais du programme d'affiliation d'Amazon.</p>
			</div>
		</li>
		
		<li><h2>Types</h2>
			<ul>
				<?php wp_list_categories('title_li=&taxonomy=type-publication&show_count=1'); ?>
			</ul>
		</li>
		
		<li><h2>Sujets abordés</h2>
			<ul>
				<?php wp_list_categories('title_li=&taxonomy=sujet-publication&show_count=1'); ?>
			</ul>
		</li>
	</ul>
	<div class="clear"></div>
</div>

<div class="clear"></div>
<?php include (TEMPLATEPATH . '/asides.php'); ?>

<?php get_footer(); ?>