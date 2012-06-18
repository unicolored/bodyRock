<?php
// Function that will return our Wordpress menu
// [video from="Vimeo" code="37617460"]
function custom_more($atts, $content = null) {
 		$embed='<!--more-->';
		echo $embed;
}
//Create the shortcode
add_shortcode("more", "custom_more");

?>