<?php
add_action("admin_init",    "videoCode_meta_box"    );
add_action("save_post",     "save_videoCode"        );
add_action("save_draft",    "save_videoCode"        ); 

////////////////////////////////////////////////////////////
$prefix = 'mb_videocode';

// POSITION
function videoCode_meta_box(){
	global $prefix;
    add_meta_box("videoCode-meta", "Vidéo", "videoCode_meta_options", "post", "normal", "high",
		array(
			array(
				'name' => __('Code','bodyrock'),
				'desc' => 'Le code de votre vidéo.',
				'id' => $prefix . '_videocode',
				'type' => 'text',
				'std' => ''
			),
			array(
            'name' => __('Type','bodyrock'),
            'id' => $prefix . '_videotype',
            'type' => 'select',
            'options' => array('Youtube', 'Vimeo')
        )
		));
}

// FORMULAIRE
function videoCode_meta_options( $post )
{
	global $prefix;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

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
function save_videoCode($post) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    }
    else {            
        update_post_meta(get_the_ID(), "videoCode", $_POST["videoCode"]);
        update_post_meta(get_the_ID(), "videoType", $_POST["videoType"]);
        update_post_meta(get_the_ID(), "videoHeight", $_POST["videoHeight"]);
    }
}