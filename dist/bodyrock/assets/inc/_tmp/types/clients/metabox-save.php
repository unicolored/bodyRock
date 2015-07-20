<?php
// Saving the Custom Data
add_action('save_post', 'save_client_infos'); 

function save_client_infos(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
		$clientstartDate=$_POST["clientstartDate"];
		$clientendDate=($_POST["clientendDate"]==false ? $clientstartDate : $_POST["clientendDate"]);
		
    	update_post_meta($post->ID, "clientstartDate", $clientstartDate);
    	update_post_meta($post->ID, "clientendDate", $clientendDate);
    	update_post_meta($post->ID, "clientlieuId", $_POST["clientlieuId"]);
    	update_post_meta($post->ID, "sitewebclient", $_POST["sitewebclient"]);
    	update_post_meta($post->ID, "telephoneclient", $_POST["telephoneclient"]);
    	update_post_meta($post->ID, "gratuitclient", $_POST["gratuitclient"]);
    	update_post_meta($post->ID, "tarifsclient", $_POST["tarifsclient"]);
    	update_post_meta($post->ID, "horairesclient", $_POST["horairesclient"]);
    }
}

?>