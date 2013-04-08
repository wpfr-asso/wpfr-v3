
<?php get_header(); ?>

<div id="content" class="list_pro">
	<div class="post" id="post">
		<?php 
		global $simple_annu_pro; 
		$pros = $simple_annu_pro->getProsByTag();	
		$term = get_term_by( 'slug', $simple_annu_pro->current_tags_pro, $simple_annu_pro->base_tags );
		?>
		<h2 class="pro_h2"><?php printf('Professionnel(s) classé(s) dans %s', wp_specialchars($term->name)); ?></h2>
		
		<?php if ( !empty($pros) ) : ?>
			<?php foreach( (array) $pros as $pro ):
				$pro = new Pro('object', $pro );
				$picture = $pro->getPicture();
				?>
				
				<?php if($pro->state == "publish"): ?>
				<div class="pro-item">
					<div class="up_pro">
						<h3><a href="<?php echo $pro->getLink(); ?>"><?php echo $pro->getTitle(); ?></a></h3>
						<div style="text-align:center">
							<?php if(!empty($picture)):	?>
								<a class="small_pic_pro" href="<?php echo $pro->getLink(); ?>"><?php echo $pro->getProPicture( 'thumb' ) ; ?></a>
							<?php endif; ?>
						</div>
						<p><?php echo $pro->getDescriptionShort(); ?></p>
					</div>
					<div class="down_pro">
						<small>
							<p><span class="author"></span> <?php echo $pro->getAuthor()?></p>
							<p><span class="tag_orange"></span> <?php echo $pro->getTagLink(); ?></p>
						</small>
					</div>			
				</div>
				<div id="clear"></div>
				<?php endif; ?>				
			<?php endforeach; ?>
			
		<?php else: ?>

			<p><?php _e('No pros for this Tag','simpledirectory') ?></p>
			
		<?php endif; ?>
	</div>
						
	<div class="clear"></div>
</div>

<?php include( TEMPLATEPATH . '/sidebar-pro.php' ); ?>
<?php get_footer(); ?>