<?php
// Saving the Custom Data
add_action('save_post', 'save_videoCode'); 

function save_videoCode(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{		
    	update_post_meta($post->ID, "videoCode", $_POST["videoCode"]);
    	update_post_meta($post->ID, "videoType", $_POST["videoType"]);
    }
}

?>