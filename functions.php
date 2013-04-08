<?php
/*
Domain Name:	wordpress-fr.net
This is a global key. It will work across all domains.

Public Key:	6LeIfwsAAAAAAMK08OiQ5YXHjmHhVxG90s7NrAec
Use this in the JavaScript code that is served to your users

Private Key:	6LeIfwsAAAAAANbnegRCRqlZ7M9oQpj7yizeQDEY
Use this when communicating between your server and our server. Because this key is a global key, it is OK if the private key is distributed to multiple users.
*/

if ( ! isset( $content_width ) )
	$content_width = 555;

// Add WP thumbs
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 48, 48, true );  // Normal thumbs

// Add default posts and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );

// Define all sizes need for theme
add_image_size( 'listing-thumbnail', 240, 200, true );
add_image_size( 'single-thumbnail' , 362, 400, true );
add_image_size( 'listing-publi-thumbnail', 120, 160, true );

// Load inc theme
foreach( array('author', 'faq', 'image', 'publication', 'vimeo', 'vitrine') as $inc_file ) {
	include_once( TEMPLATEPATH.'/inc/' . $inc_file . '.php' );
}

// Remove fake CSS
remove_action('wp_head', 'pagenavi_css');
remove_action('wp_head', 'akst_head');
remove_action('wp_head', 'sociable_wp_head');
remove_action('wp_head', 'wp_print_scripts');

global $PS_ImageManager;
remove_action('wp_head',array(&$PS_ImageManager, 'ps_imagemanager_wp_head'));

add_action( 'pre_get_posts', 'qtySearch', 10 );
function qtySearch( $query = '' ) {
	if ( $query->is_tax() ) {
		$current_term = $query->get_queried_object();
		$current_taxo = get_taxonomy($current_term->taxonomy);
		
		if ( is_array($current_taxo->object_type) && count($current_taxo->object_type) == 1 ) {
			$_post_type = current($current_taxo->object_type);
			$query->query_vars["post_type"] = $_post_type;
		}
	}
	
	if ( is_search() ) { // recherche
		$query->query_vars['posts_per_page'] = 9;
	} elseif ( is_category() && !is_category(1) ) { // Category
		$query->query_vars['posts_per_page'] = 8;
	} elseif ( is_tag() ) { // Tag
		$query->query_vars['posts_per_page'] = 8;
	} elseif ( is_author() ) { // Tag
		$query->query_vars['posts_per_page'] = 8;
	} elseif ( is_date() ) { // Archive
		$query->query_vars['posts_per_page'] = 8;
	}
	
	if ( is_page() || is_single() ) {
		//add_action('wp_head', 'email_js');
		//add_action('wp_head', 'the_ratings_header');
		add_action('wp_head', 'process_postviews');
	} else {
		remove_action('wp_head', 'email_js');
		remove_action('wp_head', 'the_ratings_header');
		remove_action('wp_head', 'process_postviews');
	}
}

function the_excerpt_light() {
	echo strip_tags(get_the_excerpt('Lire le reste de cet article &raquo;'));
}

if ( function_exists('register_sidebars') )
    register_sidebars( 3, array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
	
function comments_human_number( $zero = false, $one = false, $more = false, $deprecated = '', $number = 0 ) {
	if ( $number > 1 )
		$output = str_replace('%', $number, ( false === $more ) ? __('% Comments') : $more);
	elseif ( $number == 0 )
		$output = ( false === $zero ) ? __('No Comments') : $zero;
	else // must be one
		$output = ( false === $one ) ? __('1 Comment') : $one;

	echo apply_filters('comments_number', $output, $number);
}

function comments_trackback_number( $zero = false, $one = false, $more = false, $deprecated = '', $number = 0 ) {
	if ( $number > 1 )
		$output = str_replace('%', $number, ( false === $more ) ? __('% trackbacks') : $more);
	elseif ( $number == 0 )
		$output = ( false === $zero ) ? __('No trackback') : $zero;
	else // must be one
		$output = ( false === $one ) ? __('1 trackback') : $one;

	echo apply_filters('comments_number', $output, $number);
}

function detailResultSearch() {		
	global $wp_query;
	
	$paged 			= (int) $wp_query->query_vars['paged'];
	$posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
	$post_count 	= (int) $wp_query->post_count;			
	$found_posts 	= (int) $wp_query->found_posts;
	$max_num_pages 	= (int) $wp_query->max_num_pages;
	
	if ( $paged != 1 && $paged != 0 )  {
		$paged = $paged - 1;
	}
	
	$base = (int) $posts_per_page * $paged;

	if ( $max_num_pages > 1) {
		echo 'Résultats <strong> '.$base. '</strong> - <strong>' .($base+$post_count). '</strong> sur un total de <strong>' .$found_posts. '</strong> réponses';
	} else {
		echo '<strong>'.$found_posts.'</strong> résultats';
	}
}