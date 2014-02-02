<?php
add_action("admin_init",    "bodyrock_meta_box"    );
add_action("save_post",     "save_brmetas"        );
add_action("save_draft",    "save_brmetas"        ); 

////////////////////////////////////////////////////////////

// POSITION
function bodyrock_meta_box(){
    add_meta_box("bodyrock-meta", "Bodyrock", "bodyrock_meta_options", "post", "normal", "high");
}

// FORMULAIRE
function bodyrock_meta_options()
{
	global $post;
	global $wpdb;
	
	if(defined('AI1EC_POST_TYPE')) wp_nonce_field( 'ai1ec', AI1EC_POST_TYPE );
	
	switch (get_post_format()) {
		default: $description='Vous êtes sur un article par défaut.'; break;
		case 'aside': $description='Vous êtes sur un article "en passant".'; break;
		case 'video':
			$description='Vous êtes sur un article "video".';
		break;
	}
	
	$custom = get_post_custom($post->ID);
	$post_views_count = isset($custom["post_views_count"][0]) ? $custom["post_views_count"][0] : false;
	
	echo $description;
	echo '<h4>Nombre de vues</h4>';
	echo '<input name="post_views_count" class="form-input" value="'.$post_views_count.'" size="16" type="text" />';
}

// ENREGISTREMENT
function save_brmetas($post) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    }
    else {            
        update_post_meta(get_the_ID(), "post_views_count", $_POST["post_views_count"]);
    }
}