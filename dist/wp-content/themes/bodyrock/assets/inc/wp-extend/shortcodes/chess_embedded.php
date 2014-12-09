<?php


add_shortcode("chess", "chess_embedded");
add_action('init', 'add_chess_button'); 


function chess_embedded($atts, $content = null) {
	
	extract(shortcode_atts(array(  
		'value'            => $atts['value'], 
		'url'    		  => $atts['url']), 
		$atts));	
		
	return $value;
}

function add_chess_button() {  

   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
	 add_filter('mce_external_plugins', 'add_chess_plugin');  
	 add_filter('mce_buttons', 'register_chess_button');  
   }  
   
}  

function register_chess_button($buttons) { 
 
	array_push($buttons, "chessBtn");  
	return $buttons;  
	
}

function add_chess_plugin($plugin_array) {  

   $plugin_array['chessBtn'] = '/wp-content/themes/bodyrock/assets/inc/wp-extend/shortcodes/chess_embedded/shortcodes-buttons-tinymce-chess.js';  
   return $plugin_array;  
   
}  

?>