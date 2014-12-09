<?php
// Function that will return our Wordpress menu
// [video from="Vimeo" code="37617460"]
function sound_embedded($atts, $content = null) {
	extract(shortcode_atts(array(  	'code'            => $atts['code']), 	$atts));
        
        $class="btn-warning";
        $glyph = "open";
        
        $value = $value == false ? $url : $value;
                
        if(strpos($url,'tumblr.com')) {
            $value="tumblr";
            $class="btn-info";
            $glyph = "picture";
        }
        
        $embed = '<iframe class="col-lg-12" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.$code.'&amp;color=db0000&amp;auto_play=true&amp;show_artwork=true"></iframe>';
		
		echo $embed;
}
//Create the shortcode
add_shortcode("advsound", "sound_embedded");

// AJOUT DES BOUTONS DANS LE TINYMCE
//Step 1: Hook into WordPress
add_action('init', 'add_sound_button'); 
//Step 2: Create Our Initialization Function
    function add_sound_button() {  
       if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
       {  
         add_filter('mce_external_plugins', 'add_sound_plugin');  
         add_filter('mce_buttons', 'register_sound_button');  
       }  
    }  
//Step 3: Register Our Button
function register_sound_button($buttons) {  
   array_push($buttons, "soundBtn");  
   return $buttons;  
}
//Step 4: Register Our TinyMCE Plugin
    function add_sound_plugin($plugin_array) {  
       $plugin_array['soundBtn'] = '/wp-content/themes/bodyrock/assets/inc/wp-extend/shortcodes/sound_embedded/shortcodes-buttons-tinymce-sounds.js';  
	   $plugin_array['chessBtn'] 	= '/wp-content/themes/bodyrock/assets/inc/wp-extend/shortcodes/chess_embedded/shortcodes-buttons-tinymce-chess.js';  
       return $plugin_array;  
    }  

?>