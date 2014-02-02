<?php

// METABOX Wp extend /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Chargement des metabox pour l'édition des posts.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


require_once('metabox/bodyrock.php');
// require_once('metabox/citations.php');

require_once('metabox/videoCode.php');


// GET POST VIEWS /////////////////////////////////////////////
// Récupère le nombre de vue d'un post. La valeur est stockée en post_meta.
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
		if(get_post_format()=='audio') {
	        return "0 ".__('écoute',"bodyrock");
		}
		elseif(get_post_format()=='video') {
	        return "0 ".__('lecture',"bodyrock");
		}
		else return "0 ".__('vue',"bodyrock");
    }
	if(get_post_format()=='audio') {
		return $count." ".__('écoutes',"bodyrock");
	}
	elseif(get_post_format()=='video') {
		return $count." ".__('lectures',"bodyrock");
	}
	else return $count.' '.__('vues',"bodyrock");
}

// SET POST VIEWS /////////////////////////////////////////////
// Stocke le nombre de vue d'un post après l'avoir incrémenté.
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
?>