<?php
$MB['slug'] = 'mb_citation';

/////////////////////

add_action("admin_init",    $MB['slug']."_meta_box"    );
add_action("save_post",     "save_".$MB['slug']        );
add_action("save_draft",    "save_".$MB['slug']        ); 

////////////////////////////////////////////////////////////

// POSITION
function mb_citation_meta_box(){
    add_meta_box("mb_citation-meta", "Citations", "mb_citation_meta_options", "post", "normal", "high");
}

// FORMULAIRE
function mb_citation_meta_options()
{
	global $post;
	global $wpdb;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
    
    $mb_citation = 'RussoOne'; // Par défaut
    $auteur = 'false';
    
    $option_selected['Balthazar'] = false;
    $option_selected['DoppioOne'] = false;
    $option_selected['RussoOne'] = false;

    $custom = get_post_custom($post->ID);
    $mb_citation = isset($custom["mb_citation"][0]) ? $custom["mb_citation"][0] : false;
    $ligne1 = isset($custom["ligne1"][0]) ? $custom["ligne1"][0] : false;
    $ligne2 = isset($custom["ligne2"][0]) ? $custom["ligne2"][0] : false;
    $ligne3 = isset($custom["ligne3"][0]) ? $custom["ligne3"][0] : false;
    $ligne4 = isset($custom["ligne4"][0]) ? $custom["ligne4"][0] : false;
    $auteur = isset($custom["auteur"][0]) ? $custom["auteur"][0] : false;
    
    $option_selected[$mb_citation] = 'selected';
    
    if(defined('AI1EC_POST_TYPE')) wp_nonce_field( 'ai1ec', AI1EC_POST_TYPE );
    if (get_post_format()=='quote') {
        ?>
        
        <a href="" target="_blank"><img src="/wp-content/themes/bodyrock/inc/metabox/citations/image.php?auteur=<?php echo $auteur; ?>&content=<?php echo $ligne1.'<br />'.$ligne2.'<br />'.$ligne3; ?>&font=<?php echo $mb_citation ?>" alt="Image manquante.<?php echo $mb_citation ?>" /></a>
        <br>
        <label>
        <select name="mb_citation" >
            <option <?php echo $option_selected['Balthazar']; ?> value="Balthazar">Balthazar</option>
            <option <?php echo $option_selected['DoppioOne']; ?> value="DoppioOne">DoppioOne</option>
            <option <?php echo $option_selected['RussoOne']; ?> value="RussoOne">Russo</option>
        </select>
        <small>Font</small>
        </label>
        <br>
        <label><small>Ligne 1</small> <input name="ligne1" value="<?php echo $ligne1; ?>" /></label>
        <br>
        <label><small>Ligne 2</small> <input name="ligne2" value="<?php echo $ligne2; ?>" /></label>
        <br>
        <label><small>Ligne 3</small> <input name="ligne3" value="<?php echo $ligne3; ?>" /></label>
        <br>
        <label><small>Ligne 4</small> <input name="ligne4" value="<?php echo $ligne4; ?>" /></label>
        <br>
        <label><small>Auteur</small> <input name="auteur" value="<?php echo $auteur; ?>" /></label>
        <?php
    }
}

// ENREGISTREMENT
function save_mb_citation(){
    global $post;
    
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    }
    else {            
        update_post_meta($post->ID, "mb_citation", $_POST["mb_citation"]);
        update_post_meta($post->ID, "ligne1", $_POST["ligne1"]);
        update_post_meta($post->ID, "ligne2", $_POST["ligne2"]);
        update_post_meta($post->ID, "ligne3", $_POST["ligne3"]);
        update_post_meta($post->ID, "ligne4", $_POST["ligne4"]);
        update_post_meta($post->ID, "auteur", $_POST["auteur"]);
    }
}