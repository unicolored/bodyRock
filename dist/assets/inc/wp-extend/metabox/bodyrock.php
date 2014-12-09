<?php
// POSITION
function bodyrock_meta_box() {
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
function bodyrock_meta_options() {
    global $post;
    global $wpdb;

    if(defined('AI1EC_POST_TYPE')) wp_nonce_field( 'ai1ec', AI1EC_POST_TYPE );

    $custom = get_post_custom($post->ID);
    $post_attachment_infoshow = isset($custom["post_attachment_infoshow"][0]) ? $custom["post_attachment_infoshow"][0] : false;
    $post_source_name = isset($custom["post_source_name"][0]) ? $custom["post_source_name"][0] : false;
	$post_source_url = isset($custom["post_source_url"][0]) ? $custom["post_source_url"][0] : false;
	$post_views_count = isset($custom["post_views_count"][0]) ? $custom["post_views_count"][0] : false;

	echo '<h2>Options globales</h2>';
		echo a('table.form-table');
	echo a('tr');
		echo a('td');
		echo '<input name="post_attachment_infoshow" class="form-input pull-right" type="checkbox" value="1" '.($post_attachment_infoshow == 1 ? 'checked' : false).' />';
		echo 'Afficher les informations des fichiers joints <small>(à défaut, les informations sont masquées)</small>';
		echo z('td');
	echo z('tr');

	echo z('table');
	echo '<hr>';


	echo '<h2>Source de l\'article <small>(optionnel)</small></h2>';
	echo a('table.form-table');
	echo a('tr');
		echo a('th');
		echo 'Nom de la source';
		echo z('th');
		echo a('td');
		echo '<input name="post_source_name" class="form-input" value="'.$post_source_name.'" size="32" type="text" />';
		echo z('td');
	echo z('tr');

	echo a('tr');
		echo a('th');
		echo 'URL de la source';
		echo z('th');
		echo a('td');
		echo '<input name="post_source_url" class="form-input" value="'.$post_source_url.'" size="32" type="text" />';
		echo z('td');
	echo z('tr');

	echo z('table');
	echo '<hr>';

    echo '<p>Vous êtes sur un article <em>'.(get_post_format() != false ? get_post_format() : 'basique').'</em> vu ';
    echo '<input name="post_views_count" class="form-input" value="'.$post_views_count.'" size="4" type="text" /> fois</p>';

    if(get_post_format($post->ID)=='audio') {
        $audioType = 'sou'; // Par défaut

        $custom = get_post_custom($post->ID);

        $audioCode = isset($custom["audioCode"][0]) ? $custom["audioCode"][0] : false;
        $audioType = isset($custom["audioType"][0]) ? $custom["audioType"][0] : false;
        $audioHeight = isset($custom["audioHeight"][0]) ? $custom["audioHeight"][0] : false;

        $option_selected['sou'] = false;
        $option_selected[$audioType] = 'selected';

		?>

		<h2>Paramètres de l'audio</h2>

		<div class="mb_<?php echo $prefix ?>" id="mb_id_<?php echo $prefix ?>">

			<p>
				Indiquer le code et la source de la audio :
			</p>
			<p>
				<input name="audioCode" class="form-input" value="<?php echo $audioCode; ?>" size="16" type="text" />
				<select name="audioType" class="form-input">
					<option <?php echo $option_selected['sou']; ?> value="you">SoundCloud</option>
				</select>
			</p>
			<p class="howto">
				Coller uniquement le code de la audio et non le lien entier. Exemples : 88669527
			</p>
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

		<h2>Paramètres de la citation</h2>

		<a href="" target="_blank"><img src="/wp-content/themes/bodyrock/inc/metabox/citations/image.php?auteur=<?php echo $auteur; ?>&content=<?php echo $ligne1 . '<br />' . $ligne2 . '<br />' . $ligne3; ?>&font=<?php echo $mb_citation ?>" alt="Image manquante.<?php echo $mb_citation ?>" /></a>
		<br>
		<label>
			<select name="mb_citation" >
				<option <?php echo $option_selected['Balthazar']; ?> value="Balthazar">Balthazar</option>
				<option <?php echo $option_selected['DoppioOne']; ?> value="DoppioOne">DoppioOne</option>
				<option <?php echo $option_selected['RussoOne']; ?> value="RussoOne">Russo</option>
			</select> <small>Font</small> </label>
		<br>
		<label><small>Ligne 1</small>
			<input name="ligne1" value="<?php echo $ligne1; ?>" />
		</label>

		<br>
		<label><small>Ligne 2</small>
			<input name="ligne2" value="<?php echo $ligne2; ?>" />
		</label>
		<br>
		<label><small>Ligne 3</small>
			<input name="ligne3" value="<?php echo $ligne3; ?>" />
		</label>
		<br>
		<label><small>Ligne 4</small>
			<input name="ligne4" value="<?php echo $ligne4; ?>" />
		</label>
		<br>
		<label><small>Auteur</small>
			<input name="auteur" value="<?php echo $auteur; ?>" />
		</label>
		<?php
	}


	if(get_post_format($post->ID)=='video') {
		$videoType = 'you'; // Par défaut
		if(defined('AI1EC_POST_TYPE')) wp_nonce_field( 'ai1ec', AI1EC_POST_TYPE );
		$custom = get_post_custom($post->ID);

		$videoCode = isset($custom["videoCode"][0]) ? $custom["videoCode"][0] : false;
		$videoType = isset($custom["videoType"][0]) ? $custom["videoType"][0] : false;
		$videoHeight = isset($custom["videoHeight"][0]) ? $custom["videoHeight"][0] : false;
		$videoEmbed = isset($custom["videoEmbed"][0]) ? $custom["videoEmbed"][0] : false;

		$option_selected['vim'] = false;
		$option_selected['you'] = false;
		$option_selected[$videoType] = 'selected';
		?>

		<h2>Paramètres de la vidéo</h2>

		<div class="mb_<?php echo $prefix ?>" id="mb_id_<?php echo $prefix ?>">

			<p>
				Indiquer le code et la source de la vidéo :
			</p>
			<p>
			<input name="videoCode" class="form-input" value="<?php echo $videoCode; ?>" size="16" type="text" />
			<select name="videoType" class="form-input">
			<option <?php echo $option_selected['you']; ?> value="you">Youtube</option>
			<option <?php echo $option_selected['vim']; ?> value="vim">Viméo</option>
			</select>
			</p>
			<p class="howto">
				Coller uniquement le code de la video et non le lien entier. Exemples : D7IXiXxENEA ou 79329423
			</p>
			<p>Hauteur de la vidéo :
			<input name="videoHeight" class="form-input" value="<?php echo $videoHeight; ?>" size="5" type="text" /> px</p>
			<p class="howto">
				Laisser vide pour utiliser la valeur définie dans les options du thème.
			</p>
			<?php
			if ($videoCode!=false) {
				?>
				<p>
				<a href="http://senzu.fr/unicolored/images/videos/<?php echo $videoType?>/<?php echo $videoCode ?>.jpg" target="_blank"><img src="/senzu/<?php bloginfo('name') ?>/images/videos/<?php echo $videoType?>/<?php echo $videoCode ?>.jpg" alt="Image manquante." class="img-responsive" width="200" /></a>
				</p>
				<?php
			}
			?>
			<p>Code embed :
			<textarea name="videoEmbed" class="form-input" rows="5" cols="60"><?php echo esc_html($videoEmbed); ?></textarea></p>
			<p class="howto">
				Insérer le code complet embed de la vidéo.
			</p>
		</div>

	<?php
	}
}

// ENREGISTREMENT
function save_brmetas($post) {
	/*if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
        return;
    }*/

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return;
	}
	elseif (isset($_POST['post_attachment_infoshow'])) {
		//echo sanitize_post_field( 'post_views_count', $_POST["post_views_count"], $post, 'edit' );
		update_post_meta($post, "post_attachment_infoshow", $_POST["post_attachment_infoshow"]);
		update_post_meta($post, "post_source_name", $_POST["post_source_name"]);
		update_post_meta($post, "post_source_url", $_POST["post_source_url"]);
		update_post_meta($post, "post_views_count", $_POST["post_views_count"]);

		update_post_meta($post, "audioCode", $_POST["audioCode"]);
		update_post_meta($post, "audioType", $_POST["audioType"]);

		update_post_meta($post, "videoCode", $_POST["videoCode"]);
		update_post_meta($post, "videoType", $_POST["videoType"]);
		update_post_meta($post, "videoHeight", $_POST["videoHeight"]);
		//update_post_meta($post, "videoEmbed", $_POST["videoEmbed"]);
		// Save the textarea
    if ( isset( $_POST['videoEmbed'] ) ) {

        // WP's default allowed tags
        global $allowedtags;

        // allow iframe only in this instance
        $iframe = array( 'iframe' => array(
                            'src' => array (),
                            'width' => array (),
                            'height' => array (),
                            'frameborder' => array(),
                            'allowFullScreen' => array(), // add any other attributes you wish to allow
                            'mozallowfullscreen' => array(),
                            'webkitallowfullscreen' => array()
                             ) );

        $allowed_html = array_merge( $allowedtags, $iframe );

        // Sanitize user input.
        $my_data = wp_kses( $_POST['videoEmbed'], $allowed_html );

        //$my_data = $_POST['videoEmbed'];

        // Update the meta field in the database.
        update_post_meta( $post, 'videoEmbed', $my_data );

    }

		//echo $_POST["videoEmbed"]; die;

		update_post_meta($post, "mb_citation", $_POST["mb_citation"]);
		update_post_meta($post, "ligne1", $_POST["ligne1"]);
		update_post_meta($post, "ligne2", $_POST["ligne2"]);
		update_post_meta($post, "ligne3", $_POST["ligne3"]);
		update_post_meta($post, "ligne4", $_POST["ligne4"]);
		update_post_meta($post, "auteur", $_POST["auteur"]);
	}
}

/* FIN DE LA METABOX */

/////////////////////////////////////////////////////////////////////////////////////////////////////////
