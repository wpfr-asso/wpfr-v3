<?php
/*
Template Name: Ajout de showcases.
*/

require_once( dirname(__FILE__) . '/recaptcha-php-1.10/recaptchalib.php');

global $wp_rich_edit;
$wp_rich_edit = true;

include( ABSPATH . '/wp-admin/includes/admin.php' );
add_action( 'wp_footer', 'wp_tiny_mce', 25 );
add_action( 'wp_footer', 'customTinyMCE', 26 );

function customTinyMCE() {
	$mce_locale = ( '' == get_locale() ) ? 'en' : strtolower( substr(get_locale(), 0, 2) ); // only ISO 639-1
	$mce_spellchecker_languages = apply_filters('mce_spellchecker_languages', '+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv');
	?>
	<script type="text/javascript">
	/* <![CDATA[ */
	tinyMCE.init({
		mode : "specific_textareas",
		editor_selector : "mceEditor",
		width:"100%", 
		theme:"advanced", 
		skin:"o2k7",
		skin_variant : "silver", 
		theme_advanced_buttons1:"bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,wp_more,|,spellchecker,fullscreen,wp_adv", 	
		theme_advanced_buttons2:"formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help,|,code", 	
		theme_advanced_buttons3:"",
		theme_advanced_buttons4:"", 
		language:"<?php echo $mce_locale; ?>",
		spellchecker_languages:"<?php echo $mce_spellchecker_languages; ?>",
		theme_advanced_toolbar_location:"top", 
		theme_advanced_toolbar_align:"left", 
		theme_advanced_statusbar_location:"bottom", 
		theme_advanced_resizing:"1", 
		theme_advanced_resize_horizontal:"", 
		dialog_type:"modal", 
		relative_urls:"", 
		remove_script_host:"", 
		convert_urls:"", 
		apply_source_formatting:"", 
		remove_linebreaks:"1", 
		gecko_spellcheck:"1", 
		entities:"38,amp,60,lt,62,gt", 
		accessibility_focus:"1", 
		tabfocus_elements:"major-publishing-actions", 
		media_strict:"", 
		paste_remove_styles:"1", 
		paste_remove_spans:"1", 
		paste_strip_class_attributes:"all", 
		wpeditimage_disable_captions:"", 
		plugins:"safari,inlinepopups,spellchecker,paste,media,fullscreen,tabfocus"
	});
	/* ]]> */
	</script>
	<?php
}

get_header();
?>

<div id="content" class="blog wide_page">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">Lire le reste de cette page &raquo;</p>'); ?>
				
				<?php if( isset($_POST['add-new-site']) ) : ?>
					<p><strong>Les champs nom du site et description du site sont obligatoires. Il y a eu une erreur lors de l'envoi.</strong></p>
				<?php endif; ?>
				
				<form action="" method="post" class="form-add-site" enctype="multipart/form-data">
					<p>
						<label>Nom du site</label>
						<input type="text" name="post_title" value="<?php echo stripslashes($_POST['post_title']); ?>" />
					</p>
					
					<p>
						<label>Adresse du site <small>(avec le http://)</small></label>
						<input type="text" name="url" value="<?php echo stripslashes($_POST['url']); ?>" />
					</p>
					
					<p>
						<label>Type de site</label>
						<select name="type-de-site">
							<option <?php selected( 'Communauté', $_POST['type-de-site'] ); ?> value="Communauté">Communauté</option>
							<option <?php selected( 'Entreprise', $_POST['type-de-site'] ); ?> value="Entreprise">Entreprise</option>
							<option <?php selected( 'Portfolio', $_POST['type-de-site'] ); ?> value="Portfolio">Portfolio</option>
							<option <?php selected( 'Collectivités', $_POST['type-de-site'] ); ?> value="Collectivités">Collectivités</option>
							<option <?php selected( 'Tourisme', $_POST['type-de-site'] ); ?> value="Tourisme">Tourisme</option>
							<option <?php selected( 'Médias', $_POST['type-de-site'] ); ?> value="Médias">Médias</option>
							<option <?php selected( 'Presse', $_POST['type-de-site'] ); ?> value="Presse">Presse</option>
						</select>
					</p>
					
					<p>
						<label>Mots clefs <small>(séparé avec une virgule)</small></label>
						<input type="text" name="tags_input" value="<?php echo stripslashes($_POST['tags_input']); ?>" />
					</p>
					
					<p>
						<label>Description du site</label>
						<textarea class="mceEditor" name="post_content"><?php echo stripslashes($_POST['post_content']); ?></textarea>
					</p>
					
					<p>
						<label>Motivations pour ajouter le site au showcase</label>
						<textarea name="motivation" rows="3"><?php echo stripslashes($_POST['motivation']); ?></textarea>
					</p>
					
					<p>
						<label>Capture d'écran (prévoir une grande taille)</label>
						<input type="file" name="screenshot" value="" />
					</p>
					
					<p>
						<label>Votre nom complet</label>
						<input type="text" name="name" value="<?php echo stripslashes($_POST['name']); ?>" />
					</p>
					
					<p>
						<label>Votre adresse courriel</label>
						<input type="text" name="email" value="<?php echo stripslashes($_POST['email']); ?>" />
					</p>
					
					<?php echo recaptcha_get_html('6LeIfwsAAAAAAMK08OiQ5YXHjmHhVxG90s7NrAec'); ?>
					<br />
					
					<p class="submit">
						<input type="submit" name="add-new-site" value="Soumettre à validation" />
					</p>
				</form>
				<div class="clear"></div>
			</div>
		</div>		
		<div class="clear"></div>
		
	<?php endwhile; endif; ?>
	
	<div class="clear"></div>
</div>

<?php include (STYLESHEETPATH . '/sidebar.list.php'); ?>
<?php get_footer(); ?>