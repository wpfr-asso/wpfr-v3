<?php
/*
 * Template Name: Accueil des pros
 */
?>
<?php get_header(); ?>

<div id="content" class="list_pro">
	<div class="post">
		<h2 class="pro_h2">Annuaire des professionnels</h2>
		
		<?php 
		global $simple_annu_pro;
		$one_pro = $simple_annu_pro->options['sapro-index-one'];
		if ( !empty($one_pro) ) : 
			foreach( (array) $one_pro as $pro_id ):
				$pro = new Pro('id',$pro_id);
				$picture = $pro->getpicture();	
				
				if($pro->state == "publish"):
				?>
				<div class="pro-item">
					<div class="up_pro">
						<h3><a href="<?php echo $pro->getLink(); ?>"><?php echo $pro->getTitle(); ?></a></h3>
						<div style="text-align:center">
							<?php if(!empty($picture)):	?>
								<a class="small_pic_pro" href="<?php echo $pro->getLink(); ?>"><?php echo $pro->getProPicture( 'thumb' ) ; ?></a>
							<?php endif; ?>
						</div>
						<p><?php echo $pro->getDescriptionShort();?></p>
					</div>
					
					<div class="down_pro">
						<small>
							<p><span class="author"></span> <?php echo $pro->getAuthor()?></p>
							<p><span class="tag_orange"></span> <?php echo $pro->getTagLink(); ?></p>
						</small>
					</div>
				</div>
				
				<?php 
				endif;
			endforeach;
			echo '<div id="clear"></div>';
		else: 
		?>
		
			<p>Aucun professionnel pour le moment.</p>
			
		<?php endif; ?>			

		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

<?php include( TEMPLATEPATH . '/sidebar-pro.php' ); ?>
<?php get_footer(); ?>