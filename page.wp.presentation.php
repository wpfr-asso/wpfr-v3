<?php
/*
Template Name: Présentation de WP, 2 colonnes
*/
?>

<?php get_header(); ?>

<div id="content" class="blog wide_page">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
			<div class="entry">
				<div class="single_postmetadata">
					<h4>M&eacute;ta</h4>
					<?php if(function_exists('print_link')) { print_link(); } ?>
					<?php if(function_exists('wp_email')) { email_link(); } ?> 
					<?php if(function_exists('the_views')) { echo '<p>Pages vues '; the_views(); echo ' fois.</p>'; } ?>			 
					<?php if(function_exists('sociable_html')) { echo sociable_html(); } ?>
				</div>
				
				<?php the_content('<p class="serif">Lire le reste de cette page &raquo;</p>'); ?>
				
				<div class="clear"></div>
				
				<div style="float:left;width:460px;">
					<?php 
					$page = get_post( $id = 504 );
					setup_postdata($page);
					the_content();
					?>	
				</div>
				<div style="float:left;width:460px;margin-left:34px;">
					<?php 
					$page = get_post( $id = 506 );
					setup_postdata($page);
					the_content();
					?>	
				</div>
				
				<div class="clear"></div>
				
				<?php 
				$page = get_post( $id = 513 );
				setup_postdata($page);
				the_content();
				?>			
			</div>
		</div>		
		<div class="clear"></div>
		
	<?php endwhile; endif; ?>
	
	<div class="clear"></div>
</div>
	
<?php get_footer(); ?>