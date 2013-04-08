<?php get_header(); ?>

<div id="content" class="home">
	<div id="featured">			
		<h3><span>WordPress :</span> simple et élégant...</h3>
		<ul>
			<li><h1>Libre</h1></li>
			<li><h1>Respectueux des standards</h1></li>
			<li><h1>Ergonomique</h1></li>
			<li><h1>Rapide à installer</h1></li>
		</ul>
		
		<p>WordPress est un système de gestion de contenu (CMS) qui permet de créer et gérer facilement l'ensemble d'un site web ou simplement un blog. Gratuit et libre, WordPress est personnalisable grâce à de nombreux thèmes et plugins.
		<br />En outre, il existe une solide communauté à travers le monde entier.</p>
		
		<a href="http://fr.wordpress.org/latest-fr_FR.zip" title="Télécharger la dernière version de WordPress !" id="home_big_dl">Télécharger la dernière version de WordPress !</a>
	</div>
	<div id="bup">
		<?php if( function_exists('adrotate_banner') ) echo adrotate_banner('1'); ?>
	</div>
	
	<?php include (TEMPLATEPATH . '/asides.php'); ?>
</div>

<?php get_footer(); ?>
