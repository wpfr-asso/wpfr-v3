<?php get_header(); ?>

<div id="content" class="list_pro">
	<div class="post" id="post">
		<?php
		global $simple_annu_pro;
		$pro = new Pro( 'slug', $simple_annu_pro->current_pro );
		$picture = $pro->getPicture();
		if ( $pro && $pro->state=="publish" ): 
			?>
			
			<h2 class="pro_h2"><?php _e('Details of this Pro ','simpleannupro') ?> : <?php echo $pro->getTitle(); ?></h2>
			<div class="pro_left">
				<div id="pro">
					<div class="down_pro_img">
						<?php if(!empty($picture)):	?>
							<a class="pic_pro" href="<?php echo $pro->getPictureLink();?>"><?php echo $pro->getProPicture( 'intermediate' ) ; ?></a>
						<?php endif; ?>	
					</div>
					
					<div class="down_pro_details">
						<ul>
							<li>Ajouté le :  <?php echo  $pro->getDateCreated(); ?> </li>
							<li>Mots clefs : <?php echo $pro->getTagLink(); ?> </li>
							<li>Contact : <?php echo $pro->getAuthor(); ?> </li>
							<li>Site web : <a href="<?php echo $pro->GetLocation(); ?>" alt="<?php echo $pro->GetLocation(); ?>"><?php echo $pro->getTitle(); ?></a> </li>
						</ul>
					</div>
				</div>
				<div id="clear"></div>
			</div>
			
			<div class="pro_right">
				<?php echo apply_filters('the_content', $pro->getDescriptionLong()); ?>
			</div>
			
		<?php else : ?>
		
			<h2><?php _e("No pro for this ID.",'simpleannupro') ?></h2>
		
		<?php endif; ?>
		
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

<?php include( TEMPLATEPATH . '/sidebar-pro.php' ); ?>
<?php get_footer(); ?>