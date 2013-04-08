<?php
if ( !is_admin() )
	add_filter( 'pre_get_posts', 'publication_pre_get_posts', 11 );
	
function publication_pre_get_posts( $query ) {
	if ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'publication' ) {
		$query->query_vars['nopaging'] = true;
		$query->query_vars['orderby'] = 'rand';
	}
}