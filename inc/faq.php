<?php
if ( !is_admin() )
	add_filter( 'pre_get_posts', 'faq_pre_get_posts', 11 );
	
function faq_pre_get_posts( $query ) {
	if ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'faq' ) {
		$query->query_vars['posts_per_page'] = 6;
	}
}
?>