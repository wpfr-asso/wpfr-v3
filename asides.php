<div class="clear"></div>
<div id="asides">
	<div class="latest_post">
		<h4><span>Blog:</span> le dernier article</h4>
		<?php
			$last_post = get_posts('numberposts=1'); // Get the latest post from category ?
			$post = $last_post[0];
			$featured_post = $post->ID;
			setup_postdata($post);
		?>
		<div class="lp_text">
			<span><?php the_time('d/m/y'); ?> - <?php the_author_posts_link(); ?></span>
			 <h2><a href="<?php the_permalink(); ?>" title="Lire la suite de <?php the_title_attribute(); ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></a></h2>

				<a href="<?php the_permalink() ?>" class="link_thumb">
					<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img_thumb' ) ); ?>
				</a>
			 <?php the_excerpt(); ?>
			
			<a href="<?php bloginfo('rss2_url'); ?>" class="button flux_rss" title="Flux RSS">Flux RSS</a>
			<a href="<?php the_permalink(); ?>" rel="nofollow" class="button read-more" title="Lire la suite de <?php the_title_attribute(); ?>">Lire l'article</a>	
		</div>
		<?php
		unset($post); // Delete current post
		wp_reset_postdata();
		?>
	</div>
	<div class="latest_posts">
		<h4><span>Blog:</span> les archives</h4>		
		
		<?php
		$lastest_posts = get_posts('numberposts=5&exclude='.$featured_post); // Get 3 latest posts except the featured post
		foreach( (array) $lastest_posts as $post ) :
			setup_postdata($post);
			?>
			<div class="item">
				<small><?php the_time('d/m/Y - H:i'); ?></small>
				<a href="<?php the_permalink(); ?>" id="post-<?php the_ID(); ?>" title="Lire la suite de <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</div>
		<?php 
		endforeach;
		unset($post, $lastest_posts);
		wp_reset_postdata();
		?>		
		
		<a href="<?php echo get_category_link(1); ?>" class="button read-more-archives" title="Lire l'article">Les archives</a>
	</div>
	<div class="latest_forum">
		<h4><span>Forum:</span> les derniers sujets</h4>
		
		<?php 
		$response = wp_remote_get('http://www.wordpress-fr.net/support/extern.php?action=new&show=6&type=custom');
		if ( $response != false && !is_wp_error($response) && wp_remote_retrieve_response_code() == 200 ) {
			echo wp_remote_retrieve_body($response);
		}
		?>

		<a href="http://www.wordpress-fr.net/support/" class="button read-more-forum" title="Les forums">Les forums</a>				
	</div>
	<div class="clear"></div>
</div>       