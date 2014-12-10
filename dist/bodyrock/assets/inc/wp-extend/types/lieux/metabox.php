<?php
require_once('metabox-save.php');

// Creating the Custom Field Box
add_action("admin_init", "lieu_meta_box");   

function lieu_meta_box(){
    add_meta_box("lieuInfo-meta", "Options", "lieu_meta_options", "lieux", "side", "high");
    //$options_tmp=array('name' => __('Latitude <a href="http://universimmedia.pagesperso-orange.fr/geo/nievre.htm" target="_blank">Déterminer la position d\'une adresse</a>', 'bodyrock'), 'id' => 'mq_latitude', 'type' => 'text', ), array('name' => __('Longitude', 'bodyrock'), 'id' => 'mq_longitude', 'type' => 'text', ), array('name' => __('Type', 'bodyrock'), 'id' => 'mq_type', 'type' => 'select', 'options' => array('garage', 'agent')), array('name' => __('zindex : 102 par défaut. Calque sur lequel se trouve le marker, de 0 à 1000. Laisser vide si les marqueurs ne se superposent pas.', 'bodyrock'), 'id' => 'mq_zindex', 'type' => 'text', ), array('name' => __('Adresse', 'bodyrock'), 'id' => 'mq_content', 'type' => 'text', ), array('name' => __('Ville + Code Postal', 'bodyrock'), 'id' => 'mq_ville', 'type' => 'text', ), array('name' => __('Téléphone', 'bodyrock'), 'id' => 'mq_telephone', 'type' => 'text', );
}  

function lieu_meta_options(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $adresse = $custom["adresseLieu"][0];
        $cpostal = $custom["cpostal"][0];
        $ville = $custom["villeLieu"][0];
        $contact = $custom["contactLieu"][0];
        $telephone = $custom["telephoneLieu"][0];
        $siteweb = $custom["sitewebLieu"][0];
        $email = $custom["emailLieu"][0];
        $horaires = $custom["horairesLieu"][0];
        $mq_latitude = $custom["mq_latitude"][0];
        $mq_longitude = $custom["mq_longitude"][0];
       
?>
<label>ZIndex</label>
<input name="mq_zindex" value="<?php echo $mq_zindex; ?>" />
<br>
<label>Type</label>
<input name="mq_type" value="<?php echo $mq_type; ?>" />
<br>
Adresse <input value="<?php echo urlencode($adresse.' '.$cpostal.' '.$ville) ?>"> <a href="http://universimmedia.pagesperso-orange.fr/geo/nievre.htm?address=<?php echo urlencode($adresse.' '.$cpostal.' '.$ville) ?>#" target="_blank">Déterminer la position d\'une adresse</a>
<br>
<label>Latitude</label>
<input name="mq_latitude" value="<?php echo $mq_latitude; ?>" />
<br>
<label>Longitude</label>
<input name="mq_longitude" value="<?php echo $mq_longitude; ?>" />
<hr>
<label>Adresse :</label>
<input name="adresseLieu" value="<?php echo $adresse; ?>" />
<br>
<label>Code postal :</label>
<input name="cpostal" value="<?php echo $cpostal; ?>" />
<br>
<label>Ville :</label>
<input name="villeLieu" value="<?php echo $ville; ?>" />
<br>
<label>Contact :</label>
<input name="telephoneLieu" value="<?php echo $contact; ?>" />
<br>
<label>Téléphone :</label>
<input name="telephoneLieu" value="<?php echo $telephone; ?>" />
<br>
<label>Site Web :</label>
<input name="sitewebLieu" value="<?php echo $siteweb; ?>" />
<br>
<label>Email :</label>
<input name="emailLieu" value="<?php echo $email; ?>" />
<br>
<label>Horaires, jours d'ouverture :</label><textarea name="horairesLieu"><?php echo $horaires; ?></textarea>
<?php
}
?>