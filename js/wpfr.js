// Navigation
jQuery(document).ready( function() {
	jQuery('.main_menu a').click( function () {
		jQuery('.area').css({ display:"none" });
		var current_class = jQuery(this).attr("class");
		switch ( current_class ) {
			case 'com_area':
				jQuery('#aera_com').css({ display:"block" });
				break;
			case 'wp_mu_area':
				jQuery('#aera_mu').css({ display:"block" });
				break;
			case 'pro_area':
				jQuery('#aera_pro').css({ display:"block" });
				break;
			default:
				jQuery('#aera_wp').css({ display:"block" });
				break;
		}
		return false;
	});
});

// Commentaires
jQuery(document).ready( function() {

	var height_comm = jQuery(".comments_template").height(); 
	if ( height_comm > 700 ) {
		jQuery('#write_comment').css({ display: 'block' });
	
		var flag_com = false;
		jQuery('#write_comment').click( function () {
			
			if ( flag_com == false ) {
				jQuery('#write_comment').css({ top: '15px', bottom: 'auto' });
				jQuery('#col_right_comment').css({ bottom: '0px', right : '1px', position: "absolute" });
				flag_com = true;
			} else {
				jQuery('#write_comment').css({ bottom: '15px', top: 'auto' });
				jQuery('#col_right_comment').css({ bottom: 'auto', right : 'auto', position: "relative" });
				flag_com = false;
			}
			
			try{document.commentform.comment.focus();}catch(e){}
			
		});
	}
	
});
