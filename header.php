<?php
$theme_version = '?version=3.1-3.1';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Archive du blog <?php } ?> <?php wp_title(); ?></title>
	
	<link rel="shortcut icon" type="image/ico" href="http://www.wordpress-fr.net/favicon.ico" />
	
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.site.min.css<?php echo $theme_version; ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?><?php echo $theme_version; ?>" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/jquery.lightbox-0.5.css" media="screen" />
	<?php if ( is_page(3) ) : ?>
		<link type="text/css" href="<?php bloginfo('template_directory'); ?>/css/pepper-grinder/jquery-ui-1.8.11.custom.css" rel="stylesheet" />	
	<?php endif; ?>
	
	<!--[if IE]>
		<link href="<?php bloginfo('template_directory'); ?>/css/style_ie.css<?php echo $theme_version; ?>" rel="stylesheet" type="text/css" media="screen" />
	<![endif]-->
	
	<!--[if lt IE 7]>
		<link href="<?php bloginfo('template_directory'); ?>/css/style_ie6.css<?php echo $theme_version; ?>" rel="stylesheet" type="text/css" media="screen" />
	<![endif]-->
	
	<!--[if lt IE 9]>
		<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->
	
	<?php if ( is_category(13) || in_category(13) || is_page(362) || is_page(363) || is_page(365) ) : /* WPmu */ ?>
		<link href="<?php bloginfo('template_directory'); ?>/css/color.jaune.css<?php echo $theme_version; ?>" rel="stylesheet" type="text/css" media="screen" />
	<?php elseif ( is_page(144) || is_page(467) || is_page(469) || is_page(465) || is_page(1037) /*|| is_pro()*/ ) : /* Pro */ ?>
		<link href="<?php bloginfo('template_directory'); ?>/css/color.orange.css<?php echo $theme_version; ?>" rel="stylesheet" type="text/css" media="screen" />
	<?php elseif ( is_page(158) || is_page(159) ) : /* Comm */ ?>
		<link href="<?php bloginfo('template_directory'); ?>/css/color.bleu.css<?php echo $theme_version; ?>" rel="stylesheet" type="text/css" media="screen" />
	<?php endif; ?>
	
	<?php 
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js', array(), '1.8.x' );
	wp_enqueue_script( 'wpfr', get_bloginfo('template_directory').'/js/wpfr.js', array('jquery'), $theme_version );
	wp_enqueue_script( 'jquery-lightbox', get_bloginfo('template_directory').'/js/jquery.lightbox-0.5.min.js', array('jquery'), '0.5' );
	
	if ( is_page(3) /*&& isset($_GET['dev'])*/ ) {
		wp_enqueue_script( 'wpfr-contact', get_bloginfo('template_directory').'/js/contact.js', array('jquery-ui-custom'), $theme_version );
		wp_enqueue_script( 'jquery-ui-custom', get_bloginfo('template_directory').'/js/jquery-ui-1.8.11.custom.min.js', array('jquery'), '1.8.11' );
	}
	
	wp_head();
	?>
	
	<script type="text/javascript">
		<!--
		jQuery(document).ready(function() {
			jQuery('.entry a[href$=".jpg"]:has(img), .entry a[href$=".gif"]:has(img), .entry a[href$=".png"]:has(img), a[rel*=lightbox]').lightBox({
				imageLoading:			'<?php bloginfo('template_directory'); ?>/images/lightbox-ico-loading.gif',
				imageBtnPrev:			'<?php bloginfo('template_directory'); ?>/images/lightbox-btn-prev.gif',
				imageBtnNext:			'<?php bloginfo('template_directory'); ?>/images/lightbox-btn-next.gif',
				imageBtnClose:			'<?php bloginfo('template_directory'); ?>/images/lightbox-btn-close.gif',
				imageBlank:				'<?php bloginfo('template_directory'); ?>/images/lightbox-blank.gif',
				txtImage:				'Image',
				txtOf:					'sur'
			 });
		});
		//-->
	</script>	
</head>

<?php
global $wp_query, $my_class;
$my_class = '';
if ( (isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] == 'vitrine') || is_singular('vitrine') || is_singular('publication') || is_page(2367) || is_page(2369) || is_page(2372) ) 
	$my_class = 'vitrine_body';
elseif ( (isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] == 'faq') || is_singular('faq') ) 
	$my_class = 'faq_body';
elseif ( (isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] == 'publication') ) 
	$my_class = 'publication_body';
