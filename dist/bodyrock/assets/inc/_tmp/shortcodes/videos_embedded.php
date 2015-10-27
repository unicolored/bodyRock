<?php
/*
// Function that will return our Wordpress menu
// [video from="Vimeo" code="37617460"]
function thumbs_embedded($atts, $content = null) {
	extract(shortcode_atts(array(
		'from'            => $atts['from'],
		'code'    		  => $atts['code']),
		$atts));
 		$code=trim(strip_tags($code));
		$size="&w=300&q=100&s=1";
		switch($from) {
			case 'youtube': $embed='<img class="aligncenter" src="/wp-content/themes/bodyrock/inc/libs/timthumb/timthumb.php?src=http://img.youtube.com/vi/'.$code.'/0.jpg'.$size.'">'; break;
			case 'vimeo':
				$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$code.php"));


				$embed='<img class="aligncenter" src="/wp-content/themes/bodyrock/inc/libs/timthumb/timthumb.php?src='.$hash[0]['thumbnail_large'].''.$size.'">'; break;
		}
		echo $embed;
}
//Create the shortcode
add_shortcode("thumb", "thumbs_embedded");

function videos_embedded($atts, $content = null) {
	extract(shortcode_atts(array(
		'from'            => $atts['from'],
		'code'    		  => $atts['code']),
		$atts));
 $code=trim(strip_tags($code));

		switch($from) {
			case 'youtube': $embed='<iframe class="col-lg-12" height="480" src="//www.youtube.com/embed/'.$code.'?rel=0" frameborder="0" allowfullscreen></iframe>'; break;
			case 'vimeo':
				$embed='<iframe class="col-lg-12" height="480" src="http://player.vimeo.com/video/'.$code.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'; break;
		}
		return $embed;
}
//Create the shortcode
add_shortcode("video", "videos_embedded");

// AJOUT DES BOUTONS DANS LE TINYMCE
//Step 1: Hook into WordPress
add_action('init', 'add_button');
//Step 2: Create Our Initialization Function
    function add_button() {
       if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
       {
         add_filter('mce_external_plugins', 'add_plugin');
         add_filter('mce_buttons', 'register_button');
       }
    }
//Step 3: Register Our Button
function register_button($buttons) {
   array_push($buttons, "vimBtn");
   array_push($buttons, "youBtn");
   return $buttons;
}
//Step 4: Register Our TinyMCE Plugin
    function add_plugin($plugin_array) {
       $plugin_array['vimBtn'] = '/wp-content/themes/bodyrock/assets/inc/wp-extend/shortcodes/videos_embedded/shortcodes-buttons-tinymce-vim.js';
       $plugin_array['youBtn'] = '/wp-content/themes/bodyrock/assets/inc/wp-extend/shortcodes/videos_embedded/shortcodes-buttons-tinymce-you.js';

       return $plugin_array;
    }
*/
?>
