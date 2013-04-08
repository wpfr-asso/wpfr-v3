<?php
// Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Merci de ne pas lancer cette page directement.');

if (!empty($post->post_password)) { // if there's a password
	if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
		?>
		<p class="nocomments">Cet article est protégé par un mot de passe. Entrez ce mot de passe pour voir les commentaires.</p>
		<?php
		return;
	}
}

$oddcomment = 'class="alt" ';
$trackbacks_counter = $comments_human_counter = 0;
foreach ( (array) $comments as $comment ) :		
	$type = get_comment_type();
	if ( $type != 'comment' ) {
		$trackbacks[] = $comment;
		$trackbacks_counter++;
	} else {
		$comments_human[] = $comment;
		$comments_human_counter++;
	}	
endforeach;
?>

<div class="clear"></div>

<div style="position:relative;">
	<div id="content_c" class="blog single">
		<div class="comments_template">
			<h3 id="comments"><?php comments_human_number('Aucun commentaire', '1 commentaire', '% commentaires', '', $comments_human_counter );?></h3> 
			<?php if ( !empty($comments_human) ) : ?>
				<ol class="commentlist">
					<?php foreach ($comments_human as $comment) : ?>
						<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>"> 
							<div class="c_left">
								<?php echo get_avatar( $comment, 32 ); ?>
								<strong><?php comment_author_link() ?></strong>
								<small><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('d/m/y') ?> - <?php comment_time() ?></a></small>
								<div class="clear"></div>
							</div>
							<div class="c_right">
								<?php if ($comment->comment_approved == '0') : ?>
									<strong>Votre commentaire est en attente de modération.</strong>
								<?php endif; ?>
								<?php comment_text() ?>
								<?php edit_comment_link('Editer','',''); ?>
							</div>
							<div class="clear"></div>
						</li>
					  <?php $oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : ''; // Changes every other comment to a different class ?>
					<?php endforeach; ?>
				</ol>
				<div class="clear"></div>
			<?php endif; ?>
			<div class="clear"></div>
		</div>
	</div>
	
	<div id="col_right_comment" class="two_col">
		<?php if ('open' == $post->comment_status) : ?>
			<h4 id="respond">Laisser un commentaire </h4>
			
			<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
			
				<p>Vous devez être  <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">connecté</a> pour publier un commentaire.</p>
				
			<?php else : ?>
			
				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" name="commentform" id="commentform">		
					<?php if ( $user_ID ) : ?>
						<p>Connecté en tant que <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Se déconnecter du site.">Se déconnecter  &raquo;</a></p>	
					<?php else : ?>			
						<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
						<label for="author">Nom <?php if ($req) echo "(obligatoire)"; ?></label></p>
						
						<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
						<label for="email">Adresse e-mail (ne sera pas publié) <?php if ($req) echo "(obligatoire)"; ?></label></p>
						
						<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
						<label for="url">Site Web</label></p>				
					<?php endif; ?>
					
					<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
					<p>
						<input name="submit" type="submit" id="submit" tabindex="5" value="Dites-le !" />
						<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
						
					<?php do_action('comment_form', $post->ID); ?>
					
					<p>
						<small><strong>xHTML:</strong> Vous pouvez utiliser ces tags: <code><?php echo allowed_tags(); ?></code></small></p>
				</form>
		
			<?php endif; // If registration required and not logged in ?>
		<?php else : ?>
			
			<p class="nocomments">Les commentaires sont fermés.</p>
			
		<?php endif; // if you delete this the sky will fall on your head ?>
		<div class="clear"></div>
	</div>
	
	<a href="#respond" id="write_comment">écrire un commentaire</a>
	<div class="clear"></div>
</div>

<div class="clear"></div>

<div class="comments_template">
	<h3 id="trackbacks"><?php comments_trackback_number('Aucun rétrolien', '1 rétrolien', '% rétroliens', '', $trackbacks_counter );?></h3>
	<?php if ( !empty($trackbacks) ) : ?>
		<ol class="trackbacklist">
			<?php foreach ( (array) $trackbacks as $comment ) : ?>
				<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>"><?php comment_author_link() ?></li>
				<?php $oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : ''; ?>
			<?php endforeach; ?>
		</ol>
	<?php endif; ?>
	<div class="clear"></div>
</div>

<div class="clear"></div>