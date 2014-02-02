<?php
require_once('metabox-save.php');

// Creating the Custom Field Box
add_action("admin_init", "lieu_meta_box");   

function lieu_meta_box(){
    add_meta_box("lieuInfo-meta", "Options", "lieu_meta_options", "lieux", "side", "high");
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
?>
    <label>Adresse :</label><input name="adresseLieu" value="<?php echo $adresse; ?>" />
    <br>
    <label>Code postal :</label><input name="cpostal" value="<?php echo $cpostal; ?>" />
    <br>
    <label>Ville :</label><input name="villeLieu" value="<?php echo $ville; ?>" />
    <br>
    <label>Contact :</label><input name="telephoneLieu" value="<?php echo $contact; ?>" />
    <br>
    <label>Téléphone :</label><input name="telephoneLieu" value="<?php echo $telephone; ?>" />
    <br>
    <label>Site Web :</label><input name="sitewebLieu" value="<?php echo $siteweb; ?>" />
    <br>
    <label>Email :</label><input name="emailLieu" value="<?php echo $email; ?>" />
    <br>
    <label>Horaires, jours d'ouverture :</label><textarea name="horairesLieu"><?php echo $horaires; ?></textarea>
<?php
    }

?>