?>
<body class="<?php echo $my_class; ?>">
    <div id="wrap">
        <div id="header">
            <div class="login">         	
				<?php 
				global $user_ID, $user_identity, $user_login;
				get_currentuserinfo();
				if (!$user_ID): // Non connecte
				?>
					<form method="post" id="loginform" class="user_box" action="http://www.wordpress-fr.net/wp-login.php">
						<div>
							<label for="login">Connexion</label>
							<input size="10" type="text" value="<?php echo (empty($user_login)) ? wp_specialchars(stripslashes($user_login), 1) : 'pseudo'; ?>" name="log" id="login" />
							<input size="10" type="password" value="motdepasse" name="pwd" id="password" />
							<input class="hidden" type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
							<input class="hidden" type="hidden" name="rememberme" value="forever" />
							<input type="submit" id="loginsubmit" value="OK" />						
						</div>
					</form>			
				<?php else : // Connecte ?>
					<div id="user_connected">
						Bienvenue <?php echo wp_specialchars(stripslashes($user_identity), 1); ?>.
						<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout&amp;redirect_to=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" title="Deconnexion" class="logout">Me déconnecter</a>
					</div>
				<?php endif; ?>
            </div>
            <h1><a href="http://www.wordpress-fr.net" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
            <p class="description"><?php bloginfo('description'); ?></p>
			
			<?php if ( 1 == 0 && !is_home() ) : ?>
			<div id="comm-right">
				<a href="http://2013.paris.wordcamp.org/"><img src="http://2013.paris.wordcamp.org/files/2012/12/banner-250x100.gif" alt="Wordcamp Paris 2013 ! Le rendez-vous des passionnés de WordPress." /></a>
			</div>
			<?php endif; ?>
        </div>
		
      	<div id="menu">
            <ul class="main_menu">
                <li><a class="wp_area" href="http://www.wordpress-fr.net" title="WordPress">WordPress</a></li>
                <li><a class="wp_mu_area" href="<?php echo get_permalink(362); ?>" title="WordPress Mu">WordPress Mu</a></li>
                <li><a class="pro_area" href="<?php echo get_permalink(465); ?>" title="Professionnels">Professionnels</a></li>
                <li><a class="com_area" href="#" title="Communautée">Communautée</a></li>
            </ul>
			<div class="clear"></div>
	
            <div class="area" id="aera_wp">
            	<ul>
            		<li><a href="<?php echo get_permalink(361); ?>" title="Présentation">Présentation</a></li>
            		<li><a href="<?php echo get_category_link(1); ?>" title="Actualités">Actualités</a></li>
            		<li><a href="<?php echo get_permalink(112); ?>" title="Téléchargements">Téléchargements</a></li>
            		<li><a href="<?php echo get_post_type_archive_link('vitrine'); ?>" title="La crème des sites WordPress">Vitrine</a></li>
            		<li><a href="<?php echo get_post_type_archive_link('publication'); ?>" title="Tous les livres et DVD faits pour WordPress">Publications</a></li>
            		<li><a href="http://demo.wordpress-fr.net/" title="Site de démonstration de WordPress en français">Démo</a></li>
            		<li class="last"><a href="http://www.wordpress-fr.net/faq/" title="FAQ">FAQ</a></li>
            	</ul>				
				<h5>La référence en matiere de moteur de blog.</h5>
            </div>
            <!--
            <div class="area" id="aera_mu">
            	<ul>
            		<li><a href="<?php echo get_permalink(362); ?>" title="Accueil">Accueil</a></li>
            		<li><a href="<?php echo get_category_link(13); ?>" title="Actualité">Actualité</a></li>
            		<li><a href="<?php echo get_permalink(363); ?>" title="Présentation">Présentation</a></li>
            		<li class="last"><a href="<?php echo get_permalink(365); ?>" title="Téléchargements">Téléchargements</a></li>
            	</ul>				
				<h5>Le multi-blogs devient un jeu d'enfant !</h5>
			</div>
			-->
			<div class="area" id="aera_pro">
				<ul>
					<li><a href="<?php echo get_permalink(465); ?>" title="Accueil">Accueil</a></li>
					<li class="last"><a href="<?php echo get_permalink(144); ?>" title="Conseil &amp; Services">Conseil &amp; Services</a></li>
					<!--<li><a href="<?php echo get_permalink(467); ?>" title="Livre blanc">Livre blanc</a></li>-->
					<!--<li class="last"><a href="<?php echo get_permalink(469); ?>" title="Annuaire des professionnels">Annuaire des professionnels</a></li>-->
				</ul>				
				<h5>La communauté, c'est vous qui la faites !</h5>
			</div>
            <div class="area" id="aera_com">
            	<ul>
            		<li><a href="http://www.wordpress-fr.net/planet/" title="Planet WordPress Francophone">Planet WordPress</a></li>
            		<li><a href="http://codex.wordpress.org/fr:Accueil" title="Codex Francais (Wiki)">Codex (Wiki)</a></li>
            		<li><a href="http://www.wordpress-fr.net/support/" title="Forums d'entraide">Forums d'entraide</a></li>
					<li><a href="http://www.wordpress-fr.net/vitrine/" title="La crème des sites WordPress">Vitrine</a></li>
					<li><a href="<?php echo get_permalink(158); ?>" title="Thèmes">Thèmes</a></li>
            		<li class="last"><a href="<?php echo get_permalink(159); ?>" title="Extensions &amp; Plugins">Extensions</a></li>
            	</ul>
				<h5>WordPress et vous !</h5>
				
			</div>
			
			<div id="searchform">
				<form method="get" action="<?php bloginfo('url'); ?>/">
					<div>
						<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
						<input type="submit" id="searchsubmit" value="" />
					</div>
				</form>
			</div>
			
			<a href="http://www.infomaniak.com/banner/wordpress" title="Hébergement WordPress" target="_blank" class="partner-link">Hébergement WordPress</a>
		</div>
