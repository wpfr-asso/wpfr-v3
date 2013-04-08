<?php
function extract_image_from_vimeo() {	
	$video_id = null;
	$matches = array();
	if ( preg_match( '|\[vimeo(.*?)\]http://(.*?)vimeo.com/(.*?)\[/vimeo\]|im', get_the_content(''), $matches )) {
		if ( !empty($matches[3]) ) {
			$video_id = $matches[3];			
		}
	}

	if ( $video_id != null ) {
		return get_vimeo_image_url_by_id( $video_id );
	}

	return '';
}

function extract_image_from_youtube() {
	$video_id = null;
	$matches = array();
	if ( preg_match( '|\[youtube(.*?)\]http://(.*?)youtube.com/watch\?v=(.*?)\[/youtube\]|im', get_the_content(''), $matches )) {
		if ( !empty($matches[3]) ) {
			return 'http://img.youtube.com/vi/'.$matches[3].'/0.jpg';			
		}
	}

	return '';
}

function extract_image_from_content() {
	$matches = array();
	if ( preg_match ( '/<img(.*?)src="(.*?)"/i', get_the_content(''), $matches )) {
		if ( !empty($matches[2]) ) {
			return $matches[2];			
		}
	}
	
	return '';
}


function the_thumb( $url = '', $width = '', $height = '', $crop = 0, $quality = 100 ) {
	echo get_thumb( $url, $width, $height, $crop, $quality );
}

function get_thumb( $url = '', $width = '800', $height = '600', $crop = 0, $quality = 100 ) {
	global $current_site, $wpdb, $current_blog, $all_blogs;

	$url = str_replace(' ', '%20', $url);
	$url = clean_url($url);

	if ( empty($url) ) {
		return '';
	}

	$blogid_arg = '';
	if ( function_exists('get_blog_list') ) : // WPmu
		// Get all blogs
		if ( empty($all_blogs) || $all_blogs == null ) {
			$all_blogs = get_blog_list( 0, 'all');
		}
		$all_blogs = array_reverse($all_blogs);
	
		if ( $wpdb->blogid == 1 ) { // Main blog
			$url = str_replace( '/files/', '/wp-content/blogs.dir/1/files/', $url );
		} else {
			// Try to replace /files/ by current folder
			foreach( (array) $all_blogs as $blog ) {
				if ( $blog['blog_id'] == 1 ) continue;
				$original = $url;
			
				$url = str_replace( $blog['path'].'wp-content/plugins', $current_site->path.'wp-content/plugins', $url );
				$url = str_replace( $blog['path'].'wp-content/themes', $current_site->path.'wp-content/themes', $url );
				$url = str_replace( $blog['path'].'files/', $current_site->path.'wp-content/blogs.dir/'.$blog['blog_id'].'/files/', $url );
			
				if ( $original != $url ) {
					break;
				}
			}
		}
		
		$blogid_arg = '&id='.$wpdb->blogid;
	endif;
	
	return clean_url( get_bloginfo('template_directory') . '/lib/simple-thumb.php?src='.$url.$blogid_arg.'&w='.$width.'&h='.$height.'&zc='.$crop.'&q='.$quality );
}

function get_thumbs( $quantity = 10, $width = '800', $height = '600', $crop = 0, $quality = 100 ) {
	global $post;
	
	if ( $urls == false )
		$urls = array();
		
	// Get from DB ?
	$children = get_children( array('post_parent' => $post->ID, 'numberposts' => $quantity, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order ASC, ID', 'order' => 'DESC') );
	if ( $children != false ) {
		foreach( (array) $children as $child ) {
			if ( strtolower($child->post_content) == 'logo' ) continue;
			$img = wp_get_attachment_image_src($child->ID, 'large');
			$urls[] = $img[0];
		}
	}
	
	// Always empty ? Go out !
	if ( empty($urls) ) {
		return false;
	}
	
	// Build display
	$title = attribute_escape(get_the_title($post->ID));
	foreach( (array) $urls as $key => $url ) {
		$urls[$key] = '<a href="'.$url.'" title="'.$title.'" class="lightwindow"><img alt="'.$title.'" src="' . get_thumb( $url, $width, $height, $crop, $quality ) . '" /></a>';
	}

	return $urls;
}

function get_the_image( $size = 'medium', $url_only = false, $img_from_content = true, $video_from_content = false ) {
	global $post;

	$output = '';
	$children = get_children( array('post_parent' => $post->ID, 'numberposts' => '1', 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order ASC, ID', 'order' => 'DESC') );
	if ( $children != false ) {
		foreach( (array) $children as $child ) {
			if ( $url_only == true ) {
				if ( $child->guid != '' ) {
					$output = $child->guid;
				} else {
					$img = wp_get_attachment_image_src($child->ID, $size);
					$output = $img[0];
				}
			} else {
				$output = wp_get_attachment_image($child->ID, $size);
			}
			break;
		}
	}
	
	if ( empty($output) && $img_from_content == true ) {
		$output = extract_image_from_content();
	}
	
	if ( empty($output) && $video_from_content == true ) {
		$output = extract_image_from_vimeo();
		if ( empty($output) )
			$output = extract_image_from_youtube();
	}
	
	return $output;
}

function the_image( $size = 'medium' ) {
	echo get_the_image( $size );
}

function get_the_images_array( $size = 'large', $quantity = 10 ) {
	global $post;
	
	$output = array();
	$children = get_children( array('post_parent' => $post->ID, 'numberposts' => $quantity, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order ASC, ID', 'order' => 'DESC') );
	if ( $children == false ) {
		return false;
	} else {
		foreach( (array) $children as $child ) {
			if ( $child->guid != '' ) {
				$output[] = $child->guid;
			} else {
				$img = wp_get_attachment_image_src($child->ID, $size);
				$output[] = $img[0];
			}
		}
	}

	return $output;
}


function get_the_images( $size = 'medium', $quantity = 10, $before = '', $after = '' ) {
	global $post;
	
	$output = '';
	$children = get_children( array('post_parent' => $post->ID, 'numberposts' => $quantity, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order ASC, ID', 'order' => 'DESC') );
	if ( $children != false ) {
		foreach( (array) $children as $child ) {
			$output .= $before . wp_get_attachment_image($child->ID, $size) . $after;
		}
	}

	return $output;
}

function the_images( $size = 'medium', $quantity = 10, $before = '', $after = '' ) {
	echo get_the_images( $size, $quantity, $before, $after );
}

?>