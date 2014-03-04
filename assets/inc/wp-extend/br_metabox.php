<?php

// METABOX Wp extend /////////////////////////////////////////////

/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/
// Chargement de la metabox Bodyrock pour l'édition des posts.
/*//**//**//**//*//**//**//**//*//**//**//**//*//**//**//**/


add_action("admin_init",    "bodyrock_meta_box"    );
add_action("save_post",     "save_brmetas"        );
add_action("save_draft",    "save_brmetas"        );

add_action("admin_init",    "bodyloop_meta_box"    );
add_action("save_post",     "save_blmetas"        );
add_action("save_draft",    "save_blmetas"        );

require 'metabox/bodyloop.php';

////////////////////////////////////////////////////////////

// POSITION
function bodyrock_meta_box(){
    add_meta_box("bodyrock-meta", "Bodyrock", "bodyrock_meta_options", "post", "normal", "high",
		array(
			array(
				'name' => __('Code','bodyrock'),
				'desc' => 'Vos options d\'articles Bodyrock.',
				'id' => 'br_bodyrock',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => __('Type','bodyrock'),
				'id' => 'br_videotype',
				'type' => 'select',
				'options' => array('Youtube', 'Vimeo')
        	),
			array(
				'name' => __('Type','bodyrock'),
				'id' => 'br_audiotype',
				'type' => 'select',
				'options' => array('SoundCloud')
	        )
		));
}

// FORMULAIRE
function bodyrock_meta_options()
{
	global $post;
	global $wpdb;
	
	if(defined('AI1EC_POST_TYPE')) wp_nonce_field( 'ai1ec', AI1EC_POST_TYPE );
	
	$custom = get_post_custom($post->ID);
	$post_views_count = isset($custom["post_views_count"][0]) ? $custom["post_views_count"][0] : false;
	
	echo 'Vous êtes sur un article "'.get_post_format().'".';
	echo '<h4>Nombre de vues</h4>';
	echo '<input name="post_views_count" class="form-input" value="'.$post_views_count.'" size="16" type="text" />';
	
	if(get_post_format($post->ID)=='audio') {		
		$audioType = 'sou'; // Par défaut
	
		$custom = get_post_custom($post->ID);
		
		$audioCode = isset($custom["audioCode"][0]) ? $custom["audioCode"][0] : false;
		$audioType = isset($custom["audioType"][0]) ? $custom["audioType"][0] : false;
		$audioHeight = isset($custom["audioHeight"][0]) ? $custom["audioHeight"][0] : false;
	
		$option_selected['sou'] = false;
		$option_selected[$audioType] = 'selected';
		?>
		<h1>Audio</h1>
		<div class="mb_<?php echo $prefix ?>" id="mb_id_<?php echo $prefix ?>">

			<p>Indiquer le code et la source de la audio :</p>
			<p>
			<input name="audioCode" class="form-input" value="<?php echo $audioCode; ?>" size="16" type="text" />
			<select name="audioType" class="form-input">
				<option <?php echo $option_selected['sou']; ?> value="you">SoundCloud</option>
			</select>
			</p>
			<p class="howto">Coller uniquement le code de la audio et non le lien entier. Exemples : 88669527</p>
		</div>

		<?php
	}
	
    if (get_post_format()=='quote') {
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
	if(get_post_format($post->ID)=='video') {		
		$videoType = 'you'; // Par défaut
	
		$custom = get_post_custom($post->ID);
		
		$videoCode = isset($custom["videoCode"][0]) ? $custom["videoCode"][0] : false;
		$videoType = isset($custom["videoType"][0]) ? $custom["videoType"][0] : false;
		$videoHeight = isset($custom["videoHeight"][0]) ? $custom["videoHeight"][0] : false;
		if(defined('AI1EC_POST_TYPE')) wp_nonce_field( 'ai1ec', AI1EC_POST_TYPE );
	
		$option_selected['vim'] = false;
		$option_selected['you'] = false;
		$option_selected[$videoType] = 'selected';
		?>

		<div class="mb_<?php echo $prefix ?>" id="mb_id_<?php echo $prefix ?>">

			<p>Indiquer le code et la source de la vidéo :</p>
			<p>
			<input name="videoCode" class="form-input" value="<?php echo $videoCode; ?>" size="16" type="text" />
			<select name="videoType" class="form-input">
				<option <?php echo $option_selected['you']; ?> value="you">Youtube</option>
				<option <?php echo $option_selected['vim']; ?> value="vim">Viméo</option>
			</select>
			</p>
			<p class="howto">Coller uniquement le code de la video et non le lien entier. Exemples : D7IXiXxENEA ou 79329423</p>
			<p>Hauteur de la vidéo : 
			<input name="videoHeight" class="form-input" value="<?php echo $videoHeight; ?>" size="5" type="text" /> px</p>
			<p class="howto">Laisser vide pour utiliser la valeur définie dans les options du thème.</p>
			<?php
			if ($videoCode!=false) { ?>
			<p>
				<a href="http://senzu.fr/unicolored/images/videos/<?php echo $videoType?>/<?php echo $videoCode ?>.jpg" target="_blank"><img src="/senzu/<?php bloginfo('name') ?>/images/videos/<?php echo $videoType?>/<?php echo $videoCode ?>.jpg" alt="Image manquante." class="img-responsive" width="200" /></a>		
			</p>
			<?php
			} ?>
		</div>

		<?php
	}
}

// ENREGISTREMENT
function save_brmetas($post) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    }
    else {
		echo sanitize_post_field( 'post_views_count', $_POST["post_views_count"], $post->ID, 'edit' );
        update_post_meta(get_the_ID(), "post_views_count", $_POST["post_views_count"]);
		
        update_post_meta(get_the_ID(), "audioCode", $_POST["audioCode"]);
        update_post_meta(get_the_ID(), "audioType", $_POST["audioType"]);
		
        update_post_meta(get_the_ID(), "videoCode", $_POST["videoCode"]);
        update_post_meta(get_the_ID(), "videoType", $_POST["videoType"]);
        update_post_meta(get_the_ID(), "videoHeight", $_POST["videoHeight"]);
		
        update_post_meta($post->ID, "mb_citation", $_POST["mb_citation"]);
        update_post_meta($post->ID, "ligne1", $_POST["ligne1"]);
        update_post_meta($post->ID, "ligne2", $_POST["ligne2"]);
        update_post_meta($post->ID, "ligne3", $_POST["ligne3"]);
        update_post_meta($post->ID, "ligne4", $_POST["ligne4"]);
        update_post_meta($post->ID, "auteur", $_POST["auteur"]);
    }
}

/* FIN DE LA METABOX */

/////////////////////////////////////////////////////////////////////////////////////////////////////////

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