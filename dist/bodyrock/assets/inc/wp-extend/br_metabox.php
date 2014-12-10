<?php

// METABOX Wp extend /////////////////////////////////////////////////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Chargement de la metabox Bodyrock pour l'édition des posts.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

add_action("admin_init", "bodyrock_meta_box");
add_action("save_post", "save_brmetas");
add_action("save_draft", "save_brmetas");

// metabox/
add_action("admin_init", "bodyloop_meta_box");
add_action("save_post", "save_blmetas");
add_action("save_draft", "save_blmetas");

require 'metabox/bodyloop.php';
require 'metabox/bodyrock.php';

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Fonctions publiques qui modifient les metas de post :
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/

// POST VIEWS /////////////////////////////////////////////////////////////////////////////////////////
// GET /////////////////////////////////////////////
// Récupère le nombre de vue d'un post. La valeur est stockée en post_meta.
function getPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        if (get_post_format() == 'audio') {
            return "0 " . __('écoute', "bodyrock");
        } elseif (get_post_format() == 'video') {
            return "0 " . __('lecture', "bodyrock");
        } else
            return "0 " . __('vue', "bodyrock");
    }
    if (get_post_format() == 'audio') {
        return $count . " " . __('écoutes', "bodyrock");
    } elseif (get_post_format() == 'video') {
        return $count . " " . __('lectures', "bodyrock");
    } else
        return $count . ' ' . __('vues', "bodyrock");
}

// SET /////////////////////////////////////////////
// Stocke le nombre de vue d'un post après l'avoir incrémenté.
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
?>