jQuery(document).ready(function() {
	jQuery("select[name$='type-demande']").change( function() {
		var new_val = jQuery(this).val();
		
		/*
		Supported cases :
			<div id="dialog_wpcom" title="WordPress.com">
			<div id="dialog_login" title="Identifiants perdus">
			<div id="dialog_abus" title="Déclarer un abus">
			<div id="dialog_partners" title="Partenariat">
			<div id="dialog_technique" title="Problème technique">
		*/
		if ( new_val == 'WordPress.com' ) {
			openDialog( 'dialog_wpcom' );
		} else if ( new_val == 'Identifiants perdus' ) {
			openDialog( 'dialog_login' );
		} else if ( new_val == 'Déclarer un abus' ) {
			openDialog( 'dialog_abus' );
		} else if ( new_val == 'Partenariat' ) {
			openDialog( 'dialog_partners' );
		} else if ( new_val == 'Problème technique' ) {
			openDialog( 'dialog_technique' );
		}
	});
	
	var flag = false;
	jQuery('#wpcf7-f1-p3-o1 form').submit(function() {
		var my_url = jQuery("input[name$='website']").val();
		
		if ( strpos(my_url, 'wordpress\.com') >= 0 && flag == false ) {
			openDialog( 'dialog_wpcom_input' );
			flag = true;
			return false;
		}
	});
});

function openDialog( id_destination ) {
	var my_dialog = jQuery('#'+id_destination).dialog({
		autoOpen: false,
		modal: true,
		width: 600,
		buttons: {
			"Ok": function() { 
				jQuery(this).dialog("close"); 
			}, 
			"Annuler": function() { 
				jQuery(this).dialog("close"); 
			} 
		}
	});
	
	my_dialog.dialog('open');
}

function strpos (haystack, needle, offset) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Onno Marsman    
    // +   bugfixed by: Daniel Esteban
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: strpos('Kevin van Zonneveld', 'e', 5);
    // *     returns 1: 14
    var i = (haystack + '').indexOf(needle, (offset || 0));
    return i;
}