<?php
/*
CREATE TABLE `wp_videos_vimeo` (
	`video_id` VARCHAR( 200 ) NOT NULL ,
	`image_url` VARCHAR( 255 ) NOT NULL ,
	UNIQUE (`video_id`)
) 
*/

global $wpdb;
$wpdb->videos_vimeo = $wpdb->base_prefix . 'videos_vimeo';

function get_vimeo_image_url_by_id( $video_id = '' ) {
	global $wpdb;
		
	// Get image
	$video_id = trim($video_id);
	if ( empty($video_id) ) {
		return '';		
	}
	
	$img_url = $wpdb->get_var( $wpdb->prepare("SELECT image_url FROM $wpdb->videos_vimeo WHERE video_id = %s LIMIT 1", $video_id) );
	if ( empty($img_url) || $img_url == false ) {
		
		$response = wp_remote_get( "http://vimeo.com/moogaloop/load/clip:$video_id/local/" );
		if ( is_wp_error( $response ) )
			return '';

		$matches = array();
		preg_match("/<thumbnail>(.*)<\/thumbnail>/i", $response['body'], $matches);
		if ( empty($matches[1]) ) {
			return '';
		}
		
		db_create_vimeo();
		
		$wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->videos_vimeo WHERE video_id = %s LIMIT 1", $video_id ) );
		$wpdb->insert( $wpdb->videos_vimeo, array('video_id' => $video_id, 'image_url' => $matches[1]) );
		return $matches[1];

	}

	return $img_url;
}

function db_create_vimeo() {
	global $wpdb;
	
	// Table exist ?
	if ($wpdb->get_var ( "show tables like '$wpdb->videos_vimeo'" ) !== $wpdb->videos_vimeo) {
	
		// Call required library
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
		
		// Table quizz
		if ($wpdb->get_var ( "SHOW tables LIKE '$wpdb->videos_vimeo'" ) != $wpdb->videos_vimeo) {
			$sql = "
				CREATE TABLE IF NOT EXISTS {$wpdb->videos_vimeo} (
					`video_id` VARCHAR( 200 ) NOT NULL ,
					`image_url` VARCHAR( 255 ) NOT NULL ,
					UNIQUE (`video_id`)
				)";
			dbDelta ( $sql );
		}
		unset($sql);
	}
}
?>