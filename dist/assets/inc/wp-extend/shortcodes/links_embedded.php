<?php


add_shortcode("advlink", "links_embedded");
add_action('init', 'add_link_button'); 


function links_embedded($atts, $content = null) {
	
	extract(shortcode_atts(array(  
		'value'            => $atts['value'], 
		'url'    		  => $atts['url']), 
		$atts));
        
        $class="btn-warning";
        $glyph = "play";
        $target = 'target="_blank"';
        $value = $value == false ? $url : $value;
        
        
        if(strpos($url,'youtube.com')) {
            if(strpos($url,'user')) {
                $value="Chaîne Youtube";
                $class="btn-primary";
                $glyph = "user";
            }
            else {
                $value="Vidéo Youtube";
                $class="btn-primary";
                $glyph = "video";
            }
        }
        
        if(strpos($url,'tumblr.com')) {
            $value="tumblr";
            $class="btn-info";
            $glyph = "picture";
        }
        
        if(strpos($url,'vimeo.com')) {
            $value="vimeo";
            $class="btn-info";
            $glyph = "video";
        }
        
        if(strpos($url,str_replace('http://','',get_bloginfo('url')))) {
            $target = '';
        }
        
		$embed='<p><a '.$target.' href="'.$url.'"><button class="btn btn-lg '.$class.'"><span class="glyphicon glyphicon-'.$glyph.'"></span> '.$value.'</button></a></p>';
		
		return $embed;
}

function add_link_button() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
	 add_filter('mce_external_plugins', 'add_link_plugin');  
	 add_filter('mce_buttons', 'register_link_button');  
   }  
}  

function register_link_button($buttons) {  
   array_push($buttons, "linkBtn");  
   return $buttons;  
}

function add_link_plugin($plugin_array) {  
   $plugin_array['linkBtn'] 	= '/wp-content/themes/bodyrock/assets/inc/wp-extend/shortcodes/links_embedded/shortcodes-buttons-tinymce-links.js';  
   return $plugin_array;  
}  

?>