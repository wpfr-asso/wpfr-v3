<?php get_header(); ?>

<div id="content" class="blog single">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Lien permanent vers <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<div class="entry">
				<?php the_content('<p class="serif">Lire la suite de l\'article &raquo;</p>'); ?>
				<div class="clear"></div>					
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>					
			</div>		
		</div>
	<?php endwhile; else: ?>
		
		<?php include (TEMPLATEPATH . '/404.content.php'); ?>
		
	<?php endif; ?>
</div>

<div class="global_twocol">
	<div id="author_meta" class="two_col">	
		<?php echo get_avatar( get_the_author_email(), 96 ); ?>
		
		<h4>L'auteur : <?php the_author_posts_link(); ?></h4>
		<p><?php echo nl2br(get_the_author_description()); ?></p>
		
		<div class="clear"></div>
	</div>
	
	<div class="two_col">	
		<h4>Informations annexes à l'article</h4>
		
		<p>Cet article a été publié le <?php the_time('l j F Y') ?> à <?php the_time() ?> et est classé dans <?php the_category(', ') ?>.</p>
		<p>Vous pouvez en suivre les commentaires par le biais du flux <?php comments_rss_link('RSS 2.0'); ?>.</p>
		<p>
		<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) { ?>
			Vous pouvez  <a href="#respond">laisser un commentaire</a>, ou <a href="<?php trackback_url(); ?>" rel="trackback">faire un trackback</a> depuis votre propre site.
		<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) { ?>
			Les commentaires sont fermés, mais vous pouvez  <a href="<?php trackback_url(); ?> " rel="trackback">faire un trackback</a> depuis votre propre site.
		<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) { ?>
			Vous pouvez aller directement à la fin et laisser un commentaire. Les pings ne sont pas autorisés.
		<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) { ?>
			Les commentaires et pings sont fermés.
		<?php } edit_post_link('Modifier cet article.','<br />',''); ?>
		</p>
		<?php if(function_exists('the_views')) { echo '<p>Article lu '; the_views(); echo ' fois.</p>'; } ?>
	</div>
	
	<div class="two_col">
		<h4>Méta</h4>
	
		<?php if(function_exists('the_ratings')) { the_ratings(); } ?> 
		
		<?php if(function_exists('print_link')) { print_link(); } ?>
		<?php if(function_exists('wp_email')) { email_link(); } ?> 		 
		<?php if(function_exists('sociable_html')) { echo sociable_html(); } ?>
		<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="wordpress_fr" data-lang="fr">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	</div>
	
	<div class="two_col" id="relatedposts">
		<h4>Continuez votre lecture sur des sujets similaires</h4>
		
		<?php the_tags('<p>Les tags : ', ', ', '</p>'); ?>
		<?php if(function_exists('similar_posts')) similar_posts(); ?>					
		<div class="clear"></div>					
	</div>
</div>

<div class="clear"></div>
<div class="comments_global">
	<?php comments_template(); ?>		
</div>

<?php get_footer(); ?>