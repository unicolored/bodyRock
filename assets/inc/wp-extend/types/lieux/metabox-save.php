<?php
// Saving the Custom Data
add_action('save_post', 'save_lieu_infos'); 

function save_lieu_infos(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
    	update_post_meta($post->ID, "adresseLieu", $_POST["adresseLieu"]);
    	update_post_meta($post->ID, "cpostal", $_POST["cpostal"]);
    	update_post_meta($post->ID, "villeLieu", $_POST["villeLieu"]);
    	update_post_meta($post->ID, "contactLieu", $_POST["contactLieu"]);
    	update_post_meta($post->ID, "telephoneLieu", $_POST["telephoneLieu"]);
    	update_post_meta($post->ID, "sitewebLieu", $_POST["sitewebLieu"]);
    	update_post_meta($post->ID, "emailLieu", $_POST["emailLieu"]);
    	update_post_meta($post->ID, "horairesLieu", $_POST["horairesLieu"]);
        
        $options = array('mq_latitude', 'mq_longitude', 'mq_type', 'mq_zindex');
        foreach ($options as $O) {
            //          echo $O.' :: '.$_POST[$O].'<br>';
            update_post_meta(get_the_ID(), $O, sanitize_text_field($_POST[$O]));
        }
        
    }
}

?>