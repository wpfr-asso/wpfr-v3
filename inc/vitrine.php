<?php
// Longueur Excerpt
function new_excerpt_length($length) {
	return 20;
}

if ( !is_admin() )
	add_filter( 'pre_get_posts', 'vitrine_qtySearch' );
function vitrine_qtySearch( $query ) {
	if ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'vitrine' ) {
		$query->query_vars['posts_per_page'] = 9;
		
		//if ( $query->is_post_type_archive('vitrine') && $query->query_vars['paged'] <= 1 )
		//	$query->query_vars['orderby'] = 'rand';
			
		add_filter('excerpt_length', 'new_excerpt_length');
	}
}

//Fil d'ariane
function my_breadcrumbs() {
 
  $delimiter = '&raquo;';
  $name = 'Vitrine'; //text for the 'Home' link
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="crumbs">';
 
    global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . 'Archive par catégorie &#39;';
      single_cat_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
 
    } elseif ( is_single() ) {
      $cat = get_the_tags(); 
      if ( $cat != false && !is_wp_error($cat) && !empty($cat) ) :
      	$cat = current($cat);
      	echo '<a href="'.get_tag_link($cat).'">'.$cat->name . '</a> ' . $delimiter . ' ';
      endif;
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore . 'Recherche de résultats pour &#39;' . get_search_query() . '&#39;' . $currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Posts tagged &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
 
  }
}

add_action( 'init', 'checkShowcaseForm' );
function checkShowcaseForm() {
	if ( isset($_POST['add-new-site']) ) {
    if ( !wp_verify_nonce($_POST['nonce-vitrine'],'add-new-site') ) {
      wp_die('Erreur de sécurité.');
    }
		
		require_once( dirname(__FILE__) . '/../recaptcha-php-1.10/recaptchalib.php');
		$resp = recaptcha_check_answer (RECAPTCHA_PRI_KEY, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

		if (!$resp->is_valid) {
			wp_die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " . $resp->error . ")");
		}
		
		if ( empty($_POST['post_title']) || empty($_POST['post_content']) ) {
			return false;
		}
		
		$datas = array(
			'post_title' 	=> stripslashes($_POST['post_title']),
			'post_content' 	=> wp_kses_post(stripslashes($_POST['post_content'])),
			'post_type' 	=> 'vitrine',
			'post_status' 	=> 'pending',
			'post_author' 	=> 1,
			'tags_input'	=> stripslashes($_POST['tags_input'])
		);
		
		$p_id = wp_insert_post( $datas );
		if ( $p_id != false ) {
			update_post_meta( $p_id, 'motivation', 		stripslashes($_POST['motivation']) );
			update_post_meta( $p_id, 'url', 			esc_url($_POST['url']) );
			update_post_meta( $p_id, 'name',			stripslashes($_POST['name']) );
			update_post_meta( $p_id, 'email', 			stripslashes($_POST['email']) );
			update_post_meta( $p_id, 'type-de-site', 	stripslashes($_POST['type-de-site']) );
			
			include( ABSPATH . '/wp-admin/includes/admin.php' );
			media_handle_upload( 'screenshot', $p_id, array(), array('test_form' => false) );
			
			wp_die( 'Votre demande d\'ajout à la vitrine a bien été envoyé, l\'équipe de modération de la vitrine traitera au plus vite votre demande.' );
			exit();
		}
		
		return true;
	}
}

/**
 * Load the template index of the custom post type if the current taxonomy have only one type of objects...
 *
 * @return void
 * @author Amaury Balmer
 */
add_action('template_redirect', 'load_taxonomy_template', 15 );
function load_taxonomy_template() {
	if ( is_tax() ) {
		global $wp_query;
		
		$current_taxo = get_taxonomy($wp_query->query_vars["taxonomy"]);
		if ( is_array($current_taxo->object_type) && count($current_taxo->object_type) == 1 ) {
			$_post_type = current($current_taxo->object_type);
			//$wp_query->query_vars["post_type"] = $_post_type;
			// Post type name
			$templates = array( "archive-".$_post_type.".php" );

			// More generic views.
			array_push( $templates, 'archive.php', 'index.php' );

			locate_template( $templates, true );
			exit();
		}
	}
}
?>