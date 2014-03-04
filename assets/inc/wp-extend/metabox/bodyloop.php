<?php
// BODYLOOP
function bodyloop_meta_box() {
    $values = array();

    foreach (getDefaultLoop() as $K => $V) {
        $values[] = array('name' => $K);
    }

    add_meta_box("bodyloop-meta", "Bodyloop", "bodyloop_meta_options", "page", "normal", "high");
    /*array(
     array('name' => __('Code', 'bodyrock'),'desc' => 'Vos options d\'articles Bodyloop.','id' => 'bl_bodyloop','type' => 'text', 'std' => ''),
     array('name' => __('Type', 'bodyrock'), 'id' => 'bl_videotype', 'type' => 'select', 'options' => array('Youtube', 'Vimeo')),
     array('name' => __('Type', 'bodyrock'), 'id' => 'bl_audiotype', 'type' => 'select', 'options' => array('SoundCloud'))
     */

}

// FORMULAIRE
function bodyloop_meta_options() {
    global $post;
    global $wpdb;

    if (defined('AI1EC_POST_TYPE'))
        wp_nonce_field('ai1ec', AI1EC_POST_TYPE);

    $custom = get_post_custom($post -> ID);
    $post_views_count = isset($custom["post_views_count"][0]) ? $custom["post_views_count"][0] : false;

    echo 'Vous êtes sur un article "' . get_post_format() . '".';
    echo '<h4>Nombre de vues</h4>';
    echo '<input name="post_views_count" class="form-input" value="' . $post_views_count . '" size="16" type="text" />';

    $videoType = 'you';
    // Par défaut

    $custom = get_post_custom($post -> ID);

    /*$videoCode = isset($custom["videoCode"][0]) ? $custom["videoCode"][0] : false;
     $videoType = isset($custom["videoType"][0]) ? $custom["videoType"][0] : false;
     $videoHeight = isset($custom["videoHeight"][0]) ? $custom["videoHeight"][0] : false;
     if (defined('AI1EC_POST_TYPE'))
     wp_nonce_field('ai1ec', AI1EC_POST_TYPE);

     $option_selected['vim'] = false;
     $option_selected['you'] = false;
     $option_selected[$videoType] = 'selected';

     echo '<div class="mb_' . $prefix . '" id="mb_id_' . $prefix . '">';
     echo '<p>Indiquer le code et la source de la vidéo :</p>';
     echo '<p><input name="videoCode" class="form-input" value="' . $videoCode . '" size="16" type="text" />';
     echo '<select name="videoType" class="form-input">';
     echo '<option ' . $option_selected['you'] . ' value="you">Youtube</option>';
     echo '<option ' . $option_selected['vim'] . ' value="vim">Viméo</option>';
     echo '</select>';
     echo '</p>';
     echo '<p class="howto">Coller uniquement le code de la video et non le lien entier. Exemples : D7IXiXxENEA ou 79329423</p>';
     echo '<p>Hauteur de la vidéo : <input name="videoHeight" class="form-input" value="' . $videoHeight . '" size="5" type="text" /> px</p>';
     echo '<p class="howto">Laisser vide pour utiliser la valeur définie dans les options du thème.</p>';

     if ($videoCode != false) {
     echo '<p><a href="http://senzu.fr/unicolored/images/videos/' . $videoType . '/' . $videoCode . '.jpg" target="_blank"><img src="/senzu/' . bloginfo('name') . '/images/videos/' . $videoType . '/' . $videoCode . '.jpg" alt="Image manquante." class="img-responsive" width="200" /></a></p>';
     }
     echo '</div>';*/
    include INC_PATH . 'wp-extend/widgets/bodyloop/bodyloop_form_page.php';
}

// ENREGISTREMENT
function save_blmetas($post) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    } else {
        echo sanitize_post_field('post_views_count', $_POST["post_views_count"], $post -> ID, 'edit');
        update_post_meta(get_the_ID(), "post_views_count", $_POST["post_views_count"]);

        /*update_post_meta(get_the_ID(), "audioCode", $_POST["audioCode"]);
         update_post_meta(get_the_ID(), "audioType", $_POST["audioType"]);

         update_post_meta(get_the_ID(), "videoCode", $_POST["videoCode"]);
         update_post_meta(get_the_ID(), "videoType", $_POST["videoType"]);
         update_post_meta(get_the_ID(), "videoHeight", $_POST["videoHeight"]);

         update_post_meta($post -> ID, "mb_citation", $_POST["mb_citation"]);
         update_post_meta($post -> ID, "ligne1", $_POST["ligne1"]);
         update_post_meta($post -> ID, "ligne2", $_POST["ligne2"]);
         update_post_meta($post -> ID, "ligne3", $_POST["ligne3"]);
         update_post_meta($post -> ID, "ligne4", $_POST["ligne4"]);
         update_post_meta($post -> ID, "auteur", $_POST["auteur"]);*/

        foreach (getDefaultLoop() as $K => $V) {
            //$values[] = array('name'=>$K);
            update_post_meta(get_the_ID(), $K, $_POST[$K]);
        }

    }
}

function doFormInput($string, $instance = false, $options = false, $after = false) {// 'Afficher un titre,afficher_titre ?'
    // Création de formulaire en parallèle avec bodyloop.php, le widget
    include 'bodyloop_functions_page.php';
    return $form_item . $after;
}

function getOptions($which) {
    switch($which) {
        default :
            return array();
            break;
        case 'filtres_categories' :
            return get_categories();
            break;
    }
}

/* FIN DE LA METABOX */

/////////////////////////////////////////////////////////////////////////////////////////////////////////
