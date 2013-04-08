<?php
Class Author {
	var $author;
	
	function Author() {
		$this->get_author_from_url();
	}

	function get_author_from_url() {
		global $wpdb;

		$author = get_query_var('author');
		$author_name = get_query_var('author_name');

		// If there's an author
		if ( !empty($author) ) {
			$this->author = get_userdata($author);
		} elseif ( !empty($author_name) ) {
			// We do a direct query here because we don't cache by nicename.
			$id_author = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_nicename = %s", $author_name));
			$this->author = get_userdata($id_author);
		}
	}
	
	function get_the_author() {
		return apply_filters('the_author', $this->author->display_name);
	}

	function get_the_author_description() {
		return nl2br(stripslashes($this->author->description));
	}
	
	function get_the_author_email() {
		return stripslashes($this->author->user_email);
	}
	
	function get_author_posts_url_feed( $feed='rss2' ) {
		$author_url = get_author_posts_url( $this->author->ID );
		
		global $wp_rewrite;
		$permalink = $wp_rewrite->get_feed_permastruct();
		if ( '' != $permalink ) {
			if ( 'rss2' == $feed )
				$feed = '';

			$permalink = str_replace('%feed%', $feed, $permalink);
			$permalink = preg_replace('#/+#', '', "/$permalink");
			$output =  $author_url . user_trailingslashit($permalink, 'feed');
		} else {
			$output = $author_url . "/?feed={$feed}";
		}

		return apply_filters('feed_link', $output, $feed);
	}
	
	function count( $object ) {
		global $wpdb;

		$user_id = (int) $this->author->ID;
		if ( $object == 'post' ) {
			return (int) $wpdb->get_var("SELECT COUNT(post_title) FROM $wpdb->posts WHERE post_type = 'post' AND post_author = $user_id GROUP BY post_author");
		} elseif ( $object == 'comment' ) {
			return (int) $wpdb->get_var("SELECT COUNT(user_id) FROM $wpdb->comments WHERE user_id = $user_id GROUP BY user_id");
		}
		return 0;
	}
}