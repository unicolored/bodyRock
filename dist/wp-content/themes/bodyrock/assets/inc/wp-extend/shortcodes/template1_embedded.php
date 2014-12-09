<?php
// Function that will return our Wordpress menu
// [video from="Vimeo" code="37617460"]
function template1_embedded($atts, $content = null) {
	extract(shortcode_atts(array(  
		'value'            => $atts['value'], 
		'url'    		  => $atts['url']), 
		$atts));
                        
		$embed=$value;
		
		return $embed;
}
//Create the shortcode
add_shortcode("tpl1", "template1_embedded");

// AJOUT DES BOUTONS DANS LE TINYMCE
//Step 1: Hook into WordPress
add_action('init', 'add_tpl_button'); 
//Step 2: Create Our Initialization Function
    function add_tpl_button() {  
       if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
       {  
         add_filter('mce_external_plugins', 'add_tpl_plugin');  
         add_filter('mce_buttons', 'register_tpl_button');  
       }  
    }  
//Step 3: Register Our Button
function register_tpl_button($buttons) {  
   array_push($buttons, "tplBtn");  
   return $buttons;  
}
//Step 4: Register Our TinyMCE Plugin
    function add_tpl_plugin($plugin_array) {  
       $plugin_array['tplBtn'] 		= '/wp-content/themes/bodyrock/assets/inc/wp-extend/shortcodes/template1_embedded/shortcodes-buttons-tinymce-template1.js';
	     
       return $plugin_array;  
    }  

?>