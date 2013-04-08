<?php global $my_class; ?>
<form method="get" id="searchform_404" action="<?php echo home_url('/'); ?>">
	<?php if ( $my_class == 'faq_body' ) : ?>
		<h2>Chercher une Q/R</h2>
		<input type="hidden" name="post_type" value="faq" />
	<?php endif; ?>
	<div>
		<input type="text" value="<?php the_search_query(); ?>" name="s" id="s_404" />
		<input type="submit" id="searchsubmit_404" value="Chercher" />
	</div>
</form>
