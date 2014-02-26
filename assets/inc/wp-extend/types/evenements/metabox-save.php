<?php
// Saving the Custom Data
add_action('save_post', 'save_event_infos'); 

function save_event_infos(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
		$eventstartDate=$_POST["eventstartDate"];
		$eventendDate=($_POST["eventendDate"]==false ? $eventstartDate : $_POST["eventendDate"]);
		
    	update_post_meta($post->ID, "eventstartDate", $eventstartDate);
    	update_post_meta($post->ID, "eventendDate", $eventendDate);
    	update_post_meta($post->ID, "eventlieuId", $_POST["eventlieuId"]);
    	update_post_meta($post->ID, "sitewebEvent", $_POST["sitewebEvent"]);
    	update_post_meta($post->ID, "telephoneEvent", $_POST["telephoneEvent"]);
    	update_post_meta($post->ID, "gratuitEvent", $_POST["gratuitEvent"]);
    	update_post_meta($post->ID, "tarifsEvent", $_POST["tarifsEvent"]);
    	update_post_meta($post->ID, "horairesEvent", $_POST["horairesEvent"]);
    }
}

?